<?php
    session_start();
    include "../connect.php";
    
    $name = $_GET['edituser'];
        
    if(!isset($_SESSION['name'])) {
            header("Location: ../login.php");
            exit();
    }

    $msg = "";
    $addmsg = "";

    if (isset($_POST['update'])){
      $age = $_POST['age'];
      $gender = $_POST['gender'];
      $bloodtype = $_POST['bloodtype'];
      $allergies = $_POST['allergies'];
      $diseases = $_POST['diseases'];
      $height = $_POST['height'];
      $weight = $_POST['weight'];
      $lastVisit = $_POST['lastVisit'];
      $heartRate = $_POST['heartRate'];
      $temperature = $_POST['temperature'];
      $glucose = $_POST['glucose'];


      $sql = "UPDATE `user` SET `age`='$age',`gender`='$gender',`bloodtype`='$bloodtype',`allergies`='$allergies',`diseases`='$diseases',`height`='$height',`weight`='$weight',`lastVisit`='$lastVisit', `heartRate` = '$heartRate', `temperature` = '$temperature', `glucose` = '$glucose' WHERE `name` = '$name'";
      $update = mysqli_query($conn, $sql);

      if ($update == true){
        $msg = "Details has been successfully updated";
      }
      else {
        $msg = "Error scheduling appointment";
      }
    }
    if (isset($_POST['add'])){
      $bodyScan = $_POST['bodyScan'];
      $creatineKinase = $_POST['creatineKinase'];


      $sql = "UPDATE `user` SET `bodyScan`='$bodyScan',`creatineKinase`='$creatineKinase' WHERE `name` = '$name'";
      $addupdate = mysqli_query($conn, $sql);

      if ($addupdate == true){
        $msg = "Test Reports has been successfully updated";
      }
      else {
        $addmsg = "Error updating test reports";
      }
    }
    
    $select_user = mysqli_query($conn, "SELECT * FROM `appointment` WHERE `name`='$name'");
    $user = mysqli_fetch_assoc($select_user);
    // echo $name;

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
    <style>
      select{
        outline: none;
        width: 100%;
        height: 50px;
        border: none;
        background: #EDF2F6;
        border-radius: 10px;
        padding: 0 15px;
        margin: 5px 0 10px 0;
      }
    </style>
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
                        <li><a href="admin-history.php"><i class="bi bi-clock-history"></i></a></li>
                        <!-- <li><a href="admin-message.php" class="active"><i class="bi bi-chat-left"></i></a></li> -->
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
                          <li><a href="admin-history.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-clock-history"></i>History</a></li>
                          <!-- <li><a href="admin-message.php" class="d-flex flex-column text-center gap-2 active"><i class="bi bi-chat-left"></i>Chat</a></li> -->
                          <!-- <li><a href="admin-setting.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-gear"></i>Setting</a></li> -->
                          <li><a href="../logout.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-upload"></i>Log out</a></li>
                      </ul>
                  </div>
                    <div class="all-details p-lg-5 p-md-4 p-4 my-lg-5 my-md-5 m-3 bg-white shadow-sm">
                      <div class="form">
                        <h3>Edit users details</h3>
                        <form action="" method="post">
                          <div class="row gx-5 gy-3 py-3">
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="age">Age:</label>
                                <input type="number" name="age" id="age" placeholder="20">
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" required>
                                  <option value="male">Male</option>
                                  <option value="female">Female</option>
                                  <option value="other">Other</option>
                                </select>
                                <!-- <input type="text" name="gender" id="gender" placeholder="Please enter your gender"> -->
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="bloodtype">Blood Type</label>
                                <input type="text" name="bloodtype" id="bloodtype" placeholder="O+(Positive)">
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="allergies">Allergies</label>
                                <input type="text" name="allergies" id="allergies" placeholder="Non">
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="diseases">Diseases</label>
                                <input type="text" name="diseases" id="diseases" placeholder="Non">
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="height">Height (in m)</label>
                                <input type="text" name="height" id="height" placeholder="1.8">
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="weight">Weight (in kg)</label>
                                <input type="number" name="weight" id="weight" placeholder="56">
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="lastVisit">Last Visit</label>
                                <input type="date" name="lastVisit" id="lastVisit" required>
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="heartRate">Heart Rate (in bpm)</label>
                                <input type="text" name="heartRate" id="heartRate" placeholder="80" required>
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="temperature">Body Temperature (in <sup>o</sup>C)</label>
                                <input type="text" name="temperature" id="temperature" placeholder="36.5" required>
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="glucose">Glucose (in mg/dl)</label>
                                <input type="text" name="glucose" id="glucose" placeholder="100" required>
                              </div>
                            </div>
                          </div>
                          <center><i style="font-size: 12px;" class="text-danger"><?php echo $msg;?></i></center>
                          <div class="btns d-flex gap-3">
                            <button type="submit" name="update">Update Profile</button>
                            <button type="reset">Reset</button>
                          </div>
                        </form>
                      </div>



                      <div class="form mt-5">
                        <h3>Test Reports</h3>
                        <form action="" method="post">
                          <div class="row gx-5 gy-3 py-3">
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="bodyScan">CT scan -Full body:</label>
                                <input type="date" name="bodyScan" id="bodyScan" required>
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="creatineKinase">Creatine Kinase T:</label>
                                <input type="date" name="creatineKinase" id="creatineKinase" required>
                              </div>
                            </div>
                          </div>
                          <center><i style="font-size: 12px;" class="text-danger"><?php echo $addmsg;?></i></center>
                          <div class="btns d-flex gap-3">
                            <button type="submit" name="add">Add</button>
                            <button type="reset">Reset</button>
                          </div>
                        </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
      let btnAccEl = document.getElementById("btnAcc");
      let btnLogEl = document.getElementById("btnLog");

      btnAccEl.style.borderBottom = "2px solid #0077B6"
      btnAccEl.style.color = "#0077B6"

      btnAccEl.addEventListener("click", accBtn)
      btnLogEl.addEventListener("click", logBtn)

      function accBtn(e) {
        btnAccEl.style.borderBottom = "2px solid #0077B6"
        btnAccEl.style.color = "#0077B6"
        btnLogEl.style.borderBottom = "none"
        btnLogEl.style.color = "black"
      }
      function logBtn(e) {
        btnLogEl.style.borderBottom = "2px solid #0077B6"
        btnLogEl.style.color = "#0077B6"
        btnAccEl.style.borderBottom = "none"
        btnAccEl.style.color = "black"
      }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>