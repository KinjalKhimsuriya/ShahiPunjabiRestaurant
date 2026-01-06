<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosaid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $faid = $_SESSION['fosaid'];
        $fcat = $_POST['foodcategory'];
        $itemname = $_POST['itemname'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        $itempic = $_FILES["itemimages"]["name"];
        $extension = substr($itempic, strlen($itempic) - 4, strlen($itempic));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");

        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            $itempic = md5($itempic) . $extension;
            move_uploaded_file($_FILES["itemimages"]["tmp_name"], "itemimages/" . $itempic);
            $query = mysqli_query($con, "insert into tblfood(CategoryName,ItemName,ItemPrice,ItemDes,ItemQty,Image) value('$fcat','$itemname','$price','$description','$quantity','$itempic')");
            if ($query) {
                // $msg = "Food Item has been added.";
                // $msg = "<strong>Success!</strong> Food Item Added..";
                ?>
                <script> alert(" Food Item Added..");
                    window.location="manage-fooditems.php";
                </script>
                <?php 
            } else {
                // $msg = "Something Went Wrong. Please try again";
                $msg = "<strong>Error!</strong>Something Went Wrong...";

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

    <style>
        .text-center-error {
            display: block;
            width: 100%;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        <?php include_once('includes/leftbar.php'); ?>
        <div id="page-wrapper" class="gray-bg">
            <?php include_once('includes/header.php'); ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Food Items</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a>Item Name</a></li>
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
                           <?php  //echo $msg;?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                                                                            <?php 
                                                                        }  ?>
                                </p>

                                <form id="foodForm" action="#" class="wizard-big" method="post" name="submit" enctype="multipart/form-data">
                                    <fieldset>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Food Category:</label>
                                            <div class="col-sm-10">
                                                <select name='foodcategory' id="foodcategory" class="form-control white_bg">
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    $query = mysqli_query($con, "select * from tblcategory");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                        <option value="<?php echo $row['CategoryName']; ?>"><?php echo $row['CategoryName']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Item Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="itemname" id="itemname">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Description:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Image:</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="itemimages" id="itemimages">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Quantity:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="quantity" id="quantity">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Price:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="price" id="price">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <p style="text-align: center;">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>

    <!-- jQuery and other scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/steps/jquery.steps.min.js"></script>

    <!-- jQuery Validate -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <!-- Validation Rules -->
    <script>
        $(document).ready(function () {
            $("#foodForm").validate({
                rules: {
                    foodcategory: { required: true },
                    itemname: { required: true, minlength: 2 },
                    description: { required: true, minlength: 5 },
                    itemimages: { required: true, extension: "jpg|jpeg|png|gif" },
                    quantity: { required: true, digits: true, min: 1 },
                    price: { required: true, number: true, min: 1 }
                },
                messages: {
                    foodcategory: { required: "Please select a category" },
                    itemname: { required: "Enter item name", minlength: "Minimum 2 characters" },
                    description: { required: "Enter description", minlength: "Minimum 5 characters" },
                    itemimages: { required: "Upload an image", extension: "Only jpg/jpeg/png/gif allowed" },
                    quantity: { required: "Enter quantity", digits: "Only digits", min: "At least 1" },
                    price: { required: "Enter price", number: "Valid number only", min: "At least 1" }
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('text-danger text-left text-left-error');
                    element.closest('.col-sm-10').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

</body>
</html>
<?php } ?>
