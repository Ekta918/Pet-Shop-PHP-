<?php

if(isset($_GET['delete_user']))
{
    $delete_id=$_GET['delete_user'];
    //delete query

    $delete_user="Delete from `user_table` where user_id=$delete_id";
    $result_user=mysqli_query($con,$delete_user);
    if($result_user)
    {
        echo "<script>alert('user deleted successfully...')</script>";
        echo "<script>window.open('./index.php?list_user','_self')</script>";
    }
}

?>