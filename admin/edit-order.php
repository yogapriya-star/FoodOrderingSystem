<?php include('partials/menu.php') ?>

    <!-- Main Section Starts Here -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Edit Order</h1>
            <br /> <br />
            <?php
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>

            <?php
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_order WHERE id=$id";

                $res = mysqli_query($conn, $sql);

                if($res == TRUE){
                    $count = mysqli_num_rows($res);

                    if($count==1){
                         $row2 = mysqli_fetch_assoc($res);
                         $id = $row2['id'];
                         $food = $row2['food'];
                         $price = $row2['price'];
                         $qty = $row2['qty'];
                         $total = $row2['total'];
                         $order_date = $row2['order_date'];
                         $status = $row2['status'];
                         $customer_name = $row2['customer_name'];
                         $customer_contact = $row2['customer_contact'];
                         $customer_email = $row2['customer_email'];
                         $customer_address = $row2['customer_address'];
                    } else {
                       header("location:".SITEURL.'admin/manage-order.php');
                    }
                }
            ?>
            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Food:</td>
                        <td><b><?php echo $food; ?></b>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td><b><?php echo $price; ?></b>
                    </tr>
                    <tr>
                        <td>Quantity:</td>
                        <td><input type="number" name="qty" value="<?php echo $qty; ?>"></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <select name="status">
                                <option <?php if($status == "Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                                <option <?php if($status == "On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                                <option <?php if($status == "Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                                <option <?php if($status == "Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Customer Name:</td>
                        <td><input type="text" name="customer_name" value="<?php echo $customer_name; ?>"></td>
                    </tr>
                    <tr>
                        <td>Contact Number:</td>
                        <td><input type="number" name="customer_contact" value="<?php echo $customer_contact; ?>"></td>
                    </tr>
                    <tr>
                        <td>Customer Email:</td>
                        <td><input type="email" name="customer_email" value="<?php echo $customer_email; ?>"></td>
                    </tr>
                     <tr>
                         <td>Customer Address:</td>
                         <td><textarea name="customer_address" rows="5" cols="30"><?php echo $customer_address; ?></textarea>
                     </td>
                     </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="price" value="<?php echo $price; ?>">
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
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty;
            $status = $_POST['status'];
            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];

            $sql2 = "UPDATE tbl_order SET qty='$qty',total='$total',status='$status',customer_name='$customer_name',customer_contact='$customer_contact',customer_email='$customer_email',customer_address='$customer_address' WHERE id='$id'";
            $result = mysqli_query($conn, $sql2) or die(mysqli_error());

            if($result == TRUE){
               $_SESSION['update'] = "<div class='success'>Order edited successfully!</div>";
               header("location:".SITEURL.'admin/manage-order.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to update the food.</div>";
                header("location:".SITEURL.'admin/edit-order.php');
            }
        }
   ?>

   <?php include('partials/footer.php') ?>