<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>Shahi Punjabi Restaurant | My Account</title>
    <link rel="stylesheet" href="assets/css/icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/red-color.css">
    <link rel="stylesheet" href="assets/css/yellow-color.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- Include jQuery Validation Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {
            // Validation for Profile Update Form
            $("#form1").validate({
                rules: {
                    firstname: {
                        required: true,
                        minlength: 2
                    },
                    lastname: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobilenumber: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    regdate: {
                        required: true
                    }
                },
                messages: {
                    firstname: {
                        required: "Please enter your first name",
                        minlength: "First name must be at least 2 characters long"
                    },
                    lastname: {
                        required: "Please enter your last name",
                        minlength: "Last name must be at least 2 characters long"
                    },
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    mobilenumber: {
                        required: "Please enter your mobile number",
                        digits: "Please enter a valid mobile number",
                        minlength: "Mobile number must be 10 digits",
                        maxlength: "Mobile number must be 10 digits"
                    },
                    regdate: {
                        required: "Please enter your registration date"
                    }
                },
                submitHandler: function (form) {
                    // Form submission logic
                    alert("Profile updated successfully!");
                    form.submit();
                }
            });
        });
    </script>
</head>

<body itemscope>
    <?php include_once('includes/header.php'); ?>
    <section>
        <div class="block blackish opac90">
            <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);">
            </div>
            <div class="restaurant-searching style2">
                <div class="restaurant-searching-inner">
                    <h3>My Account</h3>
                </div>
            </div>
        </div>
    </section>
    <div class="bread-crumbs-wrapper">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
                <li class="breadcrumb-item ">My Account</li>
            </ol>
        </div>
    </div>
    <section>
        <div class="block less-spacing gray-bg top-padd30">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="sec-box">
                            <div class="dashboard-tabs-wrapper">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-lg-4">
                                        <div class="profile-sidebar brd-rd5 wow fadeIn" data-wow-delay="0.2s">
                                            <div class="profile-sidebar-inner brd-rd5">
                                                <div class="user-info red-bg">
                                                    <img class="brd-rd50" src="assets/images/profile.png" alt="user-avatar.jpg" itemprop="image">
                                                    <div class="user-info-inner">
                                                        <h5 itemprop="headline"><a href="#" title="" itemprop="url">John Doe</a></h5>
                                                        <span><a href="#" title="" itemprop="url">john.doe@example.com</a></span>
                                                        <a class="brd-rd3 sign-out-btn yellow-bg" href="logout.php" title="" itemprop="url"><i class="fa fa-sign-out"></i> SIGN OUT</a>
                                                    </div>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li><a href="my-account.php" style="color:#0c3b2e;"><i class="fa fa-shopping-basket" style="color:#0c3b2e;"></i> MY ORDERS</a></li>
                                                    <li><a href="change_password.php" style="color:#0c3b2e;"><i class="fa fa-wpforms" style="color:#0c3b2e;"></i> Change Password</a></li>
                                                    <li><a href="account-settings.php" style="color:#0c3b2e;"><i class="fa fa-cog" style="color:#0c3b2e;"></i> Profile</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-lg-8">
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="account-settings">
                                                <div class="tabs-wrp account-settings brd-rd5">
                                                    <h4 itemprop="headline">My Profile</h4>
                                                    <div class="account-settings-inner">
                                                        <div class="row">
                                                            <form method="post" id="form1" class="profile-info-form">
                                                                <div class="col-md-12 col-sm-12 col-lg-12">
                                                                    <div class="profile-info-form-wrap">
                                                                        <div class="row mrg20">
                                                                            <div class="col-md-12 col-sm-12 col-lg-12">
                                                                                <label>First Name<sup>*</sup></label>
                                                                                <input class="brd-rd3" type="text" id="firstname" name="firstname">
                                                                            </div>
                                                                            <div class="col-md-12 col-sm-12 col-lg-12">
                                                                                <label>Last Name<sup>*</sup></label>
                                                                                <input class="brd-rd3" type="text" id="lastname" name="lastname">
                                                                            </div>
                                                                            <div class="col-md-12 col-sm-12 col-lg-12">
                                                                                <label>Email address<sup>*</sup></label>
                                                                                <input class="brd-rd3" type="text" name="email">
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-6 col-lg-6">
                                                                                <label>Mobile Number<sup>*</sup></label>
                                                                                <input class="brd-rd3" type="text" id="mobilenumber" name="mobilenumber">
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-6 col-lg-6">
                                                                                <label>Registration Date</label>
                                                                                <input class="brd-rd3" type="text" name="regdate">
                                                                            </div>

                                                                            <div class="col-md-12 col-sm-12 col-lg-12">
                                                                                <button class="red-bg brd-rd3" type="submit" name="updateprofile">Update Profile</button>
                                                                            </div>
                                                                        </div>
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
                        <!-- Section Box -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php'); ?>
    <?php include_once('includes/signin.php'); ?>
    <?php include_once('includes/signup.php'); ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script src="assets/js/google-map-int.js"></script>
    <script src="../../www.google.com/recaptcha/api.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
