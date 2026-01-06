<?php
session_start();
include_once('includes/dbconnection.php');
include_once('header.php'); 
?>
<head>
    <title>Food Ordering System | Forget Password</title>
</head>

<section>
    <div class="block">
        <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
        <div class="page-title-wrapper text-center">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="page-title-inner">
                    <h1 itemprop="headline">Forgot Password</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="bread-crumbs-wrapper">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
            <li class="breadcrumb-item">Forgot Password </li>
        </ol>
    </div>
</div>

<section>
    <div class="block top-padd30">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <?php if (isset($_COOKIE['success'])) 
                    { ?>
                        <div class="alert alert-success alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= htmlspecialchars($_COOKIE['success']); ?>
                        </div>
                        <?php setcookie("success", "", time() - 3600, "/"); 
                    } ?>

                    <?php if (isset($_COOKIE['error']))
                    { ?>
                        <div class="alert alert-danger alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= htmlspecialchars($_COOKIE['error']); ?>
                        </div>
                        <?php setcookie("error", "", time() - 3600, "/");
                    } ?>

                    <div class="login-register-wrapper">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="sign-popup-wrapper brd-rd5">
                                    <div class="sign-popup-inner brd-rd5">
                                        <div class="sign-popup-title text-center">
                                            <h4 itemprop="headline">Forgot Password</h4><br>
                                            <p>Enter your email address and we'll send you instructions to reset your password.</p>
                                        </div>
                                        <form class="sign-form" method="post" id="passwordRecoveryForm">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                    <input class="brd-rd3" type="email"
                                                        placeholder="Registered Email id" name="email" id="email" >
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                    <button class="red-bg brd-rd3" type="submit"
                                                        name="submit">Submit</button>
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

</main>
<?php include_once('footer.php'); 
if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT * FROM tbluser WHERE email = '$email'";  // assuming 'users' is the table name
    $result = $con->query($query);
    
    if ($result->num_rows == 0) {
        // Email doesn't exist in the database
        // setcookie('error', 'The entered email does not exist. Please enter a valid email.', time() + 5);
        ?>
        <script>
            alert("The entered email does not exist. Please enter a valid email.");
            window.location.href = "forgot-password.php";  // Redirect to the forgot password page
        </script>
        <?php
    } else {
        // Email exists, proceed with OTP generation logic
        $otp = rand(100000, 999999);
        $body = "<html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; }
                    h1 { color: black; }
                    .otp { font-size: 24px; font-weight: bold; color: #0C3B2E; }
                    .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Forgot Your Password?</h1>
                    <p>We received a request to reset your password. Here is your One-Time Password (OTP):</p>
                    <p class='otp'>$otp</p>
                    <p>Please enter this OTP on the website to proceed with resetting your password.</p>
                    <p>If you did not request a password reset, please ignore this email.</p>
                    <div class='footer'>
                        <p>This is an automated message, please do not reply to this email.</p>
                    </div>
                </div>
            </body>
            </html>";

        $subject = "Password Reset - OTP";
        $email_time = date("Y-m-d H:i:s");
        $expiry_time = date("Y-m-d H:i:s", strtotime('+2 minutes'));
        
        $query = "SELECT * FROM password_token WHERE email = '$email'";
        $result = $con->query($query);
        $otp_attempts = 0;  // Default to 0 if no previous OTP attempts

        if ($result->num_rows > 0) {
            // If email already exists in password_token table, check OTP attempts
            $row = $result->fetch_assoc();
            $otp_attempts = $row['otp_attempts'];

            if ($otp_attempts >= 3) {
                // Maximum attempts reached
                setcookie('error', "The maximum limit for generating OTP is reached. Please try again later.", time() + 5, "/");
                ?>
                <script>
                    window.location.href = "login.php";  // Redirect to the login page
                </script>
                <?php
            } else {
                // Update OTP attempts and OTP in the database
                $query = "UPDATE password_token SET otp=$otp, otp_attempts=$otp_attempts+1, last_resend=NOW(), created_at = '$email_time', expires_at='$expiry_time' WHERE email='$email'";
            }
        } else {
            // Insert new record for the email
            $query = "INSERT INTO password_token (email, otp, created_at, expires_at, otp_attempts, last_resend) VALUES ('$email', '$otp', '$email_time', '$expiry_time', $otp_attempts, NOW())";
        }

        // Send the OTP email
        if (sendEmail($email, $subject, $body, "")) {
            if ($con->query($query)) {
                $_SESSION['forgot_email'] = $email;
                setcookie('success', 'OTP sent to registered email address. The OTP will expire in 2 minutes.', time() + 5);
                ?>
                <script>
                    window.location.href = "otp_form.php";  // Redirect to OTP form page
                </script>
                <?php
            } else {
                setcookie('error', 'Failed to generate OTP and store it in the database', time() + 5);
            }
        } else {
            setcookie('error', 'Failed to send the OTP via email. Please try again later.', time() + 5);
        }
    }
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
