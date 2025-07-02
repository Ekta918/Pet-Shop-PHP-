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
    <title>User Login</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
        }
        .login-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login-box h2 {
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
            color: #333;
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
        .btn-login {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-login:hover {
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
            const password = document.getElementById('user_password').value;

            // Clear previous error messages
            clearErrors();

            // Validate username
            if (username === '') {
                showError('user_username', 'Username is required');
                valid = false;
            }

            // Validate password
            if (password === '') {
                showError('user_password', 'Password is required');
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
    });
</script>
</head>
<body>
    <div class="container-fluid my-3">
        <h2 class="text-center mb-5">User Login</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-xl-5 d-none d-lg-block">
                <img src="../images/2.png" alt="Login Image" class="img-fluid">
            </div>
            <div class="col-lg-6 col-xl-4 login-box">
            <form action="" method="post">
    <div class="form-outline mb-4">
        <label for="user_username" class="form-label">Username</label>
        <input type="text" class="form-control" id="user_username" placeholder="Enter username" name="user_username"/>
    </div>
    <div class="form-outline mb-4">
        <label for="user_password" class="form-label">Password</label>
        <input type="password" class="form-control" id="user_password" placeholder="Enter Password" name="user_password"/>
    </div>
    <div class="mt-4 pt-2 d-flex justify-content-between align-items-center">
    <input type="submit" value="Login" class="btn-login" name="user_login">
    <p class="small fw-bold mb-0 ms-2"><a href="forgot_password.php">Forgot Password?</a></p>
    </div>
    <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="user_registration.php">Register</a></p>
</form>

            </div>
        </div>
    </div>
</body>
</html>


<!-- <?php

if(isset($_POST['user_login']))
{
    $user_username=$_POST['user_username'];
    $user_password=$_POST['user_password'];

    $select_query="select * from `user_table` where username='$user_username'";
    $result=mysqli_query($con,$select_query);
    $row_count=mysqli_num_rows($result);
    $row_data=mysqli_fetch_assoc($result);
    $user_ip=getIPAddress();
    //cart item
    $select_query_cart="select * from `cart_details` where ip_address='$user_ip'";
    $select_cart=mysqli_query($con,$select_query_cart);
    $row_count_cart=mysqli_num_rows($select_cart);
    if($row_count>0)
    {
        $_SESSION['username']=$user_username;
        if(password_verify($user_password,$row_data['user_password']))
        {
            if($row_count==1 and $row_count_cart==0)
            {
                $_SESSION['username']=$user_username;
                echo "<script>alert('Login Successful...')</script>";
                echo "<script>window.open('profile.php','_self')</script>";
            }
            else
            {
                $_SESSION['username']=$user_username;
                echo "<script>alert('Login Successful...')</script>";
                echo "<script>window.open('payment.php','_self')</script>";
            }
        }
        else
        {
            echo "<script>alert('invalid Credentials')</script>"; 
        }
    }
    else
    {
        echo "<script>alert('invalid Credentials')</script>";
    }
}

?> -->
<?php

if (isset($_POST['user_login'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];

    $select_query = "SELECT * FROM `user_table` WHERE username='$user_username'";
    $result = mysqli_query($con, $select_query);
    $row_count = mysqli_num_rows($result);
    $row_data = mysqli_fetch_assoc($result);
    $user_ip = getIPAddress();
    
    // Check if user exists
    if ($row_count > 0) {
        // Check if the account is active
        if ($row_data['status'] !== 'active') {
            echo "<script>alert('Your account is inactive. Please verify your email address.');</script>";
            return;
        }

        // Check password
        if (password_verify($user_password, $row_data['user_password'])) {
            $_SESSION['username'] = $user_username;

            // Check cart items
            $select_query_cart = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
            $select_cart = mysqli_query($con, $select_query_cart);
            $row_count_cart = mysqli_num_rows($select_cart);
            
            if ($row_count_cart == 0) {
                echo "<script>alert('Login Successful...');</script>";
                echo "<script>window.open('profile.php','_self');</script>";
            } else {
                echo "<script>alert('Login Successful... You have items in your cart.');</script>";
                echo "<script>window.open('payment.php','_self');</script>";
            }
        } else {
            echo "<script>alert('Invalid Credentials');</script>";
        }
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }
}
?>
