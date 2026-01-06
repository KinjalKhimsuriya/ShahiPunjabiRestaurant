<?php
session_start();
include_once('includes/dbconnection.php');
if(isset($_POST['submit'])) {
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];

    if(empty($newpassword) || empty($confirmpassword)) {
        setcookie("error", "Both fields are required!", time() + 5, "/");

    } elseif(strlen($newpassword) < 6) {
        setcookie("error", "Password must be at least 6 characters long.", time() + 5, "/");

    } elseif($newpassword != $confirmpassword) {
        setcookie("error", "Passwords does not match!", time() + 5, "/");

    } else {
        $email = $_SESSION['forgot_email']; 
        $update_query = "UPDATE tbluser SET Password = '$newpassword' WHERE Email = '$email'";
        
        if(mysqli_query($con, $update_query)) {
            $delete_query = "DELETE FROM password_token WHERE email = '$email'";
            mysqli_query($con, $delete_query);
            setcookie("success", "Password reset successfully!", time() + 5, "/");
            unset($_SESSION['forgot_email']);
            ?>
            <script>
                    window.location.href = "login.php";  // Redirect to the login page
                </script>
            <?php
        } else {
            setcookie("error", "Failed to update password. Please try again.", time() + 5, "/");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shahi Punjabi Restaurant | Reset Password</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<?php include_once('header.php'); ?>

<section>
    <div class="block">
        <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
        <div class="page-title-wrapper text-center">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="page-title-inner">
                    <h1 itemprop="headline">Reset Password</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="bread-crumbs-wrapper">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
            <li class="breadcrumb-item">Reset your Password</li>
        </ol>
    </div>
</div>

<section>
    <div class="block top-padd30">
        <div class="container">
            <div class="row">
            <?php if(isset($_COOKIE['success'])) { ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo $_COOKIE['success']; ?>
                </div>
                <?php setcookie("error", "", time() - 3600, "/"); } ?>

                <?php if(isset($_COOKIE['error'])) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo $_COOKIE['error']; ?>
                </div>
                <?php setcookie("error", "", time() - 3600, "/"); } ?>
                <div class="col-md-6 col-md-offset-3">
                    <div class="login-register-wrapper">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="sign-popup-wrapper brd-rd5">
                                    <div class="sign-popup-inner brd-rd5">
                                        <div class="sign-popup-title text-center">
                                            <h4 itemprop="headline">Recover your Password</h4>
                                        </div>
                                        <form class="sign-form" id="resetPasswordForm" method="post">
                                            <div class="row">
                                                <!-- New Password -->
                                                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                    <input class="brd-rd3" type="password" name="newpassword" id="newpassword" placeholder="New Password" minlength="6">
                                                </div>
                                                <!-- Confirm Password -->
                                                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                    <input class="brd-rd3" type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Your Password" equalTo="#newpassword">
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                    <button class="red-bg brd-rd3" type="submit" name="submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once('footer.php'); ?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        // Initialize form validation using jQuery Validation plugin
        $("#resetPasswordForm").validate({
            rules: {
                newpassword: {
                    required: true,
                    minlength: 6
                },
                confirmpassword: {
                    required: true,
                    equalTo: "#newpassword"
                }
            },
            messages: {
                newpassword: {
                    required: "Please enter a new password.",
                    minlength: "Password must be at least 6 characters long."
                },
                confirmpassword: {
                    required: "Please confirm your new password.",
                    equalTo: "Passwords do not match."
                }
            },
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.addClass("error");
                error.insertAfter(element);
            },
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });
    });
</script>

</body>
</html>
