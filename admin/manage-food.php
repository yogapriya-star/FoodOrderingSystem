<?php include('partials/menu.php') ?>

    <!-- Main Section Starts Here -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Food</h1>
            <br />
            <?php
                if(isset($_SESSION['food'])){
                    echo $_SESSION['food'];
                    unset($_SESSION['food']);
                }
                 if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                 }
                 if(isset($_SESSION['remove'])){
                    echo $_SESSION['remove'];
                    unset($_SESSION['remove']);
                 }
                 if(isset($_SESSION['update'])){
                     echo $_SESSION['update'];
                     unset($_SESSION['update']);
                 }
                 if(isset($_SESSION['upload'])){
                     echo $_SESSION['upload'];
                     unset($_SESSION['upload']);
                 }
                 if(isset($_SESSION['failed-remove'])){
                     echo $_SESSION['failed-remove'];
                     unset($_SESSION['failed-remove']);
                 }
            ?>
            <br /> <br /> <br />
            <a href="add-food.php" class="btn-primary">Add Food</a>
            <br /> <br />
            <table class="tbl-full">
                 <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Action</th>
                 </tr>
                  <?php
                     $sql = "SELECT * FROM tbl_food";
                     $res = mysqli_query($conn, $sql);

                     if($res == TRUE){
                         $count = mysqli_num_rows($res);
                         $sn=1;
                         if($count>0){
                             while($rows=mysqli_fetch_assoc($res)){
                                 $id = $rows['id'];
                                 $title = $rows['title'];
                                 $description = $rows['description'];
                                 $price = $rows['price'];
                                 $image = $rows['image_name'];
                                 $featured = $rows['featured'];
                                 $active = $rows['active'];
                  ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $title; ?></td>
                    <td><?php echo $description; ?></td>
                    <td><?php echo $price; ?></td>
                    <td>
                        <?php
                            if($image != ""){
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image; ?>" width="100px" >
                            <?php
                            } else {
                                echo "<div class='error'>Image not added.</div>";
                            }
                        ?>
                    </td>
                    <td><?php echo $featured; ?></td>
                    <td><?php echo $active; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/edit-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image; ?>" class="btn-danger">Delete Food</a>
                    </td>
                </tr>
                <?php
                            }
                        } else{
                            ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="error">
                                            Food not added yet.
                                        </div>
                                    </td>
                                </tr>
                            <?php
                        }
                    }
                ?>
            </table>
        </div>
    </div>
    <!-- Main Section Ends Here -->

   <?php include('partials/footer.php') ?>