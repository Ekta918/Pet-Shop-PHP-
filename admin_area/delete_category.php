<?php
if(isset($_GET['delete_category']))
{
    $delete_cat=$_GET['delete_category'];
    $delete_query="Delete from `categories` where category_id=$delete_cat";
    $result=mysqli_query($con,$delete_query);
    if($result)
    {
        echo "<script>alert('Category deleted successfully...')</script>";
        echo "<script>window.open('./index.php?insert_category','_self')</script>";
    }
}
?>