<?php include('partials/menu.php') ?>

    <!-- Main Section Starts Here -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Edit Food</h1>
            <br /> <br />
            <?php
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>

            <?php
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_food WHERE id=$id";

                $res = mysqli_query($conn, $sql);

                if($res == TRUE){
                    $count = mysqli_num_rows($res);

                    if($count==1){
                         $row2 = mysqli_fetch_assoc($res);
                         $id = $row2['id'];
                         $title = $row2['title'];
                         $description = $row2['description'];
                         $price = $row2['price'];
                         $current_image = $row2['image_name'];
                         $current_category = $row2['category_id'];
                         $featured = $row2['featured'];
                         $active = $row2['active'];
                    } else {
                       header("location:".SITEURL.'admin/manage-food.php');
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
                        <td>Description:</td>
                        <td><textarea name="description" rows="5" cols="30"><?php echo $description; ?></textarea>
                    </td>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                    </tr>
                    <tr>
                        <td>Current Image:</td>
                        <td>
                            <?php
                                if($current_image != ""){
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px" >
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
                       <td>Category:</td>
                       <td>
                           <select name="category_id">
                              <?php
                              $sql = "SELECT * FROM tbl_category WHERE active='yes'";
                              $res = mysqli_query($conn, $sql);
                              $count = mysqli_num_rows($res);

                              if ($count > 0) {
                                  while ($row = mysqli_fetch_assoc($res)) {
                                      $category_title = $row['title'];
                                      $category_id = $row['id'];
                                      $selected = ($current_category == $category_id) ? 'selected' : '';
                                      echo "<option value=\"$category_id\" $selected>$category_title</option>";
                                  }
                              }
                              ?>
                           </select>
                       </td>
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
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                           <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!-- Main Section Ends Here -->


<?php
        if(isset($_POST['submit'])){
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category_id = $_POST['category_id'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            if(isset($_FILES['image']['name'])){
                $image_name = $_FILES['image']['name'];
                if($image_name != ""){
                    $text = end(explode('.', $image_name));
                    $image_name = "Food_Name_".rand(000, 999).'.'.$text;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/food/".$image_name;
                    $upload = move_uploaded_file($source_path, $destination_path);
                    if($upload == false){
                        $_SESSION["upload"] = "<div class='error'>Failed to upload image.</div>";
                        header("location:".SITEURL.'admin/manage-food.php');
                        die();
                    }
                    if($current_image!=""){
                        $remove_path = "../images/food/".$current_image;
                        $remove = unlink($remove_path);
                        if($remove==false){
                             $_SESSION["failed-remove"] = "<div class='error'>Failed to remove current image.</div>";
                             header("location:".SITEURL.'admin/manage-food.php');
                             die();
                        }
                    }

                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }

            $sql = "UPDATE tbl_food SET title='$title',price='$price',description='$description',category_id='$category_id',featured='$featured',active='$active',image_name='$image_name' WHERE id='$id'";
            $result = mysqli_query($conn, $sql) or die(mysqli_error());

            if($result == TRUE){
               $_SESSION['update'] = "<div class='success'>Food edited successfully!</div>";
               header("location:".SITEURL.'admin/manage-food.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to update the food.</div>";
                header("location:".SITEURL.'admin/edit-food.php');
            }
        }
   ?>

   <?php include('partials/footer.php') ?>