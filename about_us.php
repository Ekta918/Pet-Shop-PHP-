<?php
include("includes/connect.php");
include("functions/common_function.php");
session_start();
$query = "SELECT * FROM about_us WHERE id=1";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result);

$team_members = json_decode($data['team_members'], true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Shop</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <!-- font awesome link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!--css file-->
    <link rel="stylesheet" href="style.css">
    <style>
      body
      {
        overflow-x:hidden;
      }
    </style>
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

<!--calling cart function-->
<?php
  cart();
?>

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

<!-- About Us Page -->
<div class="container about-section">
    <div class="row">
        <div class="col-lg-6">
            <img src="images/42.webp" alt="About Us" class="about-img">
        </div>
        <div class="col-lg-6">
            <h2 class="section-heading"><?php echo htmlspecialchars($data['heading']); ?></h2>
            <p class="section-subheading"><?php echo nl2br(htmlspecialchars($data['content'])); ?></p>
        </div>
        
    </div>
</div>

<!-- Team Section -->
<div class="container">
    <h2 class="section-heading">Meet Our Team</h2>
    <div class="row">
        <?php foreach ($team_members as $member): ?>
            <div class="col-md-4 mb-4">
                <div class="team-member">
                    <img src="<?php echo htmlspecialchars($member['image']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" class="team-img">
                    <h5><?php echo htmlspecialchars($member['name']); ?></h5>
                    <p><?php echo htmlspecialchars($member['role']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!--last child-->
<?php
include("./includes/Footer.php");
?>
</div>
     <!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>