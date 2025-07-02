<?php
if(isset($_GET['delete_brand']))
{
    $delete_cat=$_GET['delete_brand'];
    $delete_query="Delete from `brands` where brand_id=$delete_cat";
    $result=mysqli_query($con,$delete_query);
    if($result)
    {
        echo "<script>alert('brand deleted successfully...')</script>";
        echo "<script>window.open('./index.php?insert_brand','_self')</script>";
    }
}
?>