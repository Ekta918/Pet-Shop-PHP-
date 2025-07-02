<?php 
include("../includes/connect.php"); 
include("../functions/common_function.php");
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body
        {
            overflow-x:hidden;
        }
    </style>
</head>
<body>
<div class="container-fluid m-3">
        <h2 class="text-center mb-5">Admin Login</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <img src="../images/2.png" alt="">
            </div>
            <div class="col-lg-6 col-xl-4">
                <form action="" method="post">
                    <div class="form-outline mb-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" class="form-control">
                    </div>
                    <div class="form-outline mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control">
                    </div>
                    <div class="mt-4 pt-2 d-flex justify-content-between align-items-center">
                        <input type="submit" name="admin_login" value="Login" class="btn btn-primary py-2 px-3 border-0">
                        <p class="small fw-bold mb-0 ms-2"><a href="admin_forgot_password.php">Forgot Password?</a></p>
                    </div>
                    <p class="small fw-bold mt-2 pt-1">Don't have an account? <a href="admin_registration.php" class="text-primary">Register</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
include("../includes/connect.php");
@session_start();

if (isset($_POST['admin_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $select_query = "SELECT * FROM `admin_table` WHERE admin_name='$username'";
    $result = mysqli_query($con, $select_query);
    $row_count = mysqli_num_rows($result);
    $row_data = mysqli_fetch_assoc($result);

    if ($row_count > 0) {
        // Check if the account is verified
        if ($row_data['is_verified'] == 0) {
            echo "<script>alert('Your email is not verified. Please check your email for the verification link.')</script>";
        } else {
            if (password_verify($password, $row_data['admin_password'])) {
                $_SESSION['admin_name'] = $username;
                echo "<script>alert('Login Successful...')</script>";
                echo "<script>window.open('index.php?admin_dashboard','_self')</script>";
            } else {
                echo "<script>alert('Invalid Credentials')</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>
