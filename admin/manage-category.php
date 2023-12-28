<?php include('partials/menu.php') ?>

    <!-- Main Section Starts Here -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Category</h1>
            <br />
            <?php
                if(isset($_SESSION['category'])){
                    echo $_SESSION['category'];
                    unset($_SESSION['category']);
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
            <a href="add-category.php" class="btn-primary">Add Category</a>
            <br /> <br />
            <table class="tbl-full">
                <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
                <?php
                    $sql = "SELECT * FROM tbl_category";
                    $res = mysqli_query($conn, $sql);

                    if($res == TRUE){
                        $count = mysqli_num_rows($res);
                        $sn=1;
                        if($count>0){
                            while($rows=mysqli_fetch_assoc($res)){
                                $id = $rows['id'];
                                $title = $rows['title'];
                                $image = $rows['image_name'];
                                $featured = $rows['featured'];
                                $active = $rows['active'];
                ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $title; ?></td>
                    <td>
                        <?php
                            if($image != ""){
                            ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image; ?>" width="100px" >
                            <?php
                            } else {
                                echo "<div class='error'>Image not added.</div>";
                            }
                        ?>
                    </td>
                    <td><?php echo $featured; ?></td>
                    <td><?php echo $active; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/edit-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image; ?>" class="btn-danger">Delete Category</a>
                    </td>
                </tr>
                <?php
                            }
                        } else{
                            ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="error">
                                            No category found.
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

   <?php

   include('partials/footer.php');

    ?>