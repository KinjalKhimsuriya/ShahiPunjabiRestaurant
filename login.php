<?php
session_start();
include_once('includes/dbconnection.php');
?>

<head>
    <title>Shahi Punjabi Restaurant</title>
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
</head>
 
<?php include_once('header.php');?>

<body itemscope>

        <section>
            <div class="block">
                <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
                <div class="page-title-wrapper text-center">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="page-title-inner">
                            <h1 itemprop="headline">Login </h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <div class="bread-crumbs-wrapper">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
                <li class="breadcrumb-item">Login</li>
            </ol>
        </div>
    </div>

    <section>
        <div class="block top-padd30">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="login-register-wrapper">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-lg-12">
                                    <div class="sign-popup-wrapper brd-rd5">
                                        <div class="sign-popup-inner brd-rd5">
                                            <div class="sign-popup-title text-center">
                                                <h4 itemprop="headline">Login</h4>
                                            </div>
                                            <form class="sign-form" id="loginForm" method="post">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        <input class="brd-rd3" name="emailcont" id="email" placeholder="Email">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        <input class="brd-rd3" type="password" id="password" name="password" placeholder="Password">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        <button class="red-bg brd-rd3" type="submit" name="login" id="submitBtn">SIGN IN</button>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        Not Registered yet? <a href="register.php" title="Register" itemprop="url" style="font-size:13px; color:black;"> Sign up</a>
                                                        <a class="recover-btn" style="font-size:13px; color:black;" href="forgot-password.php" title="" itemprop="url">Forget password ?</a>
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

    <?php include_once('footer.php');  ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {
            // Apply validation on login form
            $("#loginForm").validate({
                rules: {
                    emailcont: {
                        required: true,
                        email: true // Validate email format
                    },
                    password: {
                        required: true,
                        minlength: 6 // Password must be at least 6 characters long
                    }
                },
                messages: {
                    emailcont: {
                        required: "Please enter your email.",
                        email: "Please enter a valid email address."
                    },
                    password: {
                        required: "Please enter your password.",
                        minlength: "Your password must be at least 6 characters long."
                    }
                },
                 errorElement: "div",
                errorPlacement: function (error, element) {
                    error.addClass("text-danger mt-1");
                    error.insertAfter(element);
                },
                submitHandler: function (form) {
                    form.submit(); // Submit form if validation passes
                }
                });
        });
    </script>
</body>
<?php
if(isset($_POST['login']))
  {
    $emailcon=$_POST['emailcont'];
    $password=$_POST['password'];
    $query=mysqli_query($con,"select ID,Email from tbluser where (Email='$emailcon' || MobileNumber='$emailcon') && Password='$password' ");
    $ret=mysqli_fetch_array($query);
    if($ret>0){
        $_SESSION['fosuid']=$ret['ID'];
        $_SESSION['fname']=$ret['FirstName'];
        $_SESSION['uemail']=$ret['Email'];
      echo "<script>window.location.href='index.php'</script>";
    }
    else{
        echo "<script>alert('Invalid details');</script>";
    }
  }
  ?>
</html>
