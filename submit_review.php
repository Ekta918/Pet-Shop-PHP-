<?php
include("includes/connect.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $rating = intval($_POST['rating']);
    $review_text = mysqli_real_escape_string($con, $_POST['review_text']);
    
    // Debugging information
    echo "Product ID: $product_id";
    $product_check_query = "SELECT * FROM `products` WHERE `product_id` = '$product_id'";
    $product_check_result = mysqli_query($con, $product_check_query);
    
    if (mysqli_num_rows($product_check_result) == 0) {
        echo "<script>alert('Invalid product ID.');</script>";
        exit();
    }

    $insert_query = "INSERT INTO `reviews` (product_id, user_name, user_email, rating, review_text) 
                     VALUES ('$product_id', '$user_name', '$user_email', '$rating', '$review_text')";
    
    $result = mysqli_query($con, $insert_query);

    if ($result) {
        echo "<script>alert('Review submitted successfully!');</script>";
        echo "<script>window.location.href = 'product_detail.php?product_id=$product_id';</script>";
    } else {
        echo "MySQL Error: " . mysqli_error($con);
    }
}
?>
