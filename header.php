<?php
// session_start();
include_once("mailer.php");

date_default_timezone_set('Asia/Kolkata');
$current_time = date("Y-m-d H:i:s");

// Reset OTP attempts after 24 hours
$q = "UPDATE password_token SET otp_attempts = 0 
      WHERE TIMESTAMPDIFF(HOUR, last_resend, NOW()) >= 24";
$con->query($q);

// Remove expired OTP
$remove_otp = "UPDATE password_token SET otp=NULL 
               WHERE expires_at < '$current_time'";
$con->query($remove_otp);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shahi Punjabi Restaurant</title>

    <link rel="stylesheet" href="assets/css/icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/red-color.css">
    <link rel="stylesheet" href="assets/css/yellow-color.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body itemscope>

<main>

<!-- ================= HEADER ================= -->
<header class="stick">

<!-- ===== TOP BAR ===== -->
<div class="topbar">
    <div class="container">

        <div class="topbar-register">
            <?php if (!isset($_SESSION['fosuid']) || empty($_SESSION['fosuid'])) { ?>
                <a href="login.php">LOGIN</a> /
                <a href="register.php">REGISTER</a>
            <?php } ?>

            <?php if (isset($_SESSION['fosuid']) && !empty($_SESSION['fosuid'])) { ?>
                <a href="my-account.php">My Account</a>
            <?php } ?>
        </div>

        <div class="social1">
            <a href="#"><i class="fa fa-facebook-square"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-google-plus"></i></a>
        </div>

    </div>
</div>

<!-- ===== LOGO & MENU ===== -->
<div class="logo-menu-sec">
<div class="container">

<div class="logo">
    <h1>
        <a href="index.php">
            <i class="fa fa-cutlery"></i> <span style="font-weight:bold;">Shahi</span>
        </a>
    </h1>
</div>

<nav>
<div class="menu-sec">
<ul>

<li><a href="index.php">Home</a></li>

<li class="menu-item-has-children">
<a href="our-menu.php">Food Menu</a>
<ul class="sub-dropdown">
<?php
$query = mysqli_query($con, "SELECT * FROM tblcategory");
while ($row = mysqli_fetch_array($query)) {
?>
<li>
<a href="categorywise-menu.php?catid=<?php echo $row['CategoryName']; ?>">
<?php echo $row['CategoryName']; ?>
</a>
</li>
<?php } ?>
</ul>
</li>

<li><a href="track-order.php">Track Order</a></li>
<li><a href="contact-us.php">Contact us</a></li>
<li><a href="reservation.php">Book a table</a></li>

</ul>

<?php if (isset($_SESSION['fosuid']) && !empty($_SESSION['fosuid'])) { ?>
<a class="red-bg brd-rd4" href="cart.php">My Cart</a>
<?php } ?>

</div>
</nav>

</div>
</div>

</header>
<!-- ================= END HEADER ================= -->

<!-- ================= RESPONSIVE HEADER ================= -->
<div class="responsive-header">

<div class="responsive-logomenu">
    <div class="logo">
        <h1>
            <a href="index.php">
                <i class="fa fa-cutlery"></i> <span style="font-weight:bold;">Shahi</span>
            </a>
        </h1>
    </div>
    <span class="menu-btn yellow-bg brd-rd4">
        <i class="fa fa-align-justify"></i>
    </span>
</div>

<div class="responsive-menu">
<span class="menu-close red-bg brd-rd3"><i class="fa fa-close"></i></span>

<div class="menu-lst">
<ul>
<li><a href="index.php">Home</a></li>

<li class="menu-item-has-children">
<a href="our-menu.php">Food Menu</a>
<ul class="sub-dropdown">
<?php
$query = mysqli_query($con, "SELECT * FROM tblcategory");
while ($row = mysqli_fetch_array($query)) {
?>
<li>
<a href="categorywise-menu.php?catid=<?php echo $row['CategoryName']; ?>">
<?php echo $row['CategoryName']; ?>
</a>
</li>
<?php } ?>
</ul>
</li>

<li><a href="track-order.php">Track Order</a></li>
<li><a href="contact-us.php">Contact us</a></li>
</ul>
</div>

<div class="topbar-register">
<?php if (!isset($_SESSION['fosuid']) || empty($_SESSION['fosuid'])) { ?>
    <a href="login.php">LOGIN</a> /
    <a href="register.php">REGISTER</a>
<?php } ?>

<?php if (isset($_SESSION['fosuid']) && !empty($_SESSION['fosuid'])) { ?>
    <a href="my-account.php">My Account</a>
<?php } ?>
</div>

<div class="register-btn">
<?php if (isset($_SESSION['fosuid']) && !empty($_SESSION['fosuid'])) { ?>
<a class="yellow-bg brd-rd4" href="cart.php">My Cart</a>
<?php } ?>
</div>

</div>
</div>
<!-- ================= END RESPONSIVE HEADER ================= -->

</main>

</body>
</html>
