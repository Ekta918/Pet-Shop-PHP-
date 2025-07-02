<?php

if(isset($_GET['edit_account']))
{
    //global $con;
    $user_session_name=$_SESSION['username'];
    $select_query="select * from `user_table` where username='$user_session_name'";
    $result_query=mysqli_query($con,$select_query);
    $row_fetch=mysqli_fetch_assoc($result_query);
    $user_id=$row_fetch['user_id'];
    $username=$row_fetch['username'];
    $user_email=$row_fetch['user_email'];
    $user_address=$row_fetch['user_address'];
    $user_mobile=$row_fetch['user_mobile'];

    if(isset($_POST['user_update']))
    {
        $update_id=$user_id;
        $username=$_POST['user_username'];
        $user_email=$_POST['user_email'];
        $user_address=$_POST['user_address'];
        $user_mobile=$_POST['user_mobile'];
        $user_image=$_FILES['user_image']['name'];
        $user_image_tmp=$_FILES['user_image']['tmp_name'];
        move_uploaded_file($user_image_tmp,"./user_images/$user_image");
        //update query
        $update_data="update `user_table` set username='$username',user_email='$user_email',
        user_image='$user_image',user_address='$user_address',user_mobile='$user_mobile' where user_id=$update_id";
        $result_query_update=mysqli_query($con,$update_data);
        if($result_query_update)
        {
            echo "<script>alert('Data Updated Successfully...')</script>";
            echo "<script>window.open('logout.php','_self')</script>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <style>
        .error {
            color: red;
            font-size: 0.875em;
        }
    </style>
</head>
<body>
    <h3 class="text-center text-success">Edit Account</h3>
    <form id="editAccountForm" action="" method="POST" enctype="multipart/form-data">
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" value="<?php echo $username ?>" name="user_username" id="user_username">
            <span id="username_error" class="error"></span>
        </div>
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" value="<?php echo $user_email ?>" name="user_email" id="user_email">
            <span id="email_error" class="error"></span>
        </div>
        <div class="form-outline mb-4 d-flex w-50 m-auto">
            <input type="file" class="form-control" name="user_image" id="user_image">
            <img src="./user_images/<?php echo $user_image?>" alt="" class="edit_img">
            <span id="image_error" class="error"></span>
        </div>
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" value="<?php echo $user_address ?>" name="user_address" id="user_address">
            <span id="address_error" class="error"></span>
        </div>
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" value="<?php echo $user_mobile ?>" name="user_mobile" id="user_mobile">
            <span id="mobile_error" class="error"></span>
        </div>
        <input type="submit" value="Update" class="btn btn-primary py-2 px-3 border-0" name="user_update">
    </form>

    <script>
        document.getElementById('editAccountForm').addEventListener('submit', function(event) {
            let valid = true;

            // Clear previous error messages
            document.querySelectorAll('.error').forEach(function(element) {
                element.textContent = '';
            });

            // Username validation
            const username = document.getElementById('user_username').value;
            if (username.trim() === '') {
                document.getElementById('username_error').textContent = 'Username is required.';
                valid = false;
            }

            // Email validation
            const email = document.getElementById('user_email').value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('email_error').textContent = 'Please enter a valid email address.';
                valid = false;
            }

            // Image validation
            const imageInput = document.getElementById('user_image');
            const imageFile = imageInput.files[0];
            if (imageFile) {
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validImageTypes.includes(imageFile.type)) {
                    document.getElementById('image_error').textContent = 'Please upload a valid image file (JPEG, PNG, GIF).';
                    valid = false;
                }
            }

            // Address validation
            const address = document.getElementById('user_address').value;
            if (address.trim() === '') {
                document.getElementById('address_error').textContent = 'Address is required.';
                valid = false;
            }

            // Mobile validation
            const mobile = document.getElementById('user_mobile').value;
            const mobilePattern = /^[0-9]{10}$/; // Assumes 10-digit mobile numbers
            if (!mobilePattern.test(mobile)) {
                document.getElementById('mobile_error').textContent = 'Please enter a valid mobile number (10 digits).';
                valid = false;
            }

            if (!valid) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    </script>
</body>
</html>
