<?php
    session_start();
    include "../connect.php";
    
    $name = $_SESSION['name'];
        
    if(!isset($_SESSION['name'])) {
            header("Location: ../login.php");
            exit();
    }
    
    $select_user = mysqli_query($conn, "SELECT * FROM `user`");
    // $user = mysqli_fetch_assoc($select_user);

    
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
                        <li><a href="index.php" class="active"><i class="bi bi-grid"></i></a></li>
                        <li><a href="admin-history.php"><i class="bi bi-clock-history"></i></a></li>
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
                          <li><a href="index.php" class="d-flex flex-column text-center gap-2 active"><i class="bi bi-grid"></i>Dashboard</a></li>
                          <li><a href="admin-history.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-clock-history"></i>History</a></li>
                          <!-- <li><a href="admin-message.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-chat-left"></i>Chat</a></li> -->
                          <!-- <li><a href="admin-setting.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-gear"></i>Setting</a></li> -->
                          <li><a href="../logout.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-upload"></i>Log out</a></li>
                      </ul>
                  </div>
                    <div class="admin-table">
                        <table class="table caption-top text-center">
                            <caption class="fw-bolder fs-2">List of all users</caption>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fullname</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Phone number</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Blood Type</th>
                                    <th scope="col">Allergies</th>
                                    <th scope="col">Diseases</th>
                                    <th scope="col">Height</th>
                                    <th scope="col">Weight</th>
                                    <th scope="col">Heart Rate</th>
                                    <th scope="col">Body Temperature</th>
                                    <th scope="col">Glucode</th>
                                    <th scope="col">Body Scan</th>
                                    <th scope="col">Creatine Kinase</th>
                                    <th scope="col">Patient ID</th>
                                    <th scope="col">Last Visit</th>
                                    <th scope="col">Chat user</th>
                                    <th scope="col">Appointment</th>
                                    <th scope="col">Update Details</th>
                                </tr>
                            </thead>
                            <?php
                                    while ($user = mysqli_fetch_assoc($select_user)) {
                                        ?>
                            <tbody>
                                <tr>
                                    <th scope="row"><?php echo $user['id'];?></th>
                                    <td><?php echo $user['name'];?></td>
                                    <td><?php echo $user['email'];?></td>
                                    <td><?php echo $user['username'];?></td>
                                    <td><?php echo $user['phoneNumber'];?></td>
                                    <td><?php echo $user['age'];?></td>
                                    <td><?php echo $user['gender'];?></td>
                                    <td><?php echo $user['bloodtype'];?></td>
                                    <td><?php echo $user['allergies'];?></td>
                                    <td><?php echo $user['diseases'];?></td>
                                    <td><?php echo $user['height'];?></td>
                                    <td><?php echo $user['weight'];?></td>
                                    <td><?php echo $user['heartRate'];?></td>
                                    <td><?php echo $user['temperature'];?></td>
                                    <td><?php echo $user['glucose'];?></td>
                                    <td><?php echo $user['bodyScan'];?></td>
                                    <td><?php echo $user['creatineKinase'];?></td>
                                    <td><?php echo $user['patientId'];?></td>
                                    <td><?php echo $user['lastVisit'];?></td>
                                    <td>
                                        <a href="admin-message.php?chatuser=<?php echo $user["name"];?>">
                                            <button>Chat</button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="admin-schedule.php?userappointment=<?php echo $user["name"];?>">
                                            <button>Schedule</button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="admin-setting.php?edituser=<?php echo $user["name"];?>">
                                            <button>Edit</button>
                                        </a>
                                    </td>
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