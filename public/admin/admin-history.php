<?php
    session_start();
    include "../connect.php";
    
    $name = $_SESSION['name'];
        
    if(!isset($_SESSION['name'])) {
            header("Location: ../login.php");
            exit();
    }

    
    $select_user = mysqli_query($conn, "SELECT * FROM `appointment`");
    

    
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../board.css">
    <link rel="stylesheet" href="../media.css">
    <link rel="shortcut icon" href="../images/Group 2.png" type="image/x-icon">
    <link rel="stylesheet" href="admin.css">
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
            <div class="col col-lg-1 col-md-1 col-12">
                <div class="sidebar">
                    <div class="logo">
                        <img src="../images/Vector.png" width="100%" alt="">
                    </div>
                    <ul>
                        <li><a href="index.php"><i class="bi bi-grid"></i></a></li>
                        <li><a href="admin-history.php" class="active"><i class="bi bi-clock-history"></i></a></li>
                        <!-- <li><a href="admin-message.php"><i class="bi bi-chat-left"></i></a></li> -->
                        <!-- <li><a href="admin-setting.php"><i class="bi bi-gear"></i></a></li> -->
                        <li><a href="../logout.php" class="d-flex flex-column text-center"><i class="bi bi-upload"></i>Log out</a></li>
                    </ul>
                </div>
            </div>
            <div class="col col-lg-11 col-md-11 col-12">
                <div class="body mb-lg-0 mb-md-0 mb-5">
                  <div class="heading d-lg-none d-md-none d-block d-flex align-items-center justify-content-between py-3 px-4">
                      <div class="logo">
                          <img src="../images/Vector.png" width="100%" alt="">
                      </div>
                      <!-- <a href="admin-setting.php" class="text-decoration-none"><i class="bi bi-person"></i></a> -->
                  </div>
                  <div class="bottombar d-lg-none d-md-none d-block p-3 shadow-sm">
                      <ul class="d-flex justify-content-between align-items-center">
                          <li><a href="index.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-grid"></i>Dashboard</a></li>
                          <li><a href="admin-history.php" class="d-flex flex-column text-center gap-2 active"><i class="bi bi-clock-history"></i>History</a></li>
                          <!-- <li><a href="admin-message.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-chat-left"></i>Chat</a></li> -->
                          <!-- <li><a href="admin-setting.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-gear"></i>Setting</a></li> -->
                          <li><a href="../logout.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-upload"></i>Log out</a></li>
                      </ul>
                  </div>

                    <div class="admin-table">
                        <table class="table caption-top text-center">
                            <caption class="fw-bolder fs-2">History</caption>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Doctor Name</th>
                                    <th>Department</th>
                                    <th>Time</th>
                                    <th>Diagnosis</th>
                                    <th>Instructions</th>
                                </tr>
                            </thead>
                            <?php
                                    while ($user = mysqli_fetch_assoc($select_user)) {
                                        ?>
                            <tbody>
                                <tr>
                                    <th scope="row"><?php echo $user['id'];?></th>
                                    <td><?php echo $user['name'];?></td>
                                    <td><?php echo $user['date'];?></td>
                                    <td><?php echo $user['doctorName'];?></td>
                                    <td><?php echo $user['department'];?></td>
                                    <td><?php echo $user['time'];?></td>
                                    <td><?php echo $user['diagnosis'];?></td>
                                    <td><?php echo $user['instruction'];?></td>
                                </tr>
                            </tbody>
                            <?php }?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>