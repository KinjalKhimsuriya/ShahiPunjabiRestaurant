<?php
session_start();
include('includes/dbconnection.php');

if (!isset($_SESSION['fosaid']) || strlen($_SESSION['fosaid']) == 0) {
    header('location:logout.php');
    exit();
}

$successMsg = "";
$errorMsg = "";

if (isset($_POST['submit'])) {
    $adminid = $_SESSION['fosaid'];
    $adminname = $_POST['adminname'];
    $mobno = $_POST['mobilenumber'];
    $email = $_POST['email'];

    $query = mysqli_query($con, "UPDATE tbladmin SET AdminName ='$adminname', MobileNumber='$mobno', Email='$email' WHERE ID='$adminid'");

    if ($query) {
        $successMsg = "Admin profile has been updated successfully.";
    } else {
        $errorMsg = "Something went wrong. Please try again.";
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
</head>

<body>
    <div id="wrapper">
        <?php include_once('includes/leftbar.php'); ?>

        <div id="page-wrapper" class="gray-bg">
            <?php include_once('includes/header.php'); ?>

            <div class="row border-bottom"></div>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Admin Profile</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a>Profile</a></li>
                        <li class="breadcrumb-item active"><strong>Update</strong></li>
                    </ol>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">

                                <!-- Show Success Message -->
                                <?php if ($successMsg): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> <?= $successMsg; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <?php endif; ?>

                                <!-- Show Error Message -->
                                <?php if ($errorMsg): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> <?= $errorMsg; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <?php endif; ?>

                                <?php
                                $adminid = $_SESSION['fosaid'];
                                $ret = mysqli_query($con, "SELECT * FROM tbladmin WHERE ID='$adminid'");
                                while ($row = mysqli_fetch_array($ret)) {
                                ?>

                                <form id="submit" action="#" class="wizard-big" method="post" name="submit">
                                    <fieldset>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Admin Name:</label>
                                            <div class="col-sm-10">
                                                <input name='adminname' id="adminname" class="form-control white_bg"
                                                    value="<?= $row['AdminName']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">User Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="username"
                                                    readonly="true" value="<?= $row['UserName']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Mobile Number:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="mobilenumber"
                                                    required="true" value="<?= $row['MobileNumber']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email" required="true"
                                                    value="<?= $row['Email']; ?>" readonly="true" >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Admin Registration Date:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="adminrd" readonly="true"
                                                    value="<?= $row['AdminRegdate']; ?>">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <p style="text-align: center;">
                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
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
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/steps/jquery.steps.min.js"></script>
    <script src="js/plugins/validate/jquery.validate.min.js"></script>
</body>

</html>
