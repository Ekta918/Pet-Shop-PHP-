<?php
include("../includes/connect.php"); // Database connection
session_start();

// If you have an admin session check, you can add it here:
// if (!isset($_SESSION['admin_username'])) {
//     header("Location: admin_login.php");
//     exit();
// }

// Handle Review Deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM `reviews` WHERE review_id = $delete_id";
    
    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Review deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting review');</script>";
    }
}

// Fetch All Reviews
$review_query = "SELECT * FROM `reviews` ORDER BY review_date DESC";
$review_result = mysqli_query($con, $review_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Reviews</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Main Content -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Manage Product Reviews</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Review ID</th>
                    <th scope="col">Product ID</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Review Text</th>
                    <th scope="col">Review Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($review_result) > 0) {
                    while ($review = mysqli_fetch_assoc($review_result)) {
                        echo "<tr>
                                <td>{$review['review_id']}</td>
                                <td>{$review['product_id']}</td>
                                <td>{$review['user_name']}</td>
                                <td>{$review['rating']}</td>
                                <td>{$review['review_text']}</td>
                                <td>{$review['review_date']}</td>
                                <td>
                                    <a href='admin_reviews.php?delete_id={$review['review_id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this review?\")'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No reviews found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
