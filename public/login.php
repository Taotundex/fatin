<?php
    session_start();
    include "connect.php";

    $msg="";
    if(isset($_POST['login'])) {
        $name = $_POST["name"];
        $password = $_POST["password"];

        if(($name && $password) != ""){
            if($name == "fatinadmin" && $password == "admin"){
                $_SESSION["name"] = $name;
                $_SESSION["password"]=$password;
                header("location: admin/index.php");
            }
            else{                
                $result = mysqli_query($conn, "SELECT * FROM `user` WHERE `name` = '$name' AND `password`='$password'");
                if((mysqli_num_rows($result) > 0)) {
                    $user = mysqli_fetch_assoc($result);
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['password'] = $user['password'];
                    if ((empty($user['profilePicture'])) || (empty($user['username'])) || (empty($user['phoneNumber'])) || (empty($user['bio']))){
                        header("location: setting.php");
                    }
                    else {
                        header("location: dashboard.php");
                    }
                }
                else{
                    $msg = "Invalid login details";
                }                
            }
        }
        else {
            echo "Empty input";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="media.css">
    <link rel="shortcut icon" href="images/Group 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="fatin">
        <div class="account">
            <div class="row g-0">
                <div class="col col-lg-6 col-md-12 col-12">
                    <div class="left">
                        <div class="logo d-flex align-items-center gap-1">
                            <img src="images/Group 2.png" width="100%" alt="">
                            Medic
                        </div>
                        <div class="img">
                            <img src="images/undraw_medicine_b-1-ol (1) 1.png" width="100%" alt="">
                            <img src="images/undraw_medicine_b-1-ol (2) 1.png" width="100%" alt="">
                        </div>
                    </div>
                </div>
                <div class="col col-lg-6 col-md-12 col-12">
                    <div class="right">
                        <div class="img">
                            <img src="images/Group 2 (1).png" width="100%" alt="">
                            <img src="images/Group 5 (1).png" width="100%" alt="">
                        </div>
                        <div class="form d-flex align-items-center justify-content-center">
                            <form action="" method="post">
                                <h3 class="text-center mb-5">Login</h3>
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" placeholder="Name" required>

                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" placeholder="Password" required>

                                <center style="margin: -20px 0 10px 0;"><i style="font-size: 12px;" class="text-danger"><?php echo $msg;?></i></center>

                                <button type="submit" name="login">Login</button>

                                <center class="my-3">Don't have an account? <a href="signup.php">Sign up</a></center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>