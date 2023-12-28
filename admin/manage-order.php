<?php include('partials/menu.php') ?>

    <!-- Main Section Starts Here -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Order</h1>
            <br />
            <?php
                 if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                 }

                 if(isset($_SESSION['update'])){
                     echo $_SESSION['update'];
                     unset($_SESSION['update']);
                 }
            ?>
            <br /> <br /> <br />
            <table class="tbl-full">
                <tr>
                    <th>S.No.</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                 <?php
                     $sql = "SELECT * FROM tbl_order";
                     $res = mysqli_query($conn, $sql);

                     if($res == TRUE){
                         $count = mysqli_num_rows($res);
                         $sn=1;
                         if($count>0){
                             while($rows=mysqli_fetch_assoc($res)){
                                 $id = $rows['id'];
                                 $food = $rows['food'];
                                 $price = $rows['price'];
                                 $qty = $rows['qty'];
                                 $total = $rows['total'];
                                 $order_date = $rows['order_date'];
                                 $status = $rows['status'];
                                 $customer_name = $rows['customer_name'];
                                 $customer_contact = $rows['customer_contact'];
                                 $customer_email = $rows['customer_email'];
                                 $customer_address = $rows['customer_address'];
                  ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $food; ?></td>
                    <td><?php echo $price; ?></td>
                    <td><?php echo $qty; ?></td>
                    <td><?php echo $total; ?></td>
                    <td>
                        <?php
                            if($status == "Ordered"){
                                echo "<span>$status</span>";
                            } elseif ($status == "On Delivery"){
                                echo "<span  style='color: orange;'>$status</span>";
                            } elseif ($status == "Delivered"){
                                echo "<span style='color: green;'>$status</span>";
                            } elseif ($status == "Cancelled"){
                                echo "<span style='color: red;'>$status</span>";
                            }

                        ?>
                    </td>
                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $customer_email; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/edit-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-order.php?id=<?php echo $id; ?>" class="btn-danger">Delete Order</a>
                    </td>
                </tr>
                <?php
                            }
                        } else{
                            ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="error">
                                            Order not added yet.
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