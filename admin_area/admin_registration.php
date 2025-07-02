<?php 
include("../includes/connect.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            overflow-x: hidden;
        }
        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <h2 class="text-center mb-5">Admin Registration</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <img src="../images/2.png" alt="Admin Registration" class="img-fluid">
            </div>
            <div class="col-lg-6 col-xl-4">
                <form id="registration-form" action="" method="post">
                    <div class="form-outline mb-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" class="form-control">
                        <div class="error" id="error-username"></div>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" name="email" placeholder="Enter your Email" class="form-control">
                        <div class="error" id="error-email"></div>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control">
                        <div class="error" id="error-password"></div>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password" class="form-control">
                        <div class="error" id="error-confirm_password"></div>
                    </div>
                    <div>
                        <input type="submit" name="admin_registration" value="Register" class="btn btn-primary py-2 px-3 border-0">
                        <p class="small fw-bold mt-2 pt-1">Already have an account? <a href="admin_login.php" class="text-primary">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- JavaScript for validation -->
    <script>
        document.getElementById('registration-form').addEventListener('submit', function(event) {
            var isValid = true;

            // Clear previous errors
            var errors = document.getElementsByClassName('error');
            for (var i = 0; i < errors.length; i++) {
                errors[i].textContent = '';
            }

            // Get form values
            var username = document.getElementById('username').value.trim();
            var email = document.getElementById('email').value.trim();
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            // Validate fields
            if (username === '') {
                document.getElementById('error-username').textContent = 'Username is required.';
                isValid = false;
            }
            if (email === '') {
                document.getElementById('error-email').textContent = 'Email is required.';
                isValid = false;
            } else if (!/\S+@\S+\.\S+/.test(email)) {
                document.getElementById('error-email').textContent = 'Email is not valid.';
                isValid = false;
            }
            if (password === '') {
                document.getElementById('error-password').textContent = 'Password is required.';
                isValid = false;
            }
            if (confirmPassword === '') {
                document.getElementById('error-confirm_password').textContent = 'Confirm Password is required.';
                isValid = false;
            } else if (password !== confirmPassword) {
                document.getElementById('error-confirm_password').textContent = 'Passwords do not match.';
                isValid = false;
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>

<!-- PHP Code -->
  <?php
include("../includes/connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';


if (isset($_POST['admin_registration'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $verification_token = md5(time() . $username); // Create a unique verification token

    $select_query = "SELECT * FROM `admin_table` WHERE admin_name='$username' OR admin_email='$email'";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);

    if ($rows_count > 0) {
        echo "<script>alert('Username or Email already exists!')</script>";
    } else if ($password != $confirm_password) {
        echo "<script>alert('Passwords do not match!')</script>";
    } else {
        // Insert query
        $insert_query = "INSERT INTO `admin_table` (admin_name, admin_email, admin_password, verification_token, is_verified)
                         VALUES ('$username', '$email', '$hash_password', '$verification_token', 0)";
        $sql_execute = mysqli_query($con, $insert_query);

        if ($sql_execute) {
            // Send verification email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth = true;
                $mail->Username = 'ektavaghasiya9@gmail.com'; // SMTP username
                $mail->Password = 'twyh vxdk lbin qpnm'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('ektavaghasiya9@gmail.com', 'Ekta Vaghasiya');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Email Verification';
                $mail->Body    = "Click the link to verify your email: <a href='http://localhost/PROJECT/admin_area/verify_email.php?token=$verification_token'>Verify Email</a>";

                $mail->send();
                echo "<script>alert('Registration Completed Successfully. Check your email for verification link.')</script>";
                echo "<script>window.open('admin_login.php', '_self')</script>";
            } catch (Exception $e) {
                echo "<script>alert('Mailer Error: {$mail->ErrorInfo}')</script>";
            }
        }
    }
}
?>
