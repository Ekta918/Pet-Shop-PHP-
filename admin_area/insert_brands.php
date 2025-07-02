<?php
include('../includes/connect.php');
if(isset($_POST['insert_brand']))
{
    $brand_title=$_POST['brand_title'];

    //select data from database
    $select_query="select * from `brands` where brand_title='$brand_title'";
    $result_select=mysqli_query($con,$select_query);
    $number=mysqli_num_rows($result_select);
    if($number>0)
    {
        echo "<script>alert('This brand is present inside the database')</script>";
    }
    else{
    $insert_query="insert into `brands` (brand_title) values('$brand_title')";
    $result=mysqli_query($con,$insert_query);
    if($result)
    {
        echo "<script>alert('Brand has been inserted successfully')</script>";
    }
}
}

?>
<!-- Bootstrap CSS link -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- Bootstrap JS link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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
    <div class="text-end mb-3">
            <button class="btn btn-primary" id="toggleForm">
                <i class="fa-solid fa-plus"></i> Add Brand
            </button>
        </div>
        <div id="productFormContainer" style="display: none;">
        <h1 class="text-center">Insert Brands</h2>
        <form id="product-form" action="" method="POST" enctype="multipart/form-data">
<div class="input-group w-90 mb-2">
  <span class="input-group-text bg-primary" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
  <input type="text" class="form-control" name="brand_title" placeholder="Insert Brands" aria-label="brands" aria-describedby="basic-addon1">
</div>
<div class="input-group w-10 mb-2 m-auto">
  <input type="submit" class="bg-primary border-0 p-2 my-3" name="insert_brand" value="Insert Brands">
</div>

</form>
      </div>
<h3 class="text-center text-success">All Brands</h3>
<table class="table table-bordered mt-5">
    <thead class="text-center">
        <tr>
            <th>Sl no</th>
            <th>Brand Title</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody class="text-center">
         <?php
        $select_brand="select * from `brands`";
        $result=mysqli_query($con,$select_brand);
        $number=0;
        while($row=mysqli_fetch_assoc($result))
        {
            $brand_id=$row['brand_id'];
            $brand_title=$row['brand_title'];
            $number++;
        ?>
        <tr>
            <td><?php echo $number; ?></td>
            <td><?php echo $brand_title; ?></td>
            <td><a href='index.php?edit_brand=<?php echo $brand_id; ?>' class='text-light btn btn-primary'><i class='fa-solid fa-pen-to-square'></i></a></td>
            <td>
    <button 
        class='btn btn-danger text-light' 
        data-toggle='modal' 
        data-target='#exampleModal' 
        data-brand-id='<?php echo $brand_id; ?>'
        onclick="setDeleteId(<?php echo $brand_id; ?>)">
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
        <h4>Are you sure you want to delete this brand?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            No
        </button>
        <a id="confirmDelete" class="btn btn-primary" href="index.php?delete_brand=<?php echo $brand_id; ?>">
            Yes
        </a>
      </div>
    </div>
  </div>
</div>


<script>
  var brandIdToDelete = null;

  function setDeleteId(brandId) {
      brandIdToDelete = brandId;
      // Update the href attribute of the confirmDelete button with the correct brand ID
      document.getElementById('confirmDelete').setAttribute('href', 'index.php?delete_brand=' + brandId);
  }
  // Toggle Form Visibility
  document.getElementById('toggleForm').addEventListener('click', function() {
            var formContainer = document.getElementById('productFormContainer');
            formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
        });

</script>

