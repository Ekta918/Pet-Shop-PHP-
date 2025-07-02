<?php
include("../includes/connect.php"); // Include your database connection file

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $query = "SELECT * FROM user_table WHERE verification_token = '$token'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Token exists, update user status to active
        $update_query = "UPDATE user_table SET status = 'active', verification_token = NULL WHERE verification_token = '$token'";
        mysqli_query($con, $update_query);

        echo "Email verification successful! You can now log in.";
    } else {
        echo "Invalid verification token.";
    }
} else {
    echo "No token provided.";
}
?>

