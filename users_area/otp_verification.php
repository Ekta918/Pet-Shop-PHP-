<?php
include("../includes/connect.php");
@session_start();

if (isset($_GET['email'])) {
    $user_email = $_GET['email'];
} else {
    echo "<script>alert('No email provided.'); window.location.href='forgot_password.php';</script>";
    exit();
}

if (isset($_POST['verify_otp'])) {
    $user_email = $_GET['email'];
    $entered_otp = $_POST['otp'];

    // Fetch the OTP from the database
    $select_query = "SELECT * FROM `otp_table` WHERE otp='$entered_otp' AND expires_at < NOW()";
    $result = mysqli_query($con, $select_query);

    if (mysqli_num_rows($result) > 0) {
        // OTP is valid, redirect to reset password page
        header("Location: reset_password.php?email=$user_email");
        exit();
    } else {
        echo "<script>alert('Invalid or expired OTP.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="otp" class="form-label">Enter OTP</label>
                <input type="text" id="otp" name="otp" class="form-control" required>
            </div>
            <button type="submit" name="verify_otp" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>
</body>
</html>
