<?php
//include_once("header.php");
//include_once("admin_authentication.php");

?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Bootstrap JS link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<!-- Custom CSS -->
<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .card i {
        font-size: 3rem;
        margin-bottom: 10px;
        color:rgb(157, 185, 211); /* Gold icon color */
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .card-text {
        font-size: 1.5rem;
        font-weight: bold;
    }

    h1 {
    margin-top: -130px;  /* Reduced margin-top */
    margin-bottom: -100px;
    font-size: 2.5rem;
    font-weight: bold;
    color: #343a40;
}


    .container {
        padding-top: 50px;
        padding-bottom: 50px;
    }
</style>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0sG1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Admin Dashboard</h1>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body text-center">
                        <i class="fas fa-users"></i>
                        <h5 class="card-title">Total Users</h5>
                        <?php
                        $query = "SELECT COUNT(*) as total_users FROM user_table";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo '<p class="card-text">' . $row['total_users'] . '</p>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body text-center">
                        <i class="fas fa-boxes"></i>
                        <h5 class="card-title">Total Products</h5>
                        <?php
                        $query = "SELECT COUNT(*) as total_products FROM products";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo '<p class="card-text">' . $row['total_products'] . '</p>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-bag"></i>
                        <h5 class="card-title">Total Orders</h5>
                        <?php
                        $query = "SELECT COUNT(*) as total_orders FROM user_orders";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo '<p class="card-text">' . $row['total_orders'] . '</p>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope"></i>
                        <h5 class="card-title">Total Inquiries</h5>
                        <?php
                        $query = "SELECT COUNT(*) as total_inquiry FROM contact_messages";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo '<p class="card-text">' . $row['total_inquiry'] . '</p>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body text-center">

                        <i class="fas fa-user-check"></i>
                        <h5 class="card-title">Active Users</h5>
                        <?php
                        $query = "SELECT COUNT(*) as total_users FROM user_table where status='Active'";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo '<p class="card-text">' . $row['total_users'] . '</p>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body text-center">
                        <i class="fas fa-user-times"></i>
                        <h5 class="card-title">Inactive Users</h5>
                        <?php
                        $query = "SELECT COUNT(*) as total_users FROM user_table where status='Inactive'";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo '<p class="card-text">' . $row['total_users'] . '</p>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body text-center">
                        <i class="fas fa-clock"></i>
                        <h5 class="card-title">Pending Orders</h5>
                        <?php
                        $query = "SELECT COUNT(*) as total_pending FROM orders_pending";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo '<p class="card-text">' . $row['total_pending'] . '</p>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-check"></i>
                        <h5 class="card-title">Today's Orders</h5>
                        <?php
                        $query = "SELECT COUNT(*) as total_cart FROM cart_details";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo '<p class="card-text">' . $row['total_cart'] . '</p>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
