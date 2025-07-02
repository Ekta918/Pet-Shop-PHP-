<!-- Bootstrap CSS link -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- Bootstrap JS link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<h3 class="text-center text-success">All Users</h3>
<table class="table table-bordered mt-5">
    <thead class="text-center">
        <tr>
            <th>Sl No.</th>
            <th>Username</th>
            <th>User email</th>
            <th>User image</th>
            <th>User address</th>
            <th>User mobile</th>
            <th>Status</th>
            <th>View</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody class='text-center'>
        <?php
        // Fetch users from the database
        $get_users = "SELECT * FROM user_table";
        $result = mysqli_query($con, $get_users);

        $number = 0;
        while ($row_data = mysqli_fetch_assoc($result)) {
            $user_id = $row_data['user_id'];
            $username = $row_data['username'];
            // Other fields...

            $number++;
            echo "<tr>
                <td>$number</td>
                <td>$username</td>
                <td>{$row_data['user_email']}</td>
                <td><img src='../users_area/user_images/{$row_data['user_image']}' alt='{$row_data['user_image']}' class='product_img'/></td>
                <td>{$row_data['user_address']}</td>
                <td>{$row_data['user_mobile']}</td>
                <td>{$row_data['status']}</td>
                <td>
                    <a href='index.php?view_user=$user_id' class='btn btn-primary text-light'>
                        <i class='fas fa-eye'></i>
                    </a>
                </td>
                <td>
                    <a href='' class='btn btn-danger text-light' data-toggle='modal' data-target='#exampleModal'>
                        <i class='fa-solid fa-trash-can'></i>
                    </a>
                </td>
            </tr>";
        }
        ?>
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h4>Are you sure you want to delete this??</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <a href="./index.php?list_users" class="text-light text-decoration-none">No</a></button>
        <button type="button" class="btn btn-primary"><a href='index.php?delete_user=<?php echo $user_id ?>'
         class='text-light text-decoration-none'>Yes</a></button>
      </div>
    </div>
  </div>
</div>
