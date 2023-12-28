<?php

include('partials/menu.php');

?>

    <!-- Main Section Starts Here -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Add Food</h1>
            <br /> <br />
            <?php
                if(isset($_SESSION['food'])){
                    echo $_SESSION['food'];
                    unset($_SESSION['food']);
                }
                if(isset($_SESSION['food-upload'])){
                     echo $_SESSION['food-upload'];
                     unset($_SESSION['food-upload']);
                }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td><input type="text" name="title" placeholder="Enter your title"></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea name="description" cols="30" rows="5" placeholder="Description of the food."></textarea></td>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td><input type="number" name="price"></td>
                    </tr>
                    <tr>
                        <td>Upload Image:</td>
                        <td><input type="file" name="image"></td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td>
                            <select name="category">
                                <?php
                                    $sql = "SELECT * FROM tbl_category WHERE active='yes'";
                                    $res = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($res);
                                    if($count>0){
                                        while($row=mysqli_fetch_assoc($res)){
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            ?>
                                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="0">No Category Found</option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </td>
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
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
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
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
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
                    $image_name = "Food_Name_".rand(000, 999).'.'.$text;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/food/".$image_name;
                    $upload = move_uploaded_file($source_path, $destination_path);
                    if($upload == false){
                        $_SESSION["food-upload"] = "<div class='error'>Failed to upload image.</div>";
                        header("location:".SITEURL.'admin/add-food.php');
                        die();
                    }
                }
            } else {
                $image_name="";
            }

            $sql = "INSERT INTO tbl_food SET title='$title',price='$price',description='$description',category_id='$category',image_name='$image_name',featured='$featured',active='$active'";
            $res = mysqli_query($conn, $sql) or die(mysqli_error());

            if($res == TRUE){
                $_SESSION['food'] = "<div class='success'>Food added successfully!</div>";
                header("location:".SITEURL.'admin/manage-food.php');
            } else {
                $_SESSION['food'] = "<div class='error'>Failed to add food.</div>";
                header("location:".SITEURL.'admin/add-food.php');
            }
        }
    ?>