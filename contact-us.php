<?php
session_start();
include_once('includes/dbconnection.php');

// Initialize variables
$name = $email = $number = $message = '';
$success_msg = $error_msg = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $number = trim($_POST['number']);
    $message = trim($_POST['message']);
    $created_at = date('Y-m-d H:i:s');

    if (empty($name) || empty($email) || empty($number) || empty($message)) {
        setcookie("error", "All fields are required!", time() + 5, "/");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setcookie("error", "Invalid email format!", time() + 5, "/");
    } elseif (!preg_match("/^[0-9]{10,15}$/", $number)) {
        setcookie("error", "Invalid phone number!", time() + 5, "/");
    } else {
        $sql = "INSERT INTO tblcontact (name, email, phone, message, created_at) 
                VALUES ('$name', '$email', '$number', '$message', '$created_at')";
        if (mysqli_query($con, $sql)) {
            setcookie("success", "Thank you for contacting us! We'll get back to you soon.", time() + 5, "/");
            // Clear form fields
            $name = $email = $number = $message = '';
        } else {
            setcookie("error", "Error: " . mysqli_error($con), time() + 5, "/");
        }
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shahi Punjabi Restaurant | Contact us</title>
</head>
<?php include_once('header.php'); ?>
<section>
    <div class="block">
        <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
        <div class="page-title-wrapper text-center">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="page-title-inner">
                    <h1 itemprop="headline">Contact Us</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="bread-crumbs-wrapper">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
            <li class="breadcrumb-item">Contact Us</li>
        </ol>
    </div>
</div>

<section>
    <div class="block less-spacing gray-bg top-padd30">
        <div class="container">
            <?php if (isset($_COOKIE['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?= htmlspecialchars($_COOKIE['success']); ?>
                    </div>
                    <?php setcookie("success", "", time() - 3600, "/"); ?>
                <?php endif; ?>

                <?php if (isset($_COOKIE['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?= htmlspecialchars($_COOKIE['error']); ?>
                    </div>
                    <?php setcookie("error", "", time() - 3600, "/"); ?>
                <?php endif; ?>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="sec-box">
                        <div class="contact-info-sec text-center">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-lg-4">
                                    <div class="contact-info-box">
                                        <i class="fa fa-phone-square"></i>
                                        <h5 itemprop="headline">PHONE</h5>
                                        <p itemprop="description">Phone :+91 8574967485</p>
                                        <p itemprop="description">Phone :+91 8574967485 </p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-lg-4">
                                    <div class="contact-info-box">
                                        <i class="fa fa-map-marker"></i>
                                        <h5 itemprop="headline">ADDRESS</h5>
                                        <p itemprop="description">Rajkot 360003- Gujarat. </p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-lg-4">
                                    <div class="contact-info-box">
                                        <i class="fa fa-envelope"></i>
                                        <h5 itemprop="headline">EMAIL</h5>
                                        <p itemprop="description">kinjal@gmail.com</p>
                                        <p itemprop="description">alnur@gmail.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="contact-info-sec">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="sign-popup-wrapper brd-rd5">
                            <div class="sign-popup-inner brd-rd5">
                                <div class="sign-popup-title text-center">
                                    <h4 itemprop="headline">Contact Us </h4>
                                </div>
                                <form class="sign-form" id="trackOrderForm" method="post">
                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                        <input class="brd-rd3" type="text" placeholder="Enter Name"
                                            name="name" id="name" value="<?php echo htmlspecialchars($name); ?>">
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                        <input class="brd-rd3" type="text" placeholder="Enter email"
                                            name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                        <input class="brd-rd3" type="text" placeholder="Enter Number"
                                            name="number" id="number" value="<?php echo htmlspecialchars($number); ?>">
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                        <textarea class="form-control brd rd-3" id="message" name="message" rows="4" placeholder="Enter your message"><?php echo htmlspecialchars($message); ?></textarea>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                        <br>
                                        <button class="red-bg brd-rd3" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
<?php include_once('footer.php'); ?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="assets/js/google-map-int.js"></script>
<script src="../../www.google.com/recaptcha/api.js"></script>
<script src="assets/js/main.js"></script>
<!-- jQuery Validate Plugin -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    // jQuery Validation Script
    $(document).ready(function() {
        $("#trackOrderForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                number: {
                    required: true,
                    minlength: 10,
                    maxlength: 15,
                    digits: true
                },
                message: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Name must be at least 3 characters long"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                number: {
                    required: "Please enter your phone number",
                    minlength: "Phone number must be at least 10 digits",
                    maxlength: "Phone number cannot exceed 15 digits",
                    digits: "Please enter a valid phone number"
                },
                message: {
                    required: "Please enter a message",
                    minlength: "Your message must be at least 10 characters long"
                }
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("text-danger mt-1");
                error.insertAfter(element);
            },
            submitHandler: function(form) {
                form.submit(); // Submit form if validation passes
            }
        });
    });
</script>
</body>
</html>