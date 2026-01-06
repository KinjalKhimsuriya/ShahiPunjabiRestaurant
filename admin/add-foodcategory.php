<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['fosaid']) == 0) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $category = $_POST['categoryname'];

        $query = mysqli_query($con, "INSERT INTO tblcategory(CategoryName) VALUES('$category')");
        if ($query) {
            $msg = "<strong>Success!</strong> Category has been created..";
        } else {
            $msg = "<strong>Error!</strong> Something Went wrong.";
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
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <?php include_once('includes/leftbar.php'); ?>
        <div id="page-wrapper" class="gray-bg">
            <?php include_once('includes/header.php'); ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Food Category</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a>Category</a></li>
                        <li class="breadcrumb-item active"><strong>Add</strong></li>
                    </ol>
                </div>
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
                                <form id="categoryForm" action="#" method="post">
                                    <fieldset>
                                        <h2>Food Category</h2>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label for="categoryname">Category Name</label>
                                                    <input id="categoryname" name="categoryname" type="text" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <p style="text-align: center;">
                                                        <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="text-center" style="margin-top: 20px">
                                                    <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
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

    <!-- jQuery Validate -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <!-- jQuery Validation -->
    <script>
        $(document).ready(function () {
            $("#categoryForm").validate({
                rules: {
                    categoryname: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    categoryname: {
                        required: "Please enter a food category name.",
                        minlength: "Category must be at least 3 characters long."
                    }
                },
                errorClass: "text-danger",
                errorElement: "div",
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                }
            });
        });
    </script>

</body>

</html>
<?php } ?>
