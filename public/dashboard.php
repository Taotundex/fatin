<?php
    session_start();
    include "connect.php";
    
    $name = $_SESSION['name'];
        
    if(!isset($_SESSION['name'])) {
            header("Location: login.php");
            exit();
    }
    
    $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE `name`='$name'");
    $user = mysqli_fetch_assoc($select_user);

    $select_appoint = mysqli_query($conn, "SELECT * FROM `appointment` WHERE `name`='$name'");
    // $appoint = mysqli_fetch_assoc($select_appoint);

    
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
    <style>
        .charts {
            border-radius: 20px;
        }
        .chart {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
            width: 100%;
        }
        .chart canvas {
            height: 250px !important;
        }
        .chart h2 {
            margin-bottom: 5px;
            font-size: 20px;
            color: #0077B6;
        }
        .slid{
            height: 100vh;
            overflow-y: scroll;
        }
        .slid::-webkit-scrollbar{
            display: none;
        }
        @media screen and (max-width: 767px) {
            .slid{
                height: 100%;
                overflow-y: auto;
            }
            .slid::-webkit-scrollbar{
                display: none;
            }            
        }
    </style>
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
                        <li><a href="dashboard.php" class="active"><i class="bi bi-grid"></i></a></li>
                        <li><a href="history.php"><i class="bi bi-clock-history"></i></a></li>
                        <li><a href="message.php#last"><i class="bi bi-chat-left"></i></a></li>
                        <li><a href="setting.php"><i class="bi bi-gear"></i></a></li>
                        <li><a href="logout.php" class="d-flex flex-column text-center"><i class="bi bi-upload"></i>Log out</a></li>
                    </ul>
                </div>
            </div>
            <div class="col col-lg-11 col-md-11 col-12">
                <div class="body mb-lg-0 mb-md-0 mb-5">
                    <div class="heading d-lg-none d-md-none d-block d-flex align-items-center justify-content-between py-3 px-4">
                        <div class="logo">
                            <img src="images/Vector.png" width="100%" alt="">
                        </div>
                        <a href="setting.php" class="text-decoration-none"><i class="bi bi-person"></i></a>
                    </div>
                    <div class="bottombar d-lg-none d-md-none d-block p-3 shadow-sm">
                        <ul class="d-flex justify-content-between align-items-center">
                            <li><a href="dashboard.php" class="d-flex flex-column text-center gap-2 active"><i class="bi bi-grid"></i>Dashboard</a></li>
                            <li><a href="history.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-clock-history"></i>History</a></li>
                            <li><a href="message.php#last" class="d-flex flex-column text-center gap-2"><i class="bi bi-chat-left"></i>Chat</a></li>
                            <li><a href="setting.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-gear"></i>Setting</a></li>
                            <li><a href="logout.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-upload"></i>Log out</a></li>
                        </ul>
                    </div>
                    <div class="row g-4">
                        <div class="col col-lg-4 col-md-6 col-12 slid">
                            <div class="row py-lg-5 py-md-5 py-3 px-0 g-4">
                                <div class="col col-12">
                                    <div class="profilepicture shadow-sm text-center px-lg-4 p-md-4 p-3 py-lg-5 py-md-5 py-4">
                                        <div class="img mt-2">
                                            <?php
                                                if(empty($user["profilePicture"])){
                                                    ?>
                                                    <i style="font-size: 150px; height: 150px; width: 150px; border: 1px solid #0077B6; border-radius: 10px; color: #0077B6;" class="bi bi-person-fill d-flex align-items-center justify-content-center mx-auto"></i>
                                                    <?php
                                                }
                                                else {
                                                ?>
                                                    <img style="object-fit: cover; object-position: center;" src="upload/<?php echo $user['profilePicture'];?>" width="100%" alt="">
                                                <?php }
                                            ?>
                                        </div>
                                        <div class="name my-3">
                                            <h3><?php echo $user['name']?></h3>
                                            <h4>Age: <span><?php echo $user['age']?></span></h4>
                                            <a href="setting.php"><button>Update</button></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-12">
                                    <div class="info shadow-sm p-4">
                                        <h3>Information:</h3>
                                        <div class="grid">
                                            <h4>Gender:</h4>
                                            <p><?php echo $user['gender']?></p>
                                        </div>
                                        <div class="grid">
                                            <h4>Blood Type:</h4>
                                            <p><?php echo $user['bloodtype']?></p>
                                        </div>
                                        <div class="grid">
                                            <h4>Allergies:</h4>
                                            <p><?php echo $user['allergies']?></p>
                                        </div>
                                        <div class="grid">
                                            <h4>Diseases:</h4>
                                            <p><?php echo $user['diseases']?></p>
                                        </div>
                                        <div class="grid">
                                            <h4>Height:</h4>
                                            <p><?php echo $user['height']?>m</p>
                                        </div>
                                        <div class="grid">
                                            <h4>Weight:</h4>
                                            <p><?php echo $user['weight']?>kg</p>
                                        </div>
                                        <div class="grid">
                                            <h4>Patient ID:</h4>
                                            <p><?php echo $user['patientId']?></p>
                                        </div>
                                        <div class="grid">
                                            <h4>Last Visit:</h4>
                                            <p><?php echo $user['lastVisit']?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-5 col-md-6 col-12 slid">
                            <div class="row gx-3 gy-4 py-lg-5 py-md-5 py-3 px-0">
                                <div class="col col-lg-4 col-md-6 col-6">
                                    <div class="rate bg-white py-3 px-2 shadow-sm text-center">
                                        <div class="img">
                                            <img src="images/streamline_heart-rate-pulse-graph-solid.png" width="100%" alt="">
                                        </div>
                                        <div class="details">
                                            <h6>Heart Rate</h6>
                                            <h4><?php echo $user['heartRate']?><span>bpm</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-4 col-md-6 col-6">
                                    <div class="rate bg-white py-3 px-2 shadow-sm text-center">
                                        <div class="img">
                                            <img src="images/cbi_outdoor-motion-sensor-temperature.png" width="100%" alt="">
                                        </div>
                                        <div class="details">
                                            <h6>Body Temperature</h6>
                                            <h4><?php echo $user['temperature']?><span><sup>o</sup>C</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-4 col-md-6 col-6 mx-auto">
                                    <div class="rate bg-white py-3 px-2 shadow-sm text-center">
                                        <div class="img">
                                            <img src="images/fluent-emoji-flat_drop-of-blood.png" width="100%" alt="">
                                        </div>
                                        <div class="details">
                                            <h6>Glucose</h6>
                                            <h4><?php echo $user['glucose']?><span>mg/dl</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-12 col-md-12 col-12">
                                    <div class="rate bg-white p-4 shadow-sm">
                                        <h3>Test Reports</h3>
                                        <div class="row g-lg-3 g-2">
                                            <div class="col col-lg-6 col-md-6 col-12">
                                                <div class="d-flex gap-2 align-items-center scan">
                                                    <i class="fa-solid fa-clipboard-list one"></i>
                                                    <div class="nam">
                                                        <h4>CT scan -Full body</h4>
                                                        <p><?php echo $user['bodyScan']?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-12">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <i class="fa-solid fa-clipboard-list two"></i>
                                                    <div class="nam">
                                                        <h4>Creatine Kinase T</h4>
                                                        <p><?php echo $user['creatineKinase']?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-12 col-md-12 col-12">
                                    <div class="graph bg-white shadow-sm charts">
                                        <div class="chart">
                                            <h2 style="text-align: left !important;">Activity</h2>
                                            <div>
                                                <canvas id="lineChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-3 col-md-6 col-12 py-lg-5 py-md-5 py-3 px-0 slid">
                            <div class="appoint bg-white shadow-sm py-4 px-3">
                                <h3>Doctor Appointments</h3>
                                <div class="cal">
                                    <div class="wrapper shadow-sm py-3 px-3">
                                        <header>
                                            <p class="current-date"></p>
                                            <div class="icons">
                                                <span id="prev" class="material-symbols-rounded">chevron_left</span>
                                                <span id="next" class="material-symbols-rounded">chevron_right</span>
                                            </div>
                                        </header>
                                        <div class="calendar">
                                            <ul class="weeks">
                                                <li>Sun</li>
                                                <li>Mon</li>
                                                <li>Tue</li>
                                                <li>Wed</li>
                                                <li>Thu</li>
                                                <li>Fri</li>
                                                <li>Sat</li>
                                            </ul>
                                            <ul class="days"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="listing">
                                    <?php
                                        while ($appoint = mysqli_fetch_assoc($select_appoint)) {
                                            ?>
                                            <div class="d-flex align-items-center gap-3 p-3 shadow-sm bg-white">
                                                <div class="img">
                                                    <?php
                                                    if ($appoint['department'] == "cardiology"){
                                                        echo "<img src='images/streamline_heart-rate-pulse-graph-solid.png' width='100%' alt=''>";
                                                    }
                                                    else if ($appoint['department'] == "dentist"){
                                                        echo '<img src="images/fluent_dentist-12-filled.png" width="100%" alt="">';
                                                    }
                                                    else if ($appoint['department'] == "orthopaedist"){
                                                        echo '<img src="images/fluent-emoji-flat_leg.png" width="100%" alt="">';
                                                    }
                                                    else if ($appoint['department'] == "surgeon"){
                                                        echo '<img src="images/noto_anatomical-heart.png" width="100%" alt="">';
                                                    }
                                                    else if ($appoint['department'] == "optician"){
                                                        echo '<img src="images/fxemoji_glasses.png" width="100%" alt="">';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="content">
                                                    <h4 style="text-transform: capitalize;"><?php echo $appoint['department'];?></h4>
                                                    <p style="text-transform: capitalize;"><?php echo $appoint['doctorName'];?></p>
                                                </div>
                                                <div class="time">
                                                    <p><?php echo $appoint['time'];?></p>
                                                </div>
                                            </div>
                                        <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script>
        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Earnings',
                    data: [2050, 1900, 2100, 2800, 1800, 2000, 2500, 2600, 2450, 1950, 2300, 2900],
                    backgroundColor: [
                        'rgba(85,85,85, 1)'
                    ],
                    borderColor: 'rgb(41, 155, 99)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>