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
    <title>ECommerce Website</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
     <!-- font awesome link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!--css file-->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <img src="./images/l1.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="display_all.php">Products</a>
        </li>
        <?php

        if(isset($_SESSION['username']))
        {
          echo "<li class='nav-item'>
          <a class='nav-link' href='./users_area/profile.php'>My Account</a>
        </li>";
        }
        else
        {
          echo "<li class='nav-item'>
          <a class='nav-link' href='./users_area/user_registration.php'>Register</a>
        </li>";
        }

        ?>
        <li class="nav-item">
          <a class="nav-link" href="about_us.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php
          cart_item();?></sup></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Total Price: <?php
          total_cart_price();?>/-</a>
        </li>
      </ul>
      <form class="d-flex" action="search_product.php" method="get">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
        <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
      </form>
    </div>
  </div>
</nav>

<!--second child-->
<nav class="navbar1 navbar-expand-lg">
    <ul class="navbar-nav me-auto">
        <?php
        if(!isset($_SESSION['username']))
        {
          echo "<li class='nav-item1'>
          <a class='nav-link1 active' aria-current='page' href='#'>Welcome Guest</a>
        </li>";
        }
        else
        {
          echo "<li class='nav-item1'>
          <a class='nav-link1 active' aria-current='page' href='#'>Welcome ".$_SESSION['username']."</a>
          </li>";
        }

        if(!isset($_SESSION['username']))
        {
          echo "<li class='nav-item1'>
          <a class='nav-link1 active' aria-current='page' href='./users_area/user_login.php'>Login</a>
        </li>";
        }
        else
        {
          echo "<li class='nav-item1'>
          <a class='nav-link1 active' aria-current='page' href='./users_area/logout.php'>Logout</a>
        </li>";
        }
        ?> 
    </ul>
</nav>

<!--third child-->
<div class="bg-light">
    <h3 class="text-center">Welcome to our Pet Shop!</h3>
    <p class="text-center">Find the perfect pet for your family.</p>
</div>
<!--fourth child-->
<div class="row px-1">
    <div class="col-md-10">
        <!--Products-->
        <div class="row">
        <?php
          search_product();
          get_unique_categories();
          get_unique_brands();
        ?>
          <!-- fetching products-->
        <!--<div class="col-md-4 mb-2">
        <div class="card">
          <img src="./images/3.jpg" class="card-img-top" alt="...">
          <div class="card-body">
          <h5 class="card-title">Samsung Galaxy S24</h5>
          <p class="card-text">Samsung Galaxy S24 Ultra 5G AI Smartphone (Titanium Violet, 12GB, 256GB Storage)</p>
          <a href="#" class="btn btn-primary">Add to Cart</a>
          <a href="#" class="btn btn-secondary">View More</a>
          </div>
        </div>
        </div>-->

        <!--Row end-->
        </div>
    <!--column end-->
    </div>
    <div class="sidebar-item col-md-2 p-0">
        <!--sidenav-->
        <!-- Brands to be displayed-->
        <ul class="navbar-nav me-auto text-center">
          <li class="nav-item2">
            <a href="#" class="nav-link text-light"><h4 class="side-nav-heading">Delivery Brands</h4></a>
          </li>
          <?php

          getbrands();

          ?>
        </ul>
        <!-- Categories to be displayed-->
        <ul class="navbar-nav me-auto text-center">
          <li class="nav-item2">
            <a href="#" class="nav-link text-light"><h4 class="side-nav-heading">Categories</h4></a>
          </li>
          <?php
            getcategories();
          ?>
        </ul>
    </div>
</div>

<!--last child-->
<?php
include("./includes/Footer.php")
?>
     </div>
     <!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>