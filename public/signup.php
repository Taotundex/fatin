<?php
    include "connect.php";

    $min = 10000;
    $max = 99999;
    $randomNumberInRange = rand($min, $max);
    $secondRandomNumberInRange = rand($min, $max);

    $msg = "";
    if(isset($_POST["signup"])){
        $patientId = $randomNumberInRange. $secondRandomNumberInRange;
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $query = "SELECT * FROM `user` WHERE `name` = '$name'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $msg = "Name already exists. Please input a different name.";
        } 
        else {
            $insert = mysqli_query($conn, "INSERT INTO `user`(`patientId`, `name`, `email`, `password`) VALUES ('$patientId', '$name','$email','$password')");
            if ($insert == true){
                header("location: setting.php");
            }
            else {
                $msg = "Error creating account";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
                    <div class="right bg-danger">
                        <div class="img">
                            <img src="images/Group 2 (1).png" width="100%" alt="">
                            <img src="images/Group 5 (1).png" width="100%" alt="">
                        </div>
                        <div class="form d-flex align-items-center justify-content-center">
                            <form action="" method="post" onsubmit="return validateForm()">
                                <h3 class="text-center mb-3">Sign up</h3>
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" placeholder="Name" required>

                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" placeholder="Email" required>

                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" placeholder="Password" required>

                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>

                                <center style="margin: -20px 0 10px 0;"><i style="font-size: 12px;" class="text-danger"><?php echo $msg;?></i></center>

                                <button type="submit" name="signup">Sign up</button>

                                <center class="my-3">Already have an account? <a href="login.php">Log in</a></center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function validateForm() {
            // e.preventDefault()
            let passwordEl = document.getElementById("password").value;
            let confirmPasswordEl = document.getElementById("confirmPassword").value;
            if ((confirmPasswordEl) !== (passwordEl)){
                alert("Password does not match");
                return false;
            }

            return true;
        }
        document.getElementById('confirmPassword').addEventListener('input', function() {
            var password = document.getElementById('password').value;
            var confirmPassword = this.value;

            // Update the validity of the confirm password field
            if (password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>