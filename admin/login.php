<?php include('../config/constant.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order Website - Login Page</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <!-- Menu Section Starts Here -->
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br />
        <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-message'])){
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        <br />
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter password"></td>
                </tr>
                <tr class="text-center">
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Login" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- Menu Section Ends Here -->

<?php include('partials/footer.php') ?>
<?php
        if(isset($_POST['submit'])){
            $username =  mysqli_real_escape_string($conn, $_POST['username']);
            $password =  mysqli_real_escape_string($conn, md5($_POST['password']));

            $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";


            $res = mysqli_query($conn, $sql) or die(mysqli_error());

            $count = mysqli_num_rows($res);

            if($count == 1){
                $_SESSION['login'] = "<div class='success'>Login successfully!</div>";
                $_SESSION['user'] = $username;
                header("location:".SITEURL.'admin/');
            } else {
                $_SESSION['login'] = "<div class='error'>Username or password not match.</div>";
                header("location:".SITEURL.'admin/login.php');
            }
        }
   ?>