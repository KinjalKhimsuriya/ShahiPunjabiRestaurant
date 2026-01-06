<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosaid'] == 0)) {
    header('location:logout.php');
} 
else {
    if(isset($_POST['submit'])) {
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $contno = $_POST['number'];  // Make sure the key here matches the input name
        $email = $_POST['email'];
        $password = $_POST['password']; // Hashing the password
    
        $profile = $_FILES['profile']['name'];
        $profile_temp = $_FILES['profile']['tmp_name'];
        // $profile_path = "../assets/images/profile/"; // Directory to save uploaded image

        $profile_path = "img/"; // Directory to save uploaded image
        $target_file = $profile_path . basename($profile);
    
        if(move_uploaded_file($profile_temp, $target_file)) {
            $ret = mysqli_query($con, "SELECT Email FROM tbluser WHERE Email='$email' OR MobileNumber='$contno'");
            $result = mysqli_fetch_array($ret);
    
            if($result > 0) {
                setcookie('error', 'This email or Contact Number is already associated with another account', time() + 3, '/');
                echo "<script>window.location.href='add_user.php';</script>";
            } else {
                $query = mysqli_query($con, "INSERT INTO tbluser (FirstName, LastName, MobileNumber, Email, Password, profile) 
                                             VALUES ('$fname', '$lname', '$contno', '$email', '$password', '$profile')");
                if ($query) {
                    // setcookie('success', 'You have successfully registered', time() + 3, '/');
                    ?>  <script>alert("success");</script> <?php
                    echo "<script>window.location.href='user-detail.php';</script>";
                } else {
                    // setcookie('error', 'Something went wrong. Please try again.', time() + 3, '/'); 
                    ?>  <script>alert("failed");</script> <?php
                    echo "<script>window.location.href='add_user.php';</script>";
                }
            }
        } else {
            // setcookie('error', 'Failed to upload profile picture. Please try again.', time() + 3, '/');
            ?>  <script>alert("failed picture");</script> <?php

            echo "<script>window.location.href='add_user.php';</script>";
        }
    }
}
    ?>
    <!DOCTYPE html>
    <html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Shahi Punjabi Restaurant</title>
    

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        <!-- Add jQuery Validate CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-validation/1.19.3/jquery.validate.min.css"
            rel="stylesheet" />

    </head>

    <body>

        <div id="wrapper">

            <?php include_once('includes/leftbar.php'); ?>

            <div id="page-wrapper" class="gray-bg">
                <?php include_once('includes/header.php'); ?>
                <div class="row border-bottom">

                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Reg User</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="dashboard.php">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a>User</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <strong>Add</strong>
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="wrapper wrapper-content animated fadeInRight">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">

                                <div class="ibox-content">
                                    <p style="font-size:16px; color:red;"> <?php if ($msg) {
                                        echo $msg;
                                    } ?> </p>

                                    <form id="user" action="#" class="wizard-big" method="post" name="submit"
                                        enctype="multipart/form-data">
                                        <fieldset>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">First name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="firstname" id="firstname" class="form-control white_bg" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Last name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="lastname" id="lastname" class="form-control white_bg" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" id="email" class="form-control white_bg" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Contact No:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="number" id="number" class="form-control white_bg" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Password:</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password" id="password" class="form-control white_bg" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Confirm Password:</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="conf_password" id="conf_password" class="form-control white_bg" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Profile:</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="profile" id="profile" class="form-control white_bg" required="true">
                                            </div>
                                        </div>
                                    </fieldset>

                                        <p style="text-align: center;"><button type="submit" name="submit"
                                                class="btn btn-primary">Submit</button></p>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>

            </div>
        </div>

        <!-- Mainly scripts -->
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>

        <!-- Steps -->
        <script src="js/plugins/steps/jquery.steps.min.js"></script>

        <!-- jQuery Validate -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validation/1.19.3/jquery.validate.min.js"></script>



    </body>

    </html>
<?php //} ?>