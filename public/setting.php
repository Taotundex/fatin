<?php
session_start();
include "connect.php";

$name = $_SESSION['name'];

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

$msg = "";
if (isset($_POST["update"])) {
    $profilePicture = $_FILES["profilePicture"]["name"];
    $tmp_profilePicture = $_FILES["profilePicture"]["tmp_name"];
    $username = $_POST["username"];
    $phoneNumber = $_POST["phoneNumber"];
    $bio = $_POST["bio"];

    // Update user data using prepared statement
    $stmt = $conn->prepare("UPDATE `user` SET `profilePicture` = ?, `username` = ?, `phoneNumber` = '$phoneNumber', `bio` = ? WHERE `name` = ?");
    $stmt->bind_param("sssss", $profilePicture, $username, $phoneNumber, $bio, $name);

    if ($stmt->execute()) {
        move_uploaded_file($tmp_profilePicture, "upload/$profilePicture");
        header("Location: dashboard.php");
        exit();
    } else {
        $msg = "Error updating profile";
    }
}

$select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE `name`='$name'");
$user = mysqli_fetch_assoc($select_user);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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
<style>
  .pic{
    position: relative;
  }
  .all-details .form form input[type="file"]{
    position: absolute;
    width: 200px;
    height: 200px;
    border: 1px dashed #4C535F;
    background: red;
    border-radius: 10px;
    left: 0;
    top: 0;
    opacity: 0.00001;
}
.all-details .form form .top{
    /* position: relative; */
    margin-top: -16px;
    color: #4C535F;
    font-weight: 500;
    font-size: 14px;
    width: 200px;
    height: 200px;
    border: 1px dashed #4C535F;
    background: #EDF2F6;
    border-radius: 10px;
}

        #imagePreview{
            position: absolute;
            top: 0%;
            left: 0%;
        }
</style>
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
                        <li><a href="history.php"><i class="bi bi-clock-history"></i></a></li>
                        <li><a href="message.php#last"><i class="bi bi-chat-left"></i></a></li>
                        <li><a href="setting.php" class="active"><i class="bi bi-gear"></i></a></li>
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
                        <li><a href="message.php#last" class="d-flex flex-column text-center gap-2"><i class="bi bi-chat-left"></i>Chat</a></li>
                        <li><a href="setting.php" class="d-flex flex-column text-center gap-2 active"><i class="bi bi-gear"></i>Setting</a></li>
                        <li><a href="logout.php" class="d-flex flex-column text-center gap-2"><i class="bi bi-upload"></i>Log out</a></li>
                    </ul>
                </div>
                    <div class="all-details p-lg-5 p-md-4 p-4 my-lg-5 my-md-5 m-3 bg-white shadow-sm">
                      <h2 class="fw-bold fs-3 mb-3">Update your details</h2>
                      <header class="d-flex gap-3 align-items-center">
                        <button id="btnAcc">Account setting</button>
                        <button id="btnLog">Login & Security</button>
                      </header>
                      <div class="form">
                        <h3>Your Profile  Picture</h3>
                        <form action="" method="post" enctype="multipart/form-data">
                          <div class="pic py-3">
                            <input type="file" name="profilePicture" id="profilePicture" required>
                            <div id="imagePreview"></div>
                            <div class="top text-center d-flex align-items-center justify-content-center flex-column">
                              <img src="images/gallery-add.png" width="100%" alt="">
                              <p>Upload your photo</p>
                            </div>
                          </div>
                          <div class="row gx-5 gy-3 py-3">
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="fullname">Full name</label>
                                <input type="text" name="fullname" id="fullname" value="<?php echo $user['name']?>" readonly>
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="<?php echo $user['email']?>" readonly>
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" placeholder="Please enter your username" required>
                              </div>
                            </div>
                            <div class="col col-lg-6 col-md-6 col-12">
                              <div class="personal">
                                <label for="phoneNumber">Phone number</label>
                                <input type="number" name="phoneNumber" id="phoneNumber" placeholder="Please enter your phone number" required>
                              </div>
                            </div>
                            <div class="col col-12">
                              <div class="personal">
                                <label for="bio">Bio</label>
                                <textarea name="bio" id="bio" placeholder="Write your Bio here e.g your hobbies, interests ETC" required></textarea>
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
      document.addEventListener("DOMContentLoaded", function() {
    const profilePicture = document.getElementById('profilePicture');
    const imagePreview = document.getElementById('imagePreview');

    profilePicture.addEventListener('change', function() {
        const file = this.files[0];
        // inEl.style.display = "block";

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '200px';
                img.style.height = '200px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '10px';
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