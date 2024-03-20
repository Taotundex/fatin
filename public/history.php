<?php
session_start();
include "connect.php";

$name = $_SESSION['name'];

if(!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

$select_user = mysqli_query($conn, "SELECT `date`, `doctorName`, `department`, `time`, `diagnosis`, `instruction` FROM `appointment` WHERE `name` = '$name' ");
$data = array();

if ($select_user->num_rows > 0) {
    while($row = $select_user->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

// Encode data into JSON
$data_json = json_encode($data);

// Pass data to your JavaScript API
echo "<script>var apiData = $data_json;</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="board.css">
    <link rel="stylesheet" href="media.css">
    <link rel="shortcut icon" href="images/Group 2.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/be0461b2be.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>
<body>
    <div class="dashboard">
        <div class="row g-lg-3 g-md-3 g-0">
            <div class="col col-lg-1 col-md-11 col-12">
                <div class="sidebar">
                    <div class="logo">
                        <img src="images/Vector.png" width="100%" alt="">
                    </div>
                    <ul>
                        <li><a href="dashboard.php"><i class="bi bi-grid"></i></a></li>
                        <li><a href="history.php" class="active"><i class="bi bi-clock-history"></i></a></li>
                        <li><a href="chat.php#last"><i class="bi bi-chat-left"></i></a></li>
                        <li><a href="setting.php"><i class="bi bi-gear"></i></a></li>
                        <li><a href="logout.php" class="d-flex flex-column text-center"><i class="bi bi-upload"></i>Log out</a></li>
                    </ul>
                </div>
            </div>
            <div class="col col-lg-11 col-md-11 col-12">
              <div class="body">
                <div class="heading d-lg-none d-md-none d-block d-flex align-items-center justify-content-between py-3 px-4">
                    <div class="logo">
                        <img src="images/Vector.png" width="100%" alt="">
                    </div>
                    <a href="setting.php" class="text-decoration-none"><i class="bi bi-person"></i></a>
                </div>
                <div class="bottombar d-lg-none d-md-none d-block p-3 shadow-sm">
                    <ul class="d-flex justify-content-between align-items-center">
                        <li><a href="dashboard.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-grid"></i>Dashboard</a></li>
                        <li><a href="history.php" class="d-flex flex-column text-center gap-2 active"><i class="bi bi-clock-history"></i>History</a></li>
                        <li><a href="chat.php#last" class="d-flex flex-column text-center gap-2"><i class="bi bi-chat-left"></i>Chat</a></li>
                        <li><a href="setting.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-gear"></i>Setting</a></li>
                        <li><a href="logout.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-upload"></i>Log out</a></li>
                    </ul>
                </div>
                    <div class="table-container py-lg-5 py-md-4 py-3 px-3">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th><button id="date">Date</button></th>
                                    <th><button id="doctorName">Doctor Name</button></th>
                                    <th><button id="department">Department</button></th>
                                    <th><button id="time">Time</button></th>
                                    <th><button id="diagnosis">Diagnosis</button></th>
                                    <th><button id="instructions">Instructions</button></th>
                                </tr>
                            </thead>
                            <tbody id="table-content"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    const tableContent = document.getElementById("table-content");
    const tableButtons = document.querySelectorAll("th button");
    
    const createRow = (obj) => {
        const row = document.createElement("tr");
        const objKeys = Object.keys(obj);
        objKeys.map((key) => {
            const cell = document.createElement("td");
            cell.setAttribute("data-attr", key);
            cell.innerHTML = obj[key];
            row.appendChild(cell);
        });
        return row;
    };
    
    const getTableContent = (data) => {
        data.map((obj) => {
            const row = createRow(obj);
            tableContent.appendChild(row);
        });
    };
    
    const sortData = (data, param, direction = "asc") => {
        tableContent.innerHTML = '';
        const sortedData =
            direction == "asc"
            ? [...data].sort(function(a, b) {
                if (a[param] < b[param]) {
                    return -1;
                }
                if (a[param] > b[param]) {
                    return 1;
                }
                return 0;
            })
            : [...data].sort(function(a, b) {
                if (b[param] < a[param]) {
                    return -1;
                }
                if (b[param] > a[param]) {
                    return 1;
                }
                return 0;
            });
    
        getTableContent(sortedData);
    };
    
    const resetButtons = (event) => {
        [...tableButtons].map((button) => {
            if (button !== event.target) {
                button.removeAttribute("data-dir");
            }
        });
    };
    
    window.addEventListener("load", () => {
        getTableContent(apiData);
    
        [...tableButtons].map((button) => {
            button.addEventListener("click", (e) => {
                resetButtons(e);
                if (e.target.getAttribute("data-dir") == "desc") {
                    sortData(apiData, e.target.id, "desc");
                    e.target.setAttribute("data-dir", "asc");
                } else {
                    sortData(apiData, e.target.id, "asc");
                    e.target.setAttribute("data-dir", "desc");
                }
            });
        });
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>