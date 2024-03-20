<?php
session_start();
include "../connect.php";

$name = $_GET['chatuser'];

if(!isset($_SESSION['name'])) {
  header("Location: ../login.php");
  exit();
}


$details = mysqli_query($conn, "SELECT * FROM `user` WHERE `name`='$name'");
$user = mysqli_fetch_assoc($details);

if(isset($_POST['send'])){
    $type = "sending";
    $upload = $_FILES['upload']['name'];
    $tmp_upload = $_FILES['upload']['tmp_name'];
    $textmessage = $_POST['textmessage'];
    $time = date('H:i:s');

    $sql = "INSERT INTO `chat`(`type`, `name`, `upload`, `textmessage`, `time`) VALUES ('$type', '$name', '$upload','$textmessage','$time')";
    $insert = mysqli_query($conn, $sql);

    if ($insert == true){
        move_uploaded_file($tmp_upload, "upload/$upload");
        header("location: admin-chat.php?chatuser=" . $name . "#last");
    }
    else{
        echo "Error";
    }
}


$mychat = mysqli_query($conn, "SELECT * FROM `chat` WHERE `name`='$name'");

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
    <script src="https://kit.fontawesome.com/be0461b2be.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <style>
        /* .all{
            display: none !important;
        } */
        @media screen and (max-width: 767px) {
            .all{
                display: block !important;
                width: 100%;
                height: 100vh;
                position: fixed;
                left: 0;
                top: 0;
                background: #0077B680;
                backdrop-filter: blur(10px);
            }
            .all .chat{
                width: 90%;
                height: 90vh;
            }            
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="row g-0">
            <div class="col col-lg-1 col-md-11 col-12">
                <div class="sidebar">
                    <div class="logo">
                        <img src="../images/Vector.png" width="100%" alt="">
                    </div>
                    <ul>
                        <li><a href="dashboard.html"><i class="bi bi-grid"></i></a></li>
                        <li><a href="history.html"><i class="bi bi-clock-history"></i></a></li>
                        <li><a href="chat.html" class="active"><i class="bi bi-chat-left"></i></a></li>
                        <!-- <li><a href="setting.html"><i class="bi bi-gear"></i></a></li> -->
                        <li><a href="dashboard.html" class="d-flex flex-column text-center"><i class="bi bi-upload"></i>Log out</a></li>
                    </ul>
                </div>
            </div>
            <div class="col col-lg-11 col-md-11 col-12">
                <div class="body mb-lg-0 mb-md-0 mb-5">
                  <div class="heading d-lg-none d-md-none d-block d-flex align-items-center justify-content-between py-3 px-4">
                      <div class="logo">
                          <img src="../images/Vector.png" width="100%" alt="">
                      </div>
                      <!-- <a href="setting.html" class="text-decoration-none"><i class="bi bi-person"></i></a> -->
                  </div>
                  <div class="bottombar d-lg-none d-md-none d-block p-3 shadow-sm">
                      <ul class="d-flex justify-content-between align-items-center">
                          <li><a href="dashboard.html" class="d-flex flex-column text-center gap-2"><i class="bi bi-grid"></i>Dashboard</a></li>
                          <li><a href="history.html" class="d-flex flex-column text-center gap-2"><i class="bi bi-clock-history"></i>History</a></li>
                          <li><a href="chat.html" class="d-flex flex-column text-center gap-2 active"><i class="bi bi-chat-left"></i>Chat</a></li>
                          <!-- <li><a href="setting.html" class="d-flex flex-column text-center gap-2"><i class="bi bi-gear"></i>Setting</a></li> -->
                          <li><a href="../logout.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-upload"></i>Log out</a></li>
                      </ul>
                  </div>
                    <div class="row g-0">
                        <div class="col col-lg-4 col-md-4 col-12 bg-white">
                            <div class="chatname">
                                <div class="p-lg-4 p-md-3 p-3">
                                    <form action="" method="post" class="search d-flex align-items-center">
                                        <i class="bi bi-search"></i>
                                        <input type="text" name="search" id="search" placeholder="Search">
                                    </form>
                                </div>
                                <div class="showChat" id="show-chat">
                                    <!-- SMAL SCREEN STARTS -->
                                    <div class="chat">
                                        <div class="message">
                                            <div class="head py-1 d-flex justify-content-between align-items-center px-3">
                                                <div class="d-flex gap-2 py-1">
                                                    <img src="../upload/<?php echo $user['profilePicture'];?>" width="100%" alt="">
                                                    <div class="name">
                                                        <h5><?php echo $user['name'];?></h5>
                                                        <p>Online</p>
                                                    </div>
                                                </div>
                                                <i class="bi bi-arrow-right text-white"></i>
                                            </div>
                                            <div class="modal-body px-1">
                                                <div class="mychat">
                                                    <?php
                                                        while ($chat = mysqli_fetch_assoc($mychat)) {
                                                            // if ($type === "sending"){
                                                            ?>
                                                            <div class="sender d-flex gap-2 ms-auto">
                                                                <div class="me ms-auto">
                                                                    <p><?php echo $chat['textmessage'];?></p>
                                                                    <small><?php echo $chat['time'];?></small>
                                                                </div>
                                                            </div>
                                                        <?php } 
                                                    ?>
                                                    <?php
                                                        while ($chat = mysqli_fetch_assoc($mychat)) {
                                                            // if ($type === "sending"){
                                                            ?>
                                                            <div class="receiver d-flex gap-2">
                                                                <img src="../images/Ellipse 7.png" width="100%" alt="">
                                                                <div class="you">
                                                                    <p><?php echo $chat['textmessage'];?></p>
                                                                    <small><?php echo $chat['time'];?></small>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    ?>
                                                    <div id="last"></div>
                                                </div>
                                            </div>
                                            <div class="send p-3">
                                                <form action="" method="post" enctype="multipart/form-data" class="d-flex gap-2">
                                                    <div class="file">
                                                        <input type="file" name="upload" id="upload">
                                                        <div class="top d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-paperclip"></i>
                                                        </div>
                                                    </div>
                                                    <div class="myinput d-flex align-items-center bg-white w-100">
                                                        <input type="text" name="textmessage" id="textmessage">
                                                        <button type="submit" name="smallsend"><i class="bi bi-send-fill"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- SMAL SCREEN ENDS -->
                                </div>
                                <div class="chatlists">
                                    <a href="#" class="list d-flex align-items-center gap-2 text-decoration-none my-1 py-2 px-4">
                                        <img src="../upload/<?php echo $user['profilePicture'];?>" width="100%" alt="">
                                        <div class="name">
                                            <h5><?php echo $user['name'];?></h5>
                                            <p>is typing a message.....</p>
                                        </div>
                                        <div class="time ms-auto mb-auto">
                                            <p>5m ago</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-8 col-md-8 col-12 d-lg-block d-md-block d-none">
                            <div class="all">
                                <div class="chat">
                                    <!-- LARGE SCREEN CHAT STARTS -->
                                    <div class="head d-flex gap-3 px-4 py-2">
                                        <img src="../upload/<?php echo $user['profilePicture'];?>" width="100%" alt="">
                                        <div class="name">
                                            <h5><?php echo $user['name'];?></h5>
                                            <p>Online</p>
                                        </div>
                                    </div>
                                    <div class="message px-4">
                                        <div class="mychat py-3">
                                            <?php
                                                while ($largechat = mysqli_fetch_assoc($mychat)) {
                                                    // if ($type === "sending"){
                                                    ?>
                                                    <div class="sender d-flex gap-2 ms-auto">
                                                        <div class="me ms-auto">
                                                            <p><?php echo $largechat['textmessage'];?></p>
                                                            <small><?php echo $largechat['time'];?></small>
                                                        </div>
                                                    </div>
                                                <?php } 
                                            ?>
                                            <?php
                                                while ($largechat = mysqli_fetch_assoc($mychat)) {
                                                    // if ($type === "sending"){
                                                    ?>
                                                    <div class="receiver d-flex gap-2">
                                                        <img src="../images/Ellipse 7.png" width="100%" alt="">
                                                        <div class="you">
                                                            <p><?php echo $largechat['textmessage'];?></p>
                                                            <small><?php echo $largechat['time'];?></small>
                                                        </div>
                                                    </div>
                                                <?php }
                                            ?>
                                        <div id="last"></div>
                                        </div>
                                        <div class="send">
                                            <form action="" method="post" enctype="multipart/form-data" class="d-flex gap-2">
                                                <div class="file">
                                                    <input type="file" name="upload" id="upload">
                                                    <div class="top d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-paperclip"></i>
                                                    </div>
                                                </div>
                                                <div class="myinput d-flex align-items-center bg-white w-100">
                                                    <input type="text" name="textmessage" id="textmessage">
                                                    <button type="submit" name="send"><i class="bi bi-send-fill"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- LARGE SCREEN CHAT ENDS -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        let biAarrowRight = document.querySelector(".bi-arrow-right");
        let showChat = document.getElementById("show-chat");
        let list = document.querySelector(".list");

        biAarrowRight.addEventListener("click", cancelBtn)
        list.addEventListener("click", listBtn)

        showChat.style.display = "none";

        function cancelBtn(e) {
            showChat.style.display = "none";
        }
        function listBtn(e) {
            showChat.style.display = "block";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>