<?php
include('../includes/connect.php');

if(isset($_POST['insert_product'])) {
    $product_title = $_POST['product_title'];
    $description = $_POST['description'];
    $product_keywords = $_POST['product_keywords'];
    $product_category = $_POST['product_category'];
    $product_brands = $_POST['product_brands'];
    $product_price = $_POST['product_price'];
    $product_status = 'true';

    // Accessing images
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];

    // Accessing image tmp name
    $temp_image1 = $_FILES['product_image1']['tmp_name'];
    $temp_image2 = $_FILES['product_image2']['tmp_name'];

    // Checking empty condition
    if ($product_title == '' || $description == '' || $product_keywords == '' || $product_category == '' 
    || $product_brands == '' || $product_price == '' || $product_image1 == '' || $product_image2 == '') {
        echo "<script>alert('Please fill all the available fields')</script>";
    } else 
    {
        move_uploaded_file($temp_image1, "./product_images/$product_image1");
        move_uploaded_file($temp_image2, "./product_images/$product_image2");

        // Insert query
        $insert_products = "INSERT INTO `products` (product_title, product_decription, product_keywords, category_id, brand_id, product_image1, product_image2, product_price, date, status) 
                            VALUES ('$product_title', '$description', '$product_keywords', '$product_category', '$product_brands', '$product_image1', '$product_image2', '$product_price', NOW(), '$product_status')";
        
        $result_query = mysqli_query($con, $insert_products);
        if ($result_query) {
            echo "<script>alert('Successfully inserted the products')</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products - Admin Dashboard</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 3rem;
        }
        h1 {
            font-size: 2.5rem; /* Adjust the font size */
            font-weight: 700; /* Make the text bold */
            color: #007bff; /* Set the color */
            text-align: center; /* Center-align the text */
            margin-bottom: 2rem; /* Space below the heading */
            padding: 10px; /* Space inside the heading */
            border-bottom: 2px solid #007bff; /* Optional: Add a border below */
        }
        .form-outline {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
            color: #555;
        }
        .form-control {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 10px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-end mb-3">
            <button class="btn btn-primary" id="toggleForm">
                <i class="fa-solid fa-plus"></i> Add Product
            </button>
        </div>

        <!-- Form (Initially Hidden) -->
        <div id="productFormContainer" style="display: none;">
        <h1>Insert Products</h1>
            <form id="product-form" action="" method="POST" enctype="multipart/form-data">
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter Product Title">
                <div class="error" id="error-product_title"></div>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label">Product Description</label>
                <input type="text" name="description" id="description" class="form-control" placeholder="Enter Product Description">
                <div class="error" id="error-description"></div>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_keywords" class="form-label">Product Keywords</label>
                <input type="text" name="product_keywords" id="product_keywords" class="form-control" placeholder="Enter Product Keywords">
                <div class="error" id="error-product_keywords"></div>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_category" id="product_category" class="form-select">
                    <option value="">Select a category</option>
                    <?php
                        $select_query = "SELECT * FROM `categories`";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
                            $category_title = $row['category_title'];
                            $category_id = $row['category_id'];
                            echo "<option value='$category_id'>$category_title</option>";
                        }
                    ?>
                </select>
                <div class="error" id="error-product_category"></div>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_brands" id="product_brands" class="form-select">
                    <option value="">Select a Brand</option>
                    <?php
                        $select_query = "SELECT * FROM `brands`";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
                            $brand_title = $row['brand_title'];
                            $brand_id = $row['brand_id'];
                            echo "<option value='$brand_id'>$brand_title</option>";
                        }
                    ?>
                </select>
                <div class="error" id="error-product_brands"></div>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image1" class="form-label">Product Image 1</label>
                <input type="file" name="product_image1" id="product_image1" class="form-control">
                <div class="error" id="error-product_image1"></div>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image2" class="form-label">Product Image 2</label>
                <input type="file" name="product_image2" id="product_image2" class="form-control">
                <div class="error" id="error-product_image2"></div>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="text" name="product_price" id="product_price" class="form-control" placeholder="Enter Product Price">
                <div class="error" id="error-product_price"></div>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_product" class="btn-primary mb-3 px-3" value="Insert Products">
            </div>
            </form>
        </div>

    </div>

    <h3 class="text-center text-success">All Products</h3>
