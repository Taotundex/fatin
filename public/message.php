<?php
session_start();
include "connect.php";

$name = $_SESSION['name'];

if(!isset($_SESSION['name'])) {
  header("Location: login.php");
  exit();
}


$details = mysqli_query($conn, "SELECT * FROM `user` WHERE `name`='$name'");
$user = mysqli_fetch_assoc($details);

if(isset($_POST['send'])){
    $type = "receive";
    $upload = $_FILES['upload']['name'];
    $tmp_upload = $_FILES['upload']['tmp_name'];
    $textmessage = $_POST['textmessage'];
    $time = date('H:i:s');

    $sql = "INSERT INTO `chat`(`type`, `name`, `upload`, `textmessage`, `time`) VALUES ('$type', '$name', '$upload','$textmessage','$time')";
    $insert = mysqli_query($conn, $sql);

    if ($insert == true){
        move_uploaded_file($tmp_upload, "upload/$upload");
        header("location: message.php#last");
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
    <title>Chat</title>
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
        /* .all{
            display: none !important;
        } */
        .chatlists .name h5 {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 200px !important;
        }
        .truncate-text {
            font-size: 12px;
            margin-top: -7px;
            color: #00000080;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 300px;
        }
        .in{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: #0077B680;
            backdrop-filter: blur(20px);
        }
        #imagePreview{
            position: absolute;
            top: 50%;
            left: 50%;
            translate: -50% -50%;
        }
        @media screen and (max-width: 767px) {
            .all{
                display: none;
                width: 100%;
                height: 100vh;
                position: fixed;
                left: 0;
                top: 0;
                background: #0077B680;
                backdrop-filter: blur(10px);
                z-index: 100;
            }
            .all .chat{
                border: 4px solid #F4FEFF;
                background: #F4FEFF;
                width: 95%;
                height: 95vh;
                opacity: 1 !important;
                position: absolute;
                left: 50%;
                top: 50%;
                translate: -50% -50%;
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
                        <img src="images/Vector.png" width="100%" alt="">
                    </div>
                    <ul>
                        <li><a href="dashboard.php"><i class="bi bi-grid"></i></a></li>
                        <li><a href="history.php"><i class="bi bi-clock-history"></i></a></li>
                        <li><a href="message.php#last" class="active"><i class="bi bi-chat-left"></i></a></li>
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
                          <li><a href="dashboard.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-grid"></i>Dashboard</a></li>
                          <li><a href="history.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-clock-history"></i>History</a></li>
                          <li><a href="message.php#last" class="d-flex flex-column text-center gap-2 active"><i class="bi bi-chat-left"></i>Chat</a></li>
                          <li><a href="setting.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-gear"></i>Setting</a></li>
                          <li><a href="logout.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-upload"></i>Log out</a></li>
                      </ul>
                  </div>
                    <div class="row g-0">
                        <div class="col col-lg-4 col-md-4 col-12 bg-white">
                            <div class="chatname">
                                <div class="p-lg-4 p-md-3 p-3">
                                    <form action="" class="search d-flex align-items-center">
                                        <i class="bi bi-search"></i>
                                        <input type="text" name="search" id="search" placeholder="Search">
                                    </form>
                                </div>
                                <div class="chatlists">
                                    <a href="" class="list d-flex align-items-center gap-2 text-decoration-none my-1 py-2 px-4">
                                        <img src="upload/<?php echo $user['profilePicture'];?>" width="100%" alt="">
                                        <div class="name">
                                            <h5><?php echo $user['name'];?></h5>
                                            <div class="truncate-text">
                                                <?php echo $user['bio'];?>
                                            </div>
                                        </div>
                                        <div class="time ms-auto mb-auto">
                                            <p>5m ago</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-8 col-md-8 col-12">
                            <div class="all" id="all">
                                <div class="chat">
                                    <!-- LARGE SCREEN CHAT STARTS -->
                                    <div class="head d-flex align-items-center justify-content-between px-4 py-2">
                                        <div class="d-flex gap-3">
                                            <img src="upload/<?php echo $user['profilePicture'];?>" width="100%" alt="">
                                            <div class="name">
                                                <h5><?php echo $user['name'];?></h5>
                                                <p>Online</p>
                                            </div>
                                        </div>
                                        <i class="bi bi-arrow-right text-white d-lg-none d-md-none d-block d-flex align-items-center justify-content-center"></i>
                                    </div>
                                    <div class="message px-4">
                                        <div class="mychat py-3">
                                            <?php
                                                while ($largechat = mysqli_fetch_assoc($mychat)) {
                                                    if ($largechat['type'] == "receive"){
                                                        if (($largechat['upload'] == "")  && $largechat['textmessage'] == ""){
                                                        ?>
                                                            <!-- <div class="sender d-flex gap-2 ms-auto">
                                                                <div class="me ms-auto">
                                                                    <img src="upload/<php echo $largechat['upload'];?>" alt="" width="100%" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                                                    <small><php echo $largechat['time'];?></small>
                                                                </div>
                                                            </div> -->
                                                        <?php }
                                                        else if (($largechat['upload'] == "")  && $largechat['textmessage'] != ""){
                                                            ?>
                                                            <div class="sender d-flex gap-2 ms-auto">
                                                                <div class="me ms-auto">
                                                                    <p><?php echo $largechat['textmessage'];?></p>
                                                                    <small><?php echo $largechat['time'];?></small>
                                                                </div>
                                                            </div>
                                                        <?php } 
                                                        else if (($largechat['upload'] != "")  && $largechat['textmessage'] != ""){
                                                            ?>
                                                            <div class="sender d-flex gap-2 ms-auto">
                                                                <div class="me ms-auto">
                                                                    <img src="upload/<?php echo $largechat['upload'];?>" alt="" width="100%" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                                                    <p><?php echo $largechat['textmessage'];?></p>
                                                                    <small><?php echo $largechat['time'];?></small>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                        else {
                                                            ?>
                                                            <div class="sender d-flex gap-2 ms-auto">
                                                                <div class="me ms-auto">
                                                                    <img src="upload/<?php echo $largechat['upload'];?>" alt="" width="100%" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                                                    <small><?php echo $largechat['time'];?></small>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    }
                                                    else {
                                                        if (($largechat['upload'] == "")  && ($largechat['textmessage'] == "")){
                                                            ?>
                                                            <!-- <div class="receiver d-flex gap-2">
                                                                <img src="images/images.png" width="100%" alt="">
                                                                <div class="you">
                                                                    <img src="upload/<php echo $largechat['upload'];?>" alt="" width="100%" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                                                    <p><php echo $largechat['textmessage'];?></p>
                                                                    <small><php echo $largechat['time'];?></small>
                                                                </div>
                                                            </div> -->
                                                        <?php }
                                                        else if (($largechat['upload'] == "")  && ($largechat['textmessage'] != "")){
                                                            ?>
                                                            <div class="receiver d-flex gap-2">
                                                                <img src="images/images.png" width="100%" alt="">
                                                                <div class="you">
                                                                    <p><?php echo $largechat['textmessage'];?></p>
                                                                    <small><?php echo $largechat['time'];?></small>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                        else if (($largechat['upload'] != "")  && $largechat['textmessage'] == ""){
                                                            ?>
                                                            <div class="receiver d-flex gap-2">
                                                                <img src="images/images.png" width="100%" alt="">
                                                                <div class="you">
                                                                    <img src="upload/<?php echo $largechat['upload'];?>" alt="" width="100%" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                                                    <small><?php echo $largechat['time'];?></small>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                        else {
                                                            ?>
                                                            <div class="receiver d-flex gap-2">
                                                                <img src="images/images.png" width="100%" alt="">
                                                                <div class="you">
                                                                    <img src="upload/<?php echo $largechat['upload'];?>" alt="" width="100%" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                                                    <p><?php echo $largechat['textmessage'];?></p>
                                                                    <small><?php echo $largechat['time'];?></small>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    }
                                                }
                                            ?>
                                        <div id="last"></div>
                                        </div>
                                        <div class="in" style="z-index: 0 !important;">
                                            <div id="imagePreview"></div>
                                        </div>
                                        <div class="send">
                                            <form action="" method="post" enctype="multipart/form-data" class="d-flex gap-2">
                                                <div class="file" style="z-index: 100000 !important;">
                                                    <input type="file" name="upload" id="upload" accept="image/*" style="opacity: 0.0000001; position: absolute !important;">
                                                    <div class="top d-flex align-items-center justify-content-center" style="position: relative !important; z-index: -1;">
                                                        <i class="bi bi-paperclip"></i>
                                                    </div>
                                                </div>
                                                <div class="myinput d-flex align-items-center bg-white w-100" style="z-index: 100000 !important;">
                                                    <input type="text" name="textmessage" id="textmessage" style="border-radius: 10px;">
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
        // let showChat = document.getElementById("show-chat");
        let list = document.querySelector(".list");
        let all = document.querySelector(".all");

        biAarrowRight.addEventListener("click", cancelBtn)
        list.addEventListener("click", listBtn)

        // all.style.display = "none";

        function cancelBtn(e) {
            all.style.display = "none";
        }
        function listBtn(e) {
            e.preventDefault();
            all.style.display = "block";
        }

        let inEl =document.querySelector(".in");
        inEl.style.display = "none";
        document.addEventListener("DOMContentLoaded", function() {
    const upload = document.getElementById('upload');
    const imagePreview = document.getElementById('imagePreview');

    upload.addEventListener('change', function() {
        const file = this.files[0];
        inEl.style.display = "block";

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '300px';
                img.style.height = '400px';
                img.style.objectFit = 'cover';
                img.style.objectPosition = 'top';
                imagePreview.innerHTML = '';
                imagePreview.appendChild(img);
            };

            reader.readAsDataURL(file);
        } else {
            imagePreview.innerHTML = '';
        }
    });
});

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>