<?php
include("includes/connect.php");
include("functions/common_function.php");
session_start();

// Ensure product_id is defined
if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']); // Sanitize input
} else {
    echo "<script>alert('No product selected.');</script>";
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
      /* Align review section to the side (start) */
      .review-section {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-top: 20px;
}

.review-list {
    width: 100%; /* Full width to align to the left */
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    background-color: #f9f9f9;
    margin-right: 20px; /* Space to separate from the form */
}

.review-form {
    flex-grow: 1; /* Expand to fill remaining space */
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    background-color: #f9f9f9;
}

/* Star rating styling */
.star-rating {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 150px;
    cursor: pointer;
}

.star-rating i {
    color: #ccc;
    font-size: 1.5rem;
    transition: color 0.3s;
}

.star-rating i:hover,
.star-rating i.active {
    color: gold;
}

    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <img src="./images/l1.png" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="display_all.php">Products</a></li>
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo "<li class='nav-item'><a class='nav-link' href='./users_area/profile.php'>My Account</a></li>";
                        } else {
                            echo "<li class='nav-item'><a class='nav-link' href='./users_area/user_registration.php'>Register</a></li>";
                        }
                        ?>
                        <li class="nav-item"><a class="nav-link" href="about_us.php">About Us</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <sup><?php cart_item(); ?></sup>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Total Price: <?php total_cart_price(); ?>/-</a>
                        </li>
                    </ul>
                    <form class="d-flex" action="search_product.php" method="get">
                        <input class="form-control me-2" type="search" placeholder="Search" name="search_data">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Welcome Bar -->
        <nav class="navbar1 navbar-expand-lg">
            <ul class="navbar-nav me-auto">
                <?php
                if (!isset($_SESSION['username'])) {
                    echo "<li class='nav-item1'><a class='nav-link1' href='#'>Welcome Guest</a></li>";
                    echo "<li class='nav-item1'><a class='nav-link1' href='./users_area/user_login.php'>Login</a></li>";
                } else {
                    echo "<li class='nav-item1'><a class='nav-link1' href='#'>Welcome " . $_SESSION['username'] . "</a></li>";
                    echo "<li class='nav-item1'><a class='nav-link1' href='./users_area/logout.php'>Logout</a></li>";
                }
                ?>
            </ul>
        </nav>

        <div class="row px-1 mt-4">
    <?php
    // Display product details
    view_details();

    // Display unique categories and brands (if applicable)
    get_unique_categories();
    get_unique_brands();
    ?>
</div>

<!-- Reviews Section -->
<div class="row px-1 mt-4 review-section">
    <!-- Customer Reviews -->
    <div class="review-list">
        <h4 class="text-center">Customer Reviews</h4>
        <ul class="list-group">
            <?php
            $review_query = "SELECT * FROM `reviews` WHERE product_id = $product_id ORDER BY review_date DESC";
            $review_result = mysqli_query($con, $review_query);

            if (mysqli_num_rows($review_result) > 0) {
                while ($review = mysqli_fetch_assoc($review_result)) {
                    echo "<li class='list-group-item'>
                            <h5>{$review['user_name']} ({$review['rating']}/5)</h5>
                            <p>{$review['review_text']}</p>
                            <small class='text-muted'>Reviewed on {$review['review_date']}</small>
                          </li>";
                }
            } else {
                echo "<p class='text-center'>No reviews yet. Be the first to review this product!</p>";
            }
            ?>
        </ul>
    </div>

    <!-- Review Form -->
    <div class="review-form">
        <h4 class="text-center">Leave a Review</h4>
        <form action="submit_review.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="mb-3">
                <label for="user_name" class="form-label">Your Name</label>
                <input type="text" class="form-control" name="user_name" required>
            </div>
            <div class="mb-3">
                <label for="user_email" class="form-label">Your Email</label>
                <input type="email" class="form-control" name="user_email" required>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <div class="star-rating">
                    <i class="fa-solid fa-star" data-value="1"></i>
                    <i class="fa-solid fa-star" data-value="2"></i>
                    <i class="fa-solid fa-star" data-value="3"></i>
                    <i class="fa-solid fa-star" data-value="4"></i>
                    <i class="fa-solid fa-star" data-value="5"></i>
                </div>
                <input type="hidden" name="rating" id="rating-input" required>
            </div>
            <div class="mb-3">
                <label for="review_text" class="form-label">Your Review</label>
                <textarea class="form-control" name="review_text" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
</div>


    </div>

    <!-- Footer -->
    <?php include("./includes/Footer.php"); ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.star-rating i').forEach(star => {
        star.addEventListener('click', function () {
            const rating = this.getAttribute('data-value');
            document.getElementById('rating-input').value = rating;

            // Highlight stars up to the selected rating
            document.querySelectorAll('.star-rating i').forEach(s => {
                s.classList.toggle('active', s.getAttribute('data-value') <= rating);
            });
        });

        star.addEventListener('mouseover', function () {
            const hoverValue = this.getAttribute('data-value');
            document.querySelectorAll('.star-rating i').forEach(s => {
                s.classList.toggle('hover', s.getAttribute('data-value') <= hoverValue);
            });
        });

        star.addEventListener('mouseout', function () {
            document.querySelectorAll('.star-rating i').forEach(s => s.classList.remove('hover'));
        });
    });
</script>

</body>
</html>
