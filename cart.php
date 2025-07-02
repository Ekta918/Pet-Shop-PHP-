<?php
include("includes/connect.php");
include("functions/common_function.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        .table img { width: 80px; height: 80px; object-fit: contain; }
        .table td, .table th { padding: 10px; }
        .checkout-button {
    background-color: #4CAF50; /* Green background */
    color: white; /* White text */
    border: none; /* Remove borders */
    padding: 12px 24px; /* Add padding */
    font-size: 16px; /* Increase font size */
    font-weight: bold; /* Bold text */
    text-align: center; /* Center the text */
    cursor: pointer; /* Pointer cursor on hover */
    border-radius: 5px; /* Rounded corners */
    transition: background-color 0.3s, transform 0.2s; /* Add transition effects */
}

.checkout-button:hover {
    background-color: #45a049; /* Darker green on hover */
    transform: scale(1.05); /* Slightly increase size on hover */
}

.checkout-button:active {
    background-color: #388E3C; /* Even darker green when clicked */
    transform: scale(0.98); /* Slightly shrink on click */
}

    </style>
</head>
<body>
<div class="container-fluid p-0">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <img src="./images/l1.png" alt="" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="display_all.php">Products</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="./users_area/profile.php">My Account</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="./users_area/user_registration.php">Register</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="about_us.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a></li>
                    <li class="nav-item"><a class="nav-link" href="wishlist.php"><i class="fa-solid fa-heart"></i><sup><?php wishlist_item_count(); ?></sup></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Welcome and Login Section -->
    <nav class="navbar1 navbar-expand-lg">
        <ul class="navbar-nav me-auto">
            <?php if (!isset($_SESSION['username'])): ?>
                <li class="nav-item1"><a class="nav-link1">Welcome Guest</a></li>
                <li class="nav-item1"><a class="nav-link1" href="./users_area/user_login.php">Login</a></li>
            <?php else: ?>
                <li class="nav-item1"><a class="nav-link1">Welcome <?php echo $_SESSION['username']; ?></a></li>
                <li class="nav-item1"><a class="nav-link1" href="./users_area/logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Cart Details -->
    <div class="container mt-4">
        <form action="" method="post">
            <table class="table table-bordered text-center">
                <tbody>
                <?php
                global $con;
                $get_ip_add = getIPAddress();
                $total_price = 0;
                $cart_query = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip_add'";
                $result = mysqli_query($con, $cart_query);
                $result_count = mysqli_num_rows($result);
                if ($result_count > 0):
                    ?>
                    <thead>
                    <tr>
                        <th>Product Title</th>
                        <th>Product Image</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Remove</th>
                        <th colspan="2">Operations</th>
                    </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_array($result)):
                        $product_id = $row['product_id'];
                        $select_products = "SELECT * FROM `products` WHERE product_id='$product_id'";
                        $result_products = mysqli_query($con, $select_products);
                        while ($row_product_price = mysqli_fetch_array($result_products)):
                            $price_table = $row_product_price['product_price'];
                            $product_title = $row_product_price['product_title'];
                            $product_image1 = $row_product_price['product_image1'];
                            $total_price += $price_table;
                            ?>
                            <tr>
                                <td><?php echo $product_title; ?></td>
                                <td><img src="./admin_area/product_images/<?php echo $product_image1; ?>" alt=""></td>
                                <td><input type="text" name="qty" class="form-input w-50"></td>
                                <?php
                                        if (isset($_POST['update_cart'])) {
                                            $quantities = $_POST['qty'];
                                            $update_cart = "UPDATE `cart_details` SET quantity=$quantities WHERE ip_address='$get_ip_add'";
                                            $result_products_quntity = mysqli_query($con, $update_cart);
                                            $total_price = $total_price * $quantities;
                                        }
                                        ?>
                                <td><?php echo $price_table; ?>/-</td>
                                <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id; ?>"></td>
                                <td>
                                    <input type="submit" value="Update Cart" name="update_cart" class="bg-info px-3 py-2 border-0">
                                    <input type="submit" value="Remove item" name="remove_cart" class="bg-danger px-3 py-2 border-0">
                                </td>
                            </tr>
                        <?php endwhile; endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h3 class="text-center text-danger">Cart is empty!!</h3>
        <?php endif; ?>
        </form>

        <!-- Subtotal and Offer Section -->
        <?php if ($result_count > 0): ?>
            <div class="d-flex justify-content-between mb-4">
                <?php
                $final_total = isset($_SESSION['discounted_price']) ? $_SESSION['discounted_price'] : $total_price;
                echo "<h4>Original Subtotal: <span class='text-danger'>$total_price/-</span></h4>";
                if (isset($_SESSION['discounted_price'])):
                    $discount = $total_price - $_SESSION['discounted_price'];
                    //echo "<h4>Discount: <span class='text-success'>- $discount/-</span></h4>";
                endif;
                ?>
                <!-- <h4>Final Total: <span class="text-success"><?php echo $final_total; ?>/-</span></h4> -->
            </div>

            <!-- Offer Code Form -->
            <form action="" method="post" class="text-center">
                <input type="text" name="offer_code" placeholder="Enter Offer Code" class="form-control w-50 mx-auto mb-3">
                <input type="submit" name="apply_offer" value="Apply Code" class="btn btn-success mb-3">
            </form>

            <?php
            if (isset($_POST['apply_offer'])):
                $offer_code = mysqli_real_escape_string($con, $_POST['offer_code']);
                $offer_query = "SELECT * FROM `offers` WHERE code='$offer_code' AND status='active'";
                $offer_result = mysqli_query($con, $offer_query);
                if (mysqli_num_rows($offer_result) > 0):
                    $offer_row = mysqli_fetch_assoc($offer_result);
                    $discount = $offer_row['discount'];
                    $final_total = (int)($total_price - ($total_price * ($discount / 100)));
                    $_SESSION['discounted_price'] = $final_total;
                    echo "<h4 class='text-success'>Offer Applied! New Total: <strong>$final_total/-</strong></h4>";
                else:
                    echo "<h4 class='text-danger'>Invalid or Expired Offer Code!</h4>";
                endif;
            endif;
            ?>

            <!-- Checkout Section -->
            <form action="./users_area/razorpay_payment.php" method="post" class="text-center">
                <input type="hidden" name="total_price" value="<?php echo $final_total; ?>">
                <button class="checkout-button mb-3">Checkout with Razorpay</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<!-- Address Section -->
<div class="container mt-4">
    <h3 class="text-center">Your Shipping Address</h3>
    <?php
    global $con;

    // Retrieve the address from user_payments
    $get_ip_add = getIPAddress();
    $address_query = "SELECT * FROM `user_payments` WHERE ip_address='$get_ip_add' ORDER BY payment_id DESC LIMIT 1";
    $address_result = mysqli_query($con, $address_query);

    if (mysqli_num_rows($address_result) > 0) {
        $row_address = mysqli_fetch_assoc($address_result);
        $user_address = $row_address['address'];
        $payment_id = $row_address['payment_id'];

        echo "
        <div class='text-center'>
            <p><strong>Address:</strong> $user_address</p>
            <form action='' method='post' style='display: inline-block;'>
                <input type='submit' name='edit_address' value='Edit Address' class='btn btn-warning mx-2 mb-5'>
                <input type='submit' name='delete_address' value='Delete Address' class='btn btn-danger mx-2 mb-5'>
            </form>
        </div>
        ";
    } else {
        echo "
        <form action='' method='post' class='text-center'>
            <textarea name='new_address' class='form-control w-50 mx-auto my-3' placeholder='Enter your address'></textarea>
            <input type='submit' name='add_address' value='Add Address' class='btn btn-success mb-5'>
        </form>
        ";
    }

    // Add Address
    if (isset($_POST['add_address'])) {
        $new_address = mysqli_real_escape_string($con, $_POST['new_address']);
        if (!empty($new_address)) {
            $insert_address_query = "INSERT INTO `user_payments` (ip_address, address) VALUES ('$get_ip_add', '$new_address')";
            mysqli_query($con, $insert_address_query);
            echo "<script>alert('Address added successfully!'); window.location.href='cart.php';</script>";
        }
    }

    // Edit Address
    if (isset($_POST['edit_address'])) {
        echo "
        <form action='' method='post' class='text-center'>
            <textarea name='updated_address' class='form-control w-50 mx-auto my-3'>$user_address</textarea>
            <input type='submit' name='save_address' value='Save Address' class='btn btn-primary'>
        </form>
        ";
    }

    if (isset($_POST['save_address'])) {
        $updated_address = mysqli_real_escape_string($con, $_POST['updated_address']);
        $update_address_query = "UPDATE `user_payments` SET address='$updated_address' WHERE payment_id='$payment_id'";
        mysqli_query($con, $update_address_query);
        echo "<script>alert('Address updated successfully!'); window.location.href='cart.php';</script>";
    }

    // Delete Address
    if (isset($_POST['delete_address'])) {
        $delete_address_query = "DELETE FROM `user_payments` WHERE payment_id='$payment_id'";
        mysqli_query($con, $delete_address_query);
        echo "<script>alert('Address deleted successfully!'); window.location.href='cart.php';</script>";
    }
    ?>
</div>


<?php
// Function to remove item
function remove_cart_item() {
    global $con;
    if (isset($_POST['remove_cart'])) {
        foreach ($_POST['removeitem'] as $remove_id) {
            $delete_query = "DELETE FROM `cart_details` WHERE product_id=$remove_id";
            $run_delete = mysqli_query($con, $delete_query);
            if ($run_delete) {
                echo "<script>window.open('cart.php','_self')</script>";
            }
        }
    }
}
echo $remove_item = remove_cart_item();
?>

<!-- Include Footer -->
<?php include("./includes/Footer.php"); ?>
</body>
</html>
