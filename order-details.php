<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');

if (strlen($_SESSION['fosuid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['review'])) {
        if (isset($_POST['name']) && isset($_POST['rate']) && isset($_POST['message'])) {
            $userid = $_SESSION['fosuid'];
            $name = $_POST['name'];
            $rate = $_POST['rate'];
            $message = $_POST['message'];
            $ordernumber = $_GET['onumber'];

            // Handle image upload
            $image = $_FILES['image']['name'];
            $tmp_image = $_FILES['image']['tmp_name'];
            $folder = "assets/images/";

            // Ensure folder exists
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            // Set unique filename
            $unique_name = time() . "_" . basename($image);
            $target_path = $folder . $unique_name;

            if (move_uploaded_file($tmp_image, $target_path)) {
                $query = "INSERT INTO review(userid, ordernumber, name, rate, message, image)
                          VALUES('$userid', '$ordernumber', '$name', '$rate', '$message', '$unique_name')";
                $result = mysqli_query($con, $query);

                if ($result) {
                    echo "<script>alert('Review submitted successfully.');</script>";
                } else {
                    echo "<script>alert('Database error. Try again.');</script>";
                }
            } else {
                echo "<script>alert('Image upload failed.');</script>";
            }
        }
    }
?>

<head>
    <title>Shahi Punjabi Restaurant | Food Details</title>
    <script language="javascript" type="text/javascript">
        var popUpWin = 0;
        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin = open(
                URLStr,
                'popUpWin',
                'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + ''
            );
        }
    </script>
</head>

<?php include_once('header.php'); ?>

<section>
    <div class="block">
        <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
        <div class="page-title-wrapper text-center">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="page-title-inner">
                    <h1 itemprop="headline">Order #<?php echo $_GET['onumber']; ?> Details</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="bread-crumbs-wrapper">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
            <li class="breadcrumb-item">Order Details</li>
        </ol>
    </div>
</div>

<section>
    <div class="block gray-bg top-padd30">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sec-box">
                        <div class="sec-wrapper">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="booking-table">
                                    <?php
                                    $userid = $_SESSION['fosuid'];
                                    $oid = $_GET['onumber'];
                                    $query = mysqli_query($con, "SELECT * FROM tblorderaddresses WHERE UserId='$userid' AND Ordernumber='$oid'");
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <h3 align="center">Order #<?php echo $oid; ?> Details</h3>
                                        <table border="1" style="padding-left:10%">
                                            <tr>
                                                <th>Order Number#</th>
                                                <td><?php echo $row['Ordernumber']; ?></td>
                                                <th>Order Date/Time</th>
                                                <td><?php echo $row['OrderTime'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Order Status</th>
                                                <td colspan="3">
                                                    <?php
                                                    $status = $row['OrderFinalStatus'];
                                                    if ($status == '') {
                                                        echo "Waiting for Restaurant confirmation";
                                                    } else {
                                                        echo $status;
                                                    }
                                                    ?>
                                                    (<a href="javascript:void(0);" onClick="popUpWindow('trackorder.php?oid=<?php echo htmlentities($row['Ordernumber']); ?>');" title="Track order" style="color:red;"><i class="flaticon-transport"></i> Track Order</a>)
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="4" style="text-align:center;color:blue; font-size:20px;">Delivery Address</th>
                                            </tr>
                                            <tr>
                                                <th>Flat No / Building No.:</th>
                                                <td><?php echo $row['Flatnobuldngno'] ?></td>
                                                <th>Street Name:</th>
                                                <td><?php echo $row['StreetName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Area :</th>
                                                <td><?php echo $row['Area'] ?></td>
                                                <th>Landmark:</th>
                                                <td><?php echo $row['Landmark'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>City :</th>
                                                <td><?php echo $row['City'] ?></td>
                                            </tr>
                                        </table>
                                        <p style="font-weight:bold; font-size:18px;">
                                            <a href="javascript:void(0);" onClick="popUpWindow('invoice.php?oid=<?php echo htmlentities($row['Ordernumber']); ?>');" title="Order Invoice" style="color:red">Invoice</a> |
                                            <a href="javascript:void(0);" onClick="popUpWindow('cancelorder.php?oid=<?php echo htmlentities($row['Ordernumber']); ?>');" title="Cancel this order" style="color:red">Cancel this order</a>
                                        </p>
                                    <?php } ?>

                                    <hr />
                                    <p style="font-size:22px; color:red; font-weight:bold">Order Details</p>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Food Item</th>
                                                <th>Qty</th>
                                                <th>Per Unit Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($con, "SELECT tblfood.Image, tblfood.ItemName, tblfood.ItemDes, tblfood.ItemPrice, tblfood.ItemQty, tblorders.FoodId, tblorders.FoodQty FROM tblorders JOIN tblfood ON tblfood.ID=tblorders.FoodId WHERE tblorders.UserId='$userid' AND tblorders.IsOrderPlaced=1 AND tblorders.OrderNumber='$oid'");
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td><img src="admin/itemimages/<?php echo $row['Image'] ?>" width="100" height="80" alt="<?php echo $row['ItemName'] ?>"></td>
                                                    <td><a href="food-detail.php?fid=<?php echo $row['FoodId']; ?>" itemprop="url"><?php echo $row['ItemName'] ?></a></td>
                                                    <td><?php echo $qty = $row['FoodQty'] ?></td>
                                                    <td><?php echo $ppu = $row['ItemPrice'] ?></td>
                                                    <td><?php echo $total = $qty * $ppu; ?></td>
                                                </tr>
                                            <?php $grandtotal += $total;
                                            } ?>
                                            <thead>
                                                <tr>
                                                    <th colspan="4" style="text-align:center;">Grand Total</th>
                                                    <th style="text-align:center;"><?php echo $grandtotal; ?></th>
                                                </tr>
                                            </thead>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php 
            $query=mysqli_query($con,"select * from tblorderaddresses where Ordernumber ='$oid'");
            $ret=mysqli_fetch_array($query);
            if($ret['OrderFinalStatus']=="Food Delivered"){
                $chk = mysqli_query($con,"SELECT * FROM review WHERE ordernumber = '$oid' AND userid = '$userid'");
                if (mysqli_num_rows($chk) > 0) {
                    echo '<p>You have already submitted a review for this order.</p>';
                } else {
                    $query1=mysqli_query($con,"select * from tbluser where ID=$userid");
                    $row1 = mysqli_fetch_array($query1);
                    $first = $row1['FirstName'];
                    $last = $row1['LastName'];
            ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="login-register-wrapper">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-lg-12">
                                    <div class="sign-popup-wrapper brd-rd5">
                                        <div class="sign-popup-inner brd-rd5">
                                            <div class="sign-popup-title text-center">
                                                <h4 itemprop="headline">Add Your Review</h4>
                                            </div>

                                            <form class="sign-form" id="reviewForm" method="post" enctype="multipart/form-data" action="#">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                        <label>Your Name</label>
                                                        <input type="text" name="name" class="brd-rd3" value="<?php echo $first .' '. $last; ?>" readonly>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                        <label>Rating</label>
                                                        <input class="brd-rd3" type="number" placeholder="Rate (0-5)" name="rate">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                        <label>Your Review</label>
                                                        <textarea class="form-control brd rd-3" id="message" name="message" rows="4" placeholder="Write Your Review"></textarea>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                        <label>Image</label>
                                                        <input type="file" name="image" class="brd-rd3" >
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                        <br>
                                                        <button class="red-bg brd-rd3" type="submit" name="review">Submit</button>
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

             <?php } }?>   
        </div>
    </div>
</section>

<?php include_once('footer.php'); ?>
<?php include_once('includes/signin.php'); ?>
<?php include_once('includes/signup.php'); ?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="assets/js/google-map-int2.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>
<!-- jQuery Validate CDN (make sure this is included) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        $("#reviewForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                rate: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 5
                },
                message: {
                    required: true,
                    minlength: 5
                },
                image:{
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Name must be at least 2 characters long"
                },
                rate: {
                    required: "Please enter a rating",
                    number: "Please enter a valid number",
                    min: "Minimum rating is 0",
                    max: "Maximum rating is 5"
                },
                message: {
                    required: "Please enter your review",
                    minlength: "Review must be at least 5 characters long"
                },
                image: {
                    required: "Please select profile image"
                }
            },
            errorClass: "text-danger",
            errorElement: "div",
            highlight: function (element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid");
            }
        });
    });
</script>

</body>
</html>
<?php } ?>
