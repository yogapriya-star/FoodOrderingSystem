<?php
    include('../config/constant.php');
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "DELETE FROM tbl_order WHERE id=$id";
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        if($res == TRUE){
            $_SESSION['delete'] = "<div class='success'>Order deleted successfully!</div>";
            header("location:".SITEURL.'admin/manage-order.php');
        } else {
            $_SESSION['delete'] = "<div class='error'>Failed to delete order.</div>";
            header("location:".SITEURL.'admin/manage-order.php');
        }
    }else{
         header("location:".SITEURL.'admin/manage-order.php');
    }
?>