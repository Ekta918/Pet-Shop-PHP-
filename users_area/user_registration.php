<?php 
include("../includes/connect.php"); 
include("../functions/common_function.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
        }
        .registration-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 2.5rem; /* Adjust the font size */
            font-weight: 700; /* Make the text bold */
            color: #007bff; /* Set the color */
            text-align: center; /* Center-align the text */
            margin-bottom: 30px; /* Space below the heading */
            padding: 10px; /* Space inside the heading */
            border-bottom: 2px solid #007bff; /* Optional: Add a border below */
        }
        .form-outline label {
            font-weight: 600;
            color: #555;
        }
        .form-outline input {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 10px;
            transition: border-color 0.3s;
        }
        .form-outline input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
        .btn-register {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-register:hover {
            background-color: #0056b3;
        }
        .small {
            font-size: 0.875rem;
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            let valid = true;

            // Get form field values
            const username = document.getElementById('user_username').value.trim();
            const email = document.getElementById('user_email').value.trim();
            const password = document.getElementById('user_password').value;
            const confirmPassword = document.getElementById('conf_user_password').value;
            const address = document.getElementById('user_address').value.trim();
            const contact = document.getElementById('user_contact').value.trim();
            const image = document.getElementById('user_image').files[0];

            // Clear previous error messages
            clearErrors();

            // Validate username
            if (username === '') {
                showError('user_username', 'Username is required');
                valid = false;
            }

            // Validate email
            if (email === '') {
                showError('user_email', 'Email is required');
                valid = false;
            } else if (!validateEmail(email)) {
                showError('user_email', 'Invalid email format');
                valid = false;
            }

            // Validate password
            if (password === '') {
                showError('user_password', 'Password is required');
                valid = false;
            }

            // Validate confirm password
            if (confirmPassword === '') {
                showError('conf_user_password', 'Confirm Password is required');
                valid = false;
            } else if (password !== confirmPassword) {
                showError('conf_user_password', 'Passwords do not match');
                valid = false;
            }

            // Validate address
            if (address === '') {
                showError('user_address', 'Address is required');
                valid = false;
            }

            // Validate contact
            if (contact === '') {
                showError('user_contact', 'Contact is required');
                valid = false;
            }

            // Validate image
            if (!image) {
                showError('user_image', 'Image is required');
                valid = false;
            }

            // If not valid, prevent form submission
            if (!valid) {
                e.preventDefault();
            }
        });

        function showError(id, message) {
            const field = document.getElementById(id);
            const error = document.createElement('div');
            error.className = 'invalid-feedback';
            error.textContent = message;
            field.classList.add('is-invalid');
            field.parentElement.appendChild(error);
        }

        function clearErrors() {
            const fields = document.querySelectorAll('.form-control');
            fields.forEach(field => {
                field.classList.remove('is-invalid');
                const error = field.parentElement.querySelector('.invalid-feedback');
                if (error) {
                    error.remove();
                }
            });
        }

        function validateEmail(email) {
            const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return re.test(email);
        }
    });
</script>

</head>
<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">New User Registration</h2>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6 registration-box">
            <form action="" method="post" enctype="multipart/form-data">
    <div class="form-outline mb-4">
        <label for="user_username" class="form-label">Username</label>
        <input type="text" class="form-control" id="user_username" placeholder="Enter username" name="user_username"/>
    </div>
    <div class="form-outline mb-4">
        <label for="user_email" class="form-label">Email</label>
        <input type="email" class="form-control" id="user_email" placeholder="Enter email" name="user_email"/>
    </div>
    <div class="form-outline mb-4">
        <label for="user_image" class="form-label">User Image</label>
        <input type="file" class="form-control" id="user_image" name="user_image"/>
    </div>
    <div class="form-outline mb-4">
        <label for="user_password" class="form-label">Password</label>
        <input type="password" class="form-control" id="user_password" placeholder="Enter Password" name="user_password"/>
    </div>
    <div class="form-outline mb-4">
        <label for="conf_user_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="conf_user_password" placeholder="Enter Confirm Password" name="conf_user_password"/>
    </div>
    <div class="form-outline mb-4">
        <label for="user_address" class="form-label">Address</label>
        <input type="text" class="form-control" id="user_address" placeholder="Enter your Address" name="user_address"/>
    </div>
    <div class="form-outline mb-4">
        <label for="user_contact" class="form-label">Contact</label>
        <input type="text" class="form-control" id="user_contact" placeholder="Enter Contact" name="user_contact"/>
    </div>
    <div class="mt-4 pt-2">
        <input type="submit" value="Register" class="btn-register" name="user_register">
        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="user_login.php"> Login</a></p>
    </div>
</form>

            </div>
        </div>
    </div>
</body>
</html>

<!--php code-->

<?php

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['user_register'])) {
    // Fetch and trim the email
    $user_username = $_POST['user_username'];
    $user_email = trim($_POST['user_email']);
    $user_password = $_POST['user_password'];
    $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
    $conf_user_password = $_POST['conf_user_password'];
    $user_address = $_POST['user_address'];
    $user_contact = $_POST['user_contact'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    $user_ip = getIPAddress();

    // Validate the email format
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address provided.')</script>";
        exit; // Stop execution if the email is invalid
    }

    // Generate a unique verification token
    $verification_token = bin2hex(random_bytes(16));

    // Insert query with verification token and status set to "inactive"
    $insert_query = "INSERT INTO user_table (username, user_email, user_password, user_image, user_ip, user_address, user_mobile, verification_token, status)
                     VALUES ('$user_username', '$user_email', '$hash_password', '$user_image', '$user_ip', '$user_address', '$user_contact', '$verification_token', 'inactive')";
    $sql_execute = mysqli_query($con, $insert_query);
    
    // Send verification email
    if ($sql_execute) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'ektavaghasiya9@gmail.com'; // Your email
            $mail->Password = 'twyh vxdk lbin qpnm'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('ektavaghasiya9@gmail.com', 'Ekta Vaghasiya');
            $mail->addAddress($user_email); // Check this line

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body = "Hi $user_username,<br>Please click the link below to verify your email:<br><a href='http://localhost/PROJECT/users_area/verify_email.php?token=$verification_token'>Verify Email</a>";

            $mail->send();
            echo "<script>alert('Registration successful! A verification email has been sent to your email address.')</script>";
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
        }
    }
    $select_cart_items = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
    $result_cart = mysqli_query($con, $select_cart_items);
    $rows_count = mysqli_num_rows($result_cart);
    if ($rows_count > 0) {
        $_SESSION['username'] = $user_username;
        echo "<script>alert('You have items in your cart!!')</script>";
        echo "<script>window.open('checkout.php','_self')</script>";
    } else {
        echo "<script>window.open('../index.php','_self')</script>";
    }
}
?>
