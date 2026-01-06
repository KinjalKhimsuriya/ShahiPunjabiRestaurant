<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['fosaid']) == 0) {
    header('location:logout.php');
} else {
    $msg = "";
    if (isset($_POST['submit'])) {
        $adminid = $_SESSION['fosaid'];
        $cpassword = $_POST['currentpassword'];
        $newpassword = $_POST['newpassword'];

        $query = mysqli_query($con, "SELECT ID FROM tbladmin WHERE ID='$adminid' AND Password='$cpassword'");
        $row = mysqli_fetch_array($query);

        if ($row > 0) {
            $ret = mysqli_query($con, "UPDATE tbladmin SET Password='$newpassword' WHERE ID='$adminid'");
            $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your password has been changed.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Your current password is incorrect.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
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

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/plugins/validate/jquery.validate.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("form[name='changepassword']").validate({
                rules: {
                    currentpassword: {
                        required: true,
                        minlength: 6
                    },
                    newpassword: {
                        required: true,
                        minlength: 6
                    },
                    confirmpassword: {
                        required: true,
                        minlength: 6,
                        equalTo: "#newpassword"
                    }
                },
                messages: {
                    currentpassword: {
                        required: "Please enter your current password",
                        minlength: "Your current password must be at least 6 characters long"
                    },
                    newpassword: {
                        required: "Please enter a new password",
                        minlength: "Your new password must be at least 6 characters long"
                    },
                    confirmpassword: {
                        required: "Please confirm your new password",
                        minlength: "Your confirmation password must be at least 6 characters long",
                        equalTo: "New Password and Confirm Password do not match"
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>
</head>

<body>
    <div id="wrapper">
        <?php include_once('includes/leftbar.php'); ?>
        <div id="page-wrapper" class="gray-bg">
            <?php include_once('includes/header.php'); ?>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Change Password</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Password</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Change</strong>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">

                                <!-- Display message -->
                                <?php if ($msg) {
                                    echo $msg;
                                } ?>

                                <?php
                                $adminid = $_SESSION['fosaid'];
                                $ret = mysqli_query($con, "SELECT * FROM tbladmin WHERE ID='$adminid'");
                                while ($row = mysqli_fetch_array($ret)) {
                                ?>

                                <form name="changepassword" method="post" class="wizard-big">
                                    <fieldset>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Current Password:</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="currentpassword" id="currentpassword" class="form-control white_bg" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">New Password:</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="newpassword" id="newpassword" class="form-control white_bg" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Confirm Password:</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="confirmpassword" id="confirmpassword" class="form-control white_bg" required>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <p style="text-align: center;">
                                        <button type="submit" name="submit" class="btn btn-primary">Change</button>
                                    </p>
                                </form>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/steps/jquery.steps.min.js"></script>
</body>
</html>

<?php } ?>
