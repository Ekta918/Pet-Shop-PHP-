<?php
include('../includes/connect.php');

// Check if the view_product parameter is set
if (isset($_GET['view_product'])) {
    $product_id = intval($_GET['view_product']); // Get the product ID from the URL

    // Fetch product details
    $get_product = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($con, $get_product);

    // Check if the product was found
    if ($result && mysqli_num_rows($result) > 0) {
        $product_data = mysqli_fetch_assoc($result);
    } else {
        echo "<h2>Product not found!</h2>";
        exit;
    }
} else {
    echo "<h2>Invalid product ID!</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 3rem;
        }
        h3 {
            color: #007bff;
        }
        .product-image {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Product Details</h3>
        <table class="table table-bordered">
            <tr>
                <td><strong>Product ID:</strong></td>
                <td><?php echo $product_data['product_id']; ?></td>
            </tr>
            <tr>
                <td><strong>Product Title:</strong></td>
                <td><?php echo $product_data['product_title']; ?></td>
            </tr>
            <tr>
                <td><strong>Description:</strong></td>
                <td><?php echo $product_data['product_decription']; ?></td>
            </tr>
            <tr>
                <td><strong>Category ID:</strong></td>
                <td><?php echo $product_data['category_id']; ?></td>
            </tr>
            <tr>
                <td><strong>Brand ID:</strong></td>
                <td><?php echo $product_data['brand_id']; ?></td>
            </tr>
            <tr>
                <td><strong>Product Image 1:</strong></td>
                <td><img src="./product_images/<?php echo $product_data['product_image1']; ?>" alt="Product Image" class="product-image" /></td>
            </tr>
            <tr>
                <td><strong>Product Image 2:</strong></td>
                <td><img src="./product_images/<?php echo $product_data['product_image2']; ?>" alt="Product Image" class="product-image" /></td>
            </tr>
            <tr>
                <td><strong>Product Price:</strong></td>
                <td><?php echo $product_data['product_price']; ?>/-</td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td><?php echo $product_data['status']; ?></td>
            </tr>
        </table>
        <a href="index.php?view_products" class="btn btn-secondary">Back to Products</a>
    </div>
    
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