<table class="table table-bordered mt-5">
    <thead>
        <tr class="text-center">
            <th>Product ID</th>
            <th>Product Title</th>
            <th>Product Image</th>
            <th>Product Price</th>
            <th>Total Sold</th>
            <th>Status</th>
            <th>Edit</th>
            <th>View</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
         <?php

        $get_products="select * from `products`";
        $result=mysqli_query($con,$get_products);
        $number=0;
        while($row=mysqli_fetch_assoc($result))
        {
            $product_id=$row['product_id'];
            $product_title=$row['product_title'];
            $product_image1=$row['product_image1'];
            $product_price=$row['product_price'];
            $status=$row['status'];
            $number++;
        ?>
            <tr class='text-center'>
            <td><?php echo $number; ?></td>
            <td><?php echo $product_title; ?></td>
            <td><img src='./product_images/<?php echo $product_image1; ?>' class='product_img'/></td>
            <td><?php echo $product_price; ?>/-</td>
            <td><?php 
            $get_count="select * from `orders_pending` where product_id=$product_id";
            $result_count=mysqli_query($con,$get_count);
            $rows_count=mysqli_num_rows($result_count);
            echo $rows_count;
            ?></td>
            <td><?php echo $status; ?></td>
            <td><a href='index.php?edit_products=<?php echo $product_id; ?>' class='btn btn-primary text-light'><i class='fa-solid fa-pen-to-square'></i></a></td>
            <td>
    <a href='view_product.php?view_product=<?php echo $product_id; ?>' class='btn btn-success text-light'>
        <i class='fas fa-eye'></i>
    </a>
</td>

            <td>
    <button 
        class='btn btn-danger text-light' 
        data-toggle='modal' 
        data-target='#exampleModal' 
        data-product-id='<?php echo $product_id; ?>'
        onclick="setDeleteId(<?php echo $product_id; ?>)"
    >
        <i class='fa-solid fa-trash-can'></i>
    </button>
</td>

        </tr>
        <?php
        }

        ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h4>Are you sure you want to delete this??</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <a href="./index.php?view_products" class="text-light text-decoration-none">No</a>
        </button>
        <button type="button" class="btn btn-primary" id="confirmDelete">
            <a href="index.php?delete_product=<?php echo $product_id; ?>" class='text-light text-decoration-none'>Yes</a>
        </button>
      </div>
    </div>
  </div>
</div>


    <script>
        // Toggle Form Visibility
        document.getElementById('toggleForm').addEventListener('click', function() {
            var formContainer = document.getElementById('productFormContainer');
            formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
        });

        document.getElementById('product-form').addEventListener('submit', function(event) {
            var isValid = true;

            // Clear previous errors
            var errors = document.getElementsByClassName('error');
            for (var i = 0; i < errors.length; i++) {
                errors[i].textContent = '';
            }

            // Get form values
            var productTitle = document.getElementById('product_title').value.trim();
            var description = document.getElementById('description').value.trim();
            var productKeywords = document.getElementById('product_keywords').value.trim();
            var productCategory = document.getElementById('product_category').value;
            var productBrands = document.getElementById('product_brands').value;
            var productImage1 = document.getElementById('product_image1').files.length;
            var productImage2 = document.getElementById('product_image2').files.length;
            var productPrice = document.getElementById('product_price').value.trim();

            // Validate fields
            if (productTitle === '') {
                document.getElementById('error-product_title').textContent = 'Product title is required.';
                isValid = false;
            }
            if (description === '') {
                document.getElementById('error-description').textContent = 'Description is required.';
                isValid = false;
            }
            if (productKeywords === '') {
                document.getElementById('error-product_keywords').textContent = 'Keywords are required.';
                isValid = false;
            }
            if (productCategory === '') {
                document.getElementById('error-product_category').textContent = 'Category is required.';
                isValid = false;
            }
            if (productBrands === '') {
                document.getElementById('error-product_brands').textContent = 'Brand is required.';
                isValid = false;
            }
            if (productImage1 === 0 || productImage2 === 0) {
                document.getElementById('error-product_image1').textContent = 'All three product images are required.';
                document.getElementById('error-product_image2').textContent = 'All three product images are required.';
                isValid = false;
            }
            if (productPrice === '') {
                document.getElementById('error-product_price').textContent = 'Price is required.';
                isValid = false;
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    var productIdToDelete = null;

    function setDeleteId(productId) {
        productIdToDelete = productId;
        document.getElementById('confirmDelete').href = 'index.php?delete_product=' + productId;
    }

    </script>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
