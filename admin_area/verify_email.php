<?php
include("../includes/connect.php");
@session_start();

if (isset($_GET['token'])) {
    $verification_token = $_GET['token'];

    $update_query = "UPDATE `admin_table` SET is_verified = 1 WHERE verification_token='$verification_token'";
    $sql_execute = mysqli_query($con, $update_query);

    if ($sql_execute) {
        echo "<script>alert('Email verified successfully! You can now log in.')</script>";
        echo "<script>window.open('admin_login.php', '_self')</script>";
    } else {
        echo "<script>alert('Verification failed. Please try again.')</script>";
    }
} else {
    echo "<script>alert('No verification token provided.')</script>";
}
?>
