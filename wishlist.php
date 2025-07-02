<?php
include("includes/connect.php");
include("functions/common_function.php");  // Include the function file
session_start();

// Remove product from wishlist
if (isset($_GET['remove_from_wishlist'])) {
    $product_id_to_remove = $_GET['remove_from_wishlist'];
    $get_ip_add = getIPAddress();
    
    // Remove from wishlist details based on the product_id and user IP
    $remove_query = "DELETE FROM `wishlist_details` WHERE product_id='$product_id_to_remove' AND ip_address='$get_ip_add'";
    $run_remove = mysqli_query($con, $remove_query);

    if ($run_remove) {
        echo "<script>alert('Product removed from wishlist');</script>";
        echo "<script>window.open('wishlist.php', '_self');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <head>
        <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

    <style>
        /* Add CSS styles for the wishlist page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        td img {
            width: 100px;
            height: auto;
        }

        a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 100%;
                margin: 10px;
            }

            th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <img src="./images/l1.png" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="display_all.php">Products</a>
                        </li>
                        <?php
                        if(isset($_SESSION['username'])) {
                            echo "<li class='nav-item'>
                                    <a class='nav-link' href='./users_area/profile.php'>My Account</a>
                                  </li>";
                        } else {
                            echo "<li class='nav-item'>
                                    <a class='nav-link' href='./users_area/user_registration.php'>Register</a>
                                  </li>";
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="about_us.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wishlist.php"><i class="fa-solid fa-heart"></i><sup><?php wishlist_item_count(); ?></sup></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    <h2>Your Wishlist</h2>
    <table>
        <thead>
            <tr>
                <th>Product Title</th>
                <th>Product Image</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Get the user's IP address using the function
            $get_ip_add = getIPAddress();
            $wishlist_query = "SELECT * FROM `wishlist_details` WHERE ip_address='$get_ip_add'";
            $result_wishlist = mysqli_query($con, $wishlist_query);
            
            if (mysqli_num_rows($result_wishlist) > 0) {
                while ($row = mysqli_fetch_array($result_wishlist)) {
                    $product_id = $row['product_id'];
                    $select_product_query = "SELECT * FROM `products` WHERE product_id='$product_id'";
                    $result_product = mysqli_query($con, $select_product_query);
                    while ($product = mysqli_fetch_array($result_product)) {
                        $product_title = $product['product_title'];
                        $product_image1 = $product['product_image1'];
                        ?>
                        <tr>
                            <td><?php echo $product_title; ?></td>
                            <td><img src="./admin_area/product_images/<?php echo $product_image1; ?>" alt=""></td>
                            <td><a href="wishlist.php?remove_from_wishlist=<?php echo $product_id; ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></a></td>
                        </tr>
                        <?php
                    }
                }
            } else {
                echo "<tr><td colspan='3'>Your wishlist is empty</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    include("./includes/Footer.php");
    ?>
</body>
</html>
