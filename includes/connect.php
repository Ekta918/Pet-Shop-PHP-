<!-- <?php

$con=mysqli_connect('localhost','root','','myshop');
if(!$con)
{
    die(mysqli_error($con));
    
}

?> -->

<?php
// Database credentials
$host = 'localhost';      // Database host (usually localhost)
$db = 'myshop'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

// PDO connection setup
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If there is an error with the connection, display the error message
    echo "Connection failed: " . $e->getMessage();
}
?>
