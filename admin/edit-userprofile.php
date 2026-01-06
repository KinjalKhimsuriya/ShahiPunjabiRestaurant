<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['fosaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $sid = $_GET['userid'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email']; // Keep email updated if needed
        $mobilenumber = $_POST['mobilenumber'];

        // Check if a file is uploaded
        if ($_FILES['profile_image']['name']) {
            $file_name = $_FILES['profile_image']['name'];
            $file_tmp = $_FILES['profile_image']['tmp_name'];
            $file_size = $_FILES['profile_image']['size'];
            $file_type = $_FILES['profile_image']['type'];

            // $upload_dir = "../assets/images/profile/"; // Directory to save uploaded image
            $upload_dir = "img/"; // Directory to save uploaded image

            $target_file = $upload_dir . basename($file_name);

            // Move the file to the server folder
            if (move_uploaded_file($file_tmp, $target_file)) {
                $query = mysqli_query($con, "UPDATE tbluser SET FirstName='$fname', LastName='$lname', profile='$file_name' WHERE ID='$sid'");
            }
        } else {
            // If no file uploaded, update other fields
            $query = mysqli_query($con, "UPDATE tbluser SET FirstName='$fname', LastName='$lname' WHERE ID='$sid'");
        }

        if ($query) {
            $msg = "<strong>Success!</strong> User profile has been updated successfully.";
           
        
        } else {
            $msg = "Something went wrong. Please try again.";
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
                    <h2>User Details</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>User Details</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Update</strong>
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
                                                                            // echo $msg;
                                                                            ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                           <?php  echo $msg;?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                                                                            <?php 
                                                                        }  ?> </p>
                                <?php
                                $sid = $_GET['userid'];
                                $ret = mysqli_query($con, "select * from tbluser where ID='$sid'");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($ret)) {
                                ?>
                                    <form id="profileForm" action="#" class="wizard-big" method="post" name="submit" enctype="multipart/form-data">
                                        <fieldset>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">First Name:</label>
                                                <div class="col-sm-10"><input name='firstname' id="firstname" class="form-control white_bg" value="<?php echo $row['FirstName']; ?>" required="true">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Last Name:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" name="lastname" value="<?php echo $row['LastName']; ?>" required="true"></div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Email:</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" name="email" readonly="true" value="<?php echo $row['Email']; ?>" >
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Contact NO:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" name="mobilenumber" value="<?php echo $row['MobileNumber']; ?>" required="true"></div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Registration Date:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" name="price" readonly="true" value="<?php echo $row['RegDate']; ?>"></div>
                                            </div>

                                            <!-- Display Current Profile Image -->
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Profile Image:</label>
                                                <div class="col-sm-10">
                                                    <!-- <img src="../assets/images/profile/<?php //echo $row['profile']; ?>" alt="Profile Image" style="max-width: 150px; max-height: 150px; margin-bottom: 10px;"> -->
                                                    <img src="img/<?php echo $row['profile']; ?>" alt="Profile Image" style="max-width: 150px; max-height: 150px; margin-bottom: 10px;">
                                                    <input type="file" class="form-control" name="profile_image">
                                                    <small>Leave blank if you do not want to change the profile image</small>
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

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- jQuery Validation -->
    <!-- <script src="js/plugins/validate/jquery.validate.min.js"></script> -->

    <!-- Jquery Validate -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {

            // Initialize the form validation
            $("#submit").validate({
                rules: {
                    firstname: {
                        required: true,
                        minlength: 3
                    },
                    lastname: {
                        required: true,
                        minlength: 3
                    },
                    mobilenumber: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                },
                messages: {
                    firstname: {
                        required: "Please enter the admin name",
                        minlength: "Admin name must be at least 3 characters"
                    },
                    lastname: {
                        required: "Please enter the admin name",
                        minlength: "Admin name must be at least 3 characters"
                    },
                    mobilenumber: {
                        required: "Please enter a mobile number",
                        digits: "Please enter only digits",
                        minlength: "Mobile number must be 10 digits",
                        maxlength: "Mobile number must be 10 digits"
                    }
                },
                submitHandler: function (form) {
                    // You can handle the form submission here if needed
                    form.submit();
                }
            });

            // Revalidate the form on input change
            $("input").on("keyup change", function () {
                $("#submit").valid(); // Validate the form on keyup or change
            });

        });
    </script>

</body>

</html>
<?php } ?>
