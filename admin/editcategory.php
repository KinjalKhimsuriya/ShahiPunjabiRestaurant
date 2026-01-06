<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Ensure the user is logged in
if (strlen($_SESSION['fosaid'] == 0)) {
    header('location:logout.php');
} else {
    // Clear cookies before displaying the page
    // if (isset($_COOKIE['success'])) {
    //     setcookie('success', '', time() - 3600, '/'); // Expire the cookie immediately
    // }
    // if (isset($_COOKIE['error'])) {
    //     setcookie('error', '', time() - 3600, '/'); // Expire the cookie immediately
    // }

    if (isset($_POST['submit'])) {
        $category = $_POST['categoryname'];
        $eid = $_GET['editid'];

        // Update the category name in the database
        $query = mysqli_query($con, "UPDATE tblcategory SET CategoryName ='$category' WHERE ID=$eid");
        if ($query) {
            $msg = "<strong>Success!</strong> Category has been Updated..";

             } else {
                $msg = "<strong>Error!</strong> Failed..";
           
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

    <!-- jQuery Validation -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/plugins/validate/jquery.validate.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // Initialize form validation
            $("form[name='submit']").validate({
                rules: {
                    categoryname: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    categoryname: {
                        required: "Please enter a category name",
                        minlength: "Category name must be at least 3 characters long"
                    }
                },
                submitHandler: function (form) {
                    form.submit(); // If validation is successful, submit the form
                }
            });

            // Automatically remove success/error message after 3 seconds
            setTimeout(function() {
                $(".alert").fadeOut();
            }, 3000); // 3 seconds
        });
    </script>
</head>

<body>

    <div id="wrapper">
        <?php include_once('includes/leftbar.php'); ?>

        <div id="page-wrapper" class="gray-bg">
            <?php include_once('includes/header.php'); ?>
            <div class="row border-bottom">
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">
                            <p style="font-size:16px; color:red;">
                                <?php if ($msg) {
                                                                            // echo $msg;
                                                                            ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                           <?php  echo $msg;?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                                                                            <?php 
                                                                        }  ?>
                                </p>
                                <?php
                                $cid = $_GET['editid'];
                                $ret = mysqli_query($con, "SELECT * FROM tblcategory WHERE ID='$cid'");
                                while ($row = mysqli_fetch_array($ret)) {
                                ?>
                                    <form id="form" class="wizard-big" method="post" name="submit">
                                        <fieldset>
                                            <h2>Food Category</h2>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <input id="categoryname" name="categoryname" type="text"
                                                            class="form-control required" required="true"
                                                            value="<?php echo $row['CategoryName']; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <p style="text-align: center;">
                                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                    </p>
                                                </div>
                                            </div>
                                        </fieldset>
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
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Steps -->
    <script src="js/plugins/steps/jquery.steps.min.js"></script>

</body>

</html>

<?php } ?>  
