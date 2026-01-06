<?php
session_start();
include_once('includes/dbconnection.php');
?>
<head>
    <title>Shahi Punjabi Restaurant | Registration</title>
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
</head>
 
<?php include_once('header.php'); ?>

<body itemscope>
    <section>
        <div class="block">
            <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
            <div class="page-title-wrapper text-center">
                <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="page-title-inner">
                        <h1 itemprop="headline">Registration</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="bread-crumbs-wrapper">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
                <li class="breadcrumb-item">Registration</li>
            </ol>
        </div>
    </div>

    <section>
        <div class="block top-padd30">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="login-register-wrapper">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-lg-12">
                                    <div class="sign-popup-wrapper brd-rd5">
                                        <div class="sign-popup-inner brd-rd5">
                                            <div class="sign-popup-title text-center">
                                                <h4 itemprop="headline">Registration</h4>
                                            </div>
                                            <form class="sign-form" id="signupForm" name="signup" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-lg-6">
                                                        <input class="brd-rd3" type="text" id="firstname" name="firstname" placeholder="First Name">
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-lg-6">
                                                        <input class="brd-rd3" type="text" id="lastname" name="lastname" placeholder="Last Name">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        <input class="brd-rd3" type="email" id="email" name="email" placeholder="Email id">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        <input class="brd-rd3" id="mobilenumber" name="mobilenumber" maxlength="10" pattern="[0-9]{10}" title="Mobile must contain 10 digits only" placeholder="Mobile Number">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        <input class="brd-rd3" type="password" id="password" name="password" placeholder="Password">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        <input class="brd-rd3" type="password" id="repeatpassword" name="repeatpassword" placeholder="Confirm Password">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        <input class="brd-rd3" type="file" id="profile" name="profile" accept="image/*">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        <button class="red-bg brd-rd3" type="submit" name="submit">REGISTER NOW</button>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                        Already Registered? <a class="sign-btn" href="login.php" style="font-size:13px; color:black;" itemprop="url"> Sign in</a>
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

<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $contno = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile = uniqid(). $_FILES['profile']['name'];
    $profile_temp = $_FILES['profile']['tmp_name'];

    $token = uniqid() . time();

    $insert = "INSERT INTO tbluser (FirstName, LastName, MobileNumber, Email, Password, profile, status, token) VALUES ('$fname', '$lname', '$contno', '$email', '$password', '$profile','Inactive','$token')";

    if ($con->query($insert)) 
    {
        if (!file_exists('assets/images/profile')) 
        {
            mkdir('assets/images/profile');
        }
        move_uploaded_file($profile_temp, 'assets/images/profile/' . $profile);

        $link = 'http://localhost/food1/verify_email.php?email=' . $email . '&token=' . $token;
        $body = "<div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px;'>
                    <h2 style='color: #0C3B2E; text-align: center;'>Account Verification</h2>
                    <p style='text-align: center;'>Click on the button below to verify your account</p>
                    <a href='" . $link . "' style='display: block; width: 200px; margin: 0 auto; text-align: center; background-color: #0C3B2E; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Verify Account</a>
                </div>";
        $subject = "Account Verification Mail";

        if (sendEmail($email, $subject, $body, "")) {
            ?>
                <script>alert("Registration Successfull. Account verification link has been sent to your email. Verify your email to login.");</script>
            <?php
            // setcookie('success', 'Registration Successfull. Account verification link has been sent to your email. Verify your email to login.', time() + 5);
        } else {
            ?>
                <script>alert("Failed to send the registration link");</script>
            <?php
            // setcookie('error', 'Failed to send the registration link', time() + 5);
        }
    } else {
            ?>
                <script>alert("Registration Failed");</script>
            <?php
        // setcookie('error', 'Registration Failed', time() + 5);
    }
}
?>
<script>
$(document).ready(function() {
    $("#signupForm").validate({
        rules: {
            firstname: "required",
            lastname: "required",
            email: {
                required: true,
                email: true
            },
            mobilenumber: {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true
            },
            password: {
                required: true,
                minlength: 6
            },
            repeatpassword: {
                required: true,
                equalTo: "#password"
            },
            profile: "required"
        },
        messages: {
            repeatpassword: "Passwords do not match"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>
<?php include_once('footer.php'); ?>

</body>
</html>
