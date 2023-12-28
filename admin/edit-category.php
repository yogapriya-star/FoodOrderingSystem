<?php include('partials/menu.php') ?>

    <!-- Main Section Starts Here -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Edit Category</h1>
            <br /> <br />
            <?php
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>

            <?php
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_category WHERE id=$id";
                $res = mysqli_query($conn, $sql);

                if($res == TRUE){
                    $count = mysqli_num_rows($res);

                    if($count==1){
                         $row = mysqli_fetch_assoc($res);
                         $id = $row['id'];
                         $title = $row['title'];
                         $current_image = $row['image_name'];
                         $featured = $row['featured'];
                         $active = $row['active'];
                    } else {
                       header("location:".SITEURL.'admin/manage-category.php');
                    }
                }
            ?>
            <form action="" method="POST"  enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                    </tr>
                    <tr>
                        <td>Current Image:</td>
                        <td>
                            <?php
                                if($current_image != ""){
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px" >
                                <?php
                                } else {
                                    echo "<div class='error'>Image not added.</div>";
                                }
                            ?>
                        </td>
                    </tr>
                   <tr>
                       <td>New Image:</td>
                       <td><input type="file" name="image"></td>
                   </tr>
                    <tr>
                        <td>Feature:</td>
                        <td>
                            <input  type="radio" name="featured" value="yes" <?php echo ($featured == "yes") ? "checked" : ""; ?>  >Yes
                            <input type="radio" name="featured" value="no" <?php echo ($featured == "no") ? "checked" : ""; ?>  >No
                        </td>
                    </tr>
                     <tr>
                        <td>Active:</td>
                        <td>
                            <input  type="radio" name="active" value="yes" <?php echo ($active == "yes") ? "checked" : ""; ?> >Yes
                            <input type="radio" name="active" value="no" <?php echo ($active == "no") ? "checked" : ""; ?> >No
                        </td>
                     </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Category" class="btn-secondary">
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
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

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
                        header("location:".SITEURL.'admin/manage-category.php');
                        die();
                    }
                    if($current_image!=""){
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);
                        if($remove==false){
                             $_SESSION["failed-remove"] = "<div class='error'>Failed to remove current image.</div>";
                             header("location:".SITEURL.'admin/manage-category.php');
                             die();
                        }
                    }

                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }

            $sql = "UPDATE tbl_category SET title='$title',featured='$featured',active='$active',image_name='$image_name' WHERE id='$id'";
            $res = mysqli_query($conn, $sql) or die(mysqli_error());

            if($res == TRUE){
                $_SESSION['update'] = "<div class='success'>Category updated successfully!</div>";
                header("location:".SITEURL.'admin/manage-category.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to update the category.</div>";
                header("location:".SITEURL.'admin/edit-category.php');
            }
        }
   ?>