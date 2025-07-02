<?php
include("../includes/connect.php");
//include("../functions/common_function.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    
    <!-- font awesome link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!--css file-->
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <style>
    body
    {
        overflow-x:hidden;
    }
    .product_img
    {
        width:100px;
        object-fit:contain;
    }

    </style>
    </head>
<body>
        <!--Third child-->
        <!-- navbar -->
     <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <img src="../images/l1.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
          <?php
          if(!isset($_SESSION['username']))
        {
          echo "<li class='nav-item'>
          <a class='nav-link active' aria-current='page' href='admin_login.php'><i class='fas fa-sign-in-alt'></i>
</i></a>
        </li>";
        }
        else
        {
          echo "<li class='nav-item'>
          <a class='nav-link active' aria-current='page' href='logout.php'><i class='fas fa-sign-out-alt'></i></a>
        </li>";
        }
        ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?admin_dashboard">Admin Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?insert_product">Add Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?insert_category">Add Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?insert_brand">Add Brand</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?list_orders">Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?list_payment">Payments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?list_users">Users</a>
        </li>
        <!-- Dropdown for Admin Profile options -->
        <div class="dropdown">
          <button class="btn btn-outline-light dropdown-toggle" type="button" id="adminProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user-circle fa-lg"></i> <!-- Larger icon -->
          </button>
          <ul class="dropdown-menu" aria-labelledby="adminProfileDropdown">
            <li><a class="dropdown-item" href="admin_profile.php">View Profile</a></li>
            <li><a class="dropdown-item" href="admin_forgot_password.php">Change Password</a></li>
          </ul>
        </div>
        <div class="dropdown">
    <button class="btn btn-outline-light dropdown-toggle" type="button" id="siteSettingsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        Site Settings
    </button>
    <ul class="dropdown-menu" aria-labelledby="siteSettingsDropdown">
        <li><a class="dropdown-item" href="admin_manage_about.php">About Page</a></li>
        <li><a class="dropdown-item" href="admin_manage_inquiry.php">Inquiry</a></li>
        <li><a class="dropdown-item" href="admin_manage_contact.php">Contact Us</a></li>
        <li><a class="dropdown-item" href="admin_manage_slider.php">Slider</a></li>
        <li><a class="dropdown-item" href="admin_offers.php">Offer Management</a></li>
        <li><a class="dropdown-item" href="admin_reviews.php">Reviews</a></li>
    </ul>
</div>


      </ul>
    </div>
  </div>
</nav>

    
        <!--Fourth Child-->
        <div class="container my-5">
            <?php
            if(isset($_GET['admin_dashboard']))
            {
                include('admin_dashboard.php');
            }
            if (isset($_GET['about_us'])) {
                include('about_us.php'); // Include the about us page
            }
            
            if (isset($_GET['contact_us'])) {
                include('contact_us.php'); // Include the contact us page
            }
            
            if (isset($_GET['faq'])) {
                include('faq.php'); // Include the FAQ page
            }
            if(isset($_GET['admin_registration']))
            {
                include('admin_registration.php');
            }
            if(isset($_GET['insert_product']))
            {
                include('insert_product.php');
            }
            if(isset($_GET['insert_category']))
            {
                include('insert_categories.php');
            }
            if(isset($_GET['insert_brand']))
            {
                include('insert_brands.php');
            }
            if(isset($_GET['edit_products']))
            {
                include('edit_products.php');
            }
            if(isset($_GET['delete_product']))
            {
                include('delete_product.php');
            }
            if(isset($_GET['edit_category']))
            {
                include('edit_category.php');
            }
            if(isset($_GET['edit_brand']))
            {
                include('edit_brand.php');
            }
            if(isset($_GET['delete_category']))
            {
                include('delete_category.php');
            }
            if(isset($_GET['delete_brand']))
            {
                include('delete_brand.php');
            }
            if(isset($_GET['delete_payment']))
            {
                include('delete_payment.php');
            }
            if(isset($_GET['delete_user']))
            {
                include('delete_user.php');
            }
            if(isset($_GET['list_orders']))
            {
                include('list_orders.php');
            }
            if(isset($_GET['delete_order']))
            {
                include('delete_order.php');
            }
            if(isset($_GET['list_payment']))
            {
                include('list_payment.php');
            }
            if(isset($_GET['list_users']))
            {
                include('list_users.php');
            }
            if(isset($_GET['view_user']))
            {
                include('view_user.php');
            }
            if(isset($_GET['view_product']))
            {
                include('view_product.php');
            }
            ?>
        </div>
        
        <!--last child-->
<?php
include("footer2.php");
?>
    </div>
<!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
