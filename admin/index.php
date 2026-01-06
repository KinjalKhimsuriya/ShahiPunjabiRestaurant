<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $adminuser = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($con, "select ID from tbladmin where  UserName='$adminuser' && Password='$password' ");
    $ret = mysqli_fetch_array($query);
    if ($ret > 0) {
        $_SESSION['fosaid'] = $ret['ID'];
        $_SESSION['adminuser']=$adminuser;
        header('location:dashboard.php');
    } else {
        setcookie("error", "Invalid Details", time() + 5, "/");
       ?>
         <script>
                window.location.href = "index.php";
            </script>
       <?php 
    }
}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Add jQuery and jQuery Validate -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // Add jQuery Validation
            $("form[name='login']").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 3
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    username: {
                        required: "Please enter your username",
                        minlength: "Username must be at least 3 characters long"
                    },
                    password: {
                        required: "Please enter your password",
                        minlength: "Password must be at least 6 characters long"
                    }
                },
                submitHandler: function (form) {
                    form.submit(); // submit the form if valid
                }
            });
        });
    </script>

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row justify-content-center">

            <div class="col-md-7">
                <h2 class="font-bold">Shahi Punjabi Restaurant | Admin Login</h2>
            </div>

            <div class="col-md-7">
                <div class="ibox-content">
                    <?php
                        if(isset($_COOKIE['error'])){
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo $_COOKIE['error']; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php
                        }
                    ?>
                <p style="font-size:16px; color:red" align="center"> <?php //if ($msg) {
                        //echo $msg; } ?> </p>
                    <form class="m-t" role="form" action="" method="post" name="login">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="username" name="username" >
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password"  name="password">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b" name="login">Login</button>

                        <!-- <a href="forgot-password.php">
                            <p>Forgot password?</p>
                        </a> -->
                    </form>
                </div>
            </div>
        </div>
        <hr />
    </div>

    <?php include_once('includes/footer.php'); ?>
</body>

</html>
