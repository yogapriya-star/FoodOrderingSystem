<?php

include('partials/menu.php');

?>

    <!-- Main Section Starts Here -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Add Category</h1>
            <br /> <br />
            <?php
                if(isset($_SESSION['category'])){
                    echo $_SESSION['category'];
                    unset($_SESSION['category']);
                }
                if(isset($_SESSION['upload'])){
                     echo $_SESSION['upload'];
                     unset($_SESSION['upload']);
                }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td><input type="text" name="title" placeholder="Enter your title"></td>
                    </tr>
                    <tr>
                        <td>Upload Image:</td>
                        <td><input type="file" name="image"></td>
                    </tr>
                    <tr>
                        <td>Feature:</td>
                        <td>
                            <input type="radio" name="featured" value="yes">Yes
                            <input type="radio" name="featured" value="no">No
                        </td>
                    </tr>
                     <tr>
                        <td>Active:</td>
                        <td>
                            <input type="radio" name="active" value="yes">Yes
                            <input type="radio" name="active" value="no">No
                        </td>
                     </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Create Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!-- Main Section Ends Here -->

   <?php include('partials/footer.php') ?>
   <?php
        if(isset($_POST['submit'])){
            $title = $_POST['title'];
            if(isset($_POST['featured'])){
                $featured = $_POST['featured'];
            } else {
                $featured = "No";
            }

            if(isset($_POST['active'])){
                $active = $_POST['active'];
            } else {
                $active = "No";
            }

            if(isset($_FILES['image']['name'])){
                $image_name = $_FILES['image']['name'];
                if($image_name != ""){
                    $text = end(explode('.', $image_name));
                    $image_name = "Food_Category_".rand(000, 999).'.'.$text;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;
                    $upload = move_uploaded_file($source_path, $destination_path);
                    if($upload == false){
                        $_SESSION["upload"] = "<div class='error'>Failed to upload image.</div>";
                        header("location:".SITEURL.'admin/add-category.php');
                        die();
                    }
                }
            } else {
                $image_name="";
            }

            $sql = "INSERT INTO tbl_category SET title='$title',image_name='$image_name',featured='$featured',active='$active'";
            $res = mysqli_query($conn, $sql) or die(mysqli_error());

            if($res == TRUE){
                $_SESSION['category'] = "<div class='success'>Category created successfully!</div>";
                header("location:".SITEURL.'admin/manage-category.php');
            } else {
                $_SESSION['category'] = "<div class='error'>Failed to create category.</div>";
                header("location:".SITEURL.'admin/add-category.php');
            }
        }
   ?>