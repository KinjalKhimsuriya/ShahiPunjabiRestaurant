<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['fosaid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {

        $oid = $_GET['orderid'];
        $ressta = $_POST['status'];
        $remark = $_POST['restremark'];
        $toemail = $_POST['useremail'];

        // Prepare SQL queries securely
        $query = mysqli_prepare($con, "INSERT INTO tblfoodtracking (OrderId, remark, status) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($query, 'iss', $oid, $remark, $ressta);
        $result = mysqli_stmt_execute($query);

        $updateQuery = mysqli_prepare($con, "UPDATE tblorderaddresses SET OrderFinalStatus=? WHERE Ordernumber=?");
        mysqli_stmt_bind_param($updateQuery, 'si', $ressta, $oid);
        $updateResult = mysqli_stmt_execute($updateQuery);

        if ($result && $updateResult) {
            // Send email
            $subject = "FOS Order Update";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: FOS <noreply@yourdomain.com>' . "\r\n";  // Use your real email

            $message = "<html><body><div><div>Hello,</div><br><br>";
            $message .= "<div>Your order has been updated.<br />";
            $message .= "<strong>Order Number:</strong> $oid<br />";
            $message .= "<strong>Order Status:</strong> $ressta<br />";
            $message .= "<strong>Remark:</strong> $remark<br /></div></div></body></html>";

            mail($toemail, $subject, $message, $headers);

            // $msg = "Order has been updated";
            $msg = "<strong>Success!</strong> Order has been Updated..";

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
</head>

<body>

    <div id="wrapper">

        <?php include_once('includes/leftbar.php');?>

        <div id="page-wrapper" class="gray-bg">
            <?php include_once('includes/header.php');?>

            <div class="row border-bottom"></div>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Order Details #<?php echo $_GET['orderid'];?></h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Order Detail</a>
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
                                <?php
                                    $oid = $_GET['orderid'];
                                    $ret = mysqli_query($con, "SELECT * FROM tblorderaddresses JOIN tbluser ON tbluser.ID = tblorderaddresses.UserId WHERE tblorderaddresses.Ordernumber = '$oid'");
                                    $row = mysqli_fetch_array($ret);

                                ?>
                                <div class="row">
                                    <div class="col-6">
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
                                        <table border="1" class="table table-bordered mg-b-0">
                                            <tr align="center">
                                                <td colspan="2" style="font-size:20px;color:blue">User Details</td>
                                            </tr>
                                            <tr>
                                                <th>Order Number</th>
                                                <td><?php echo $row['Ordernumber']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>First Name</th>
                                                <td><?php echo $row['FirstName']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Last Name</th>
                                                <td><?php echo $row['LastName']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?php echo $uemail = $row['Email']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Mobile Number</th>
                                                <td><?php echo $row['MobileNumber']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Flat no./buldng no.</th>
                                                <td><?php echo $row['Flatnobuldngno']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Street Name</th>
                                                <td><?php echo $row['StreetName']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Area</th>
                                                <td><?php echo $row['Area']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Landmark</th>
                                                <td><?php echo $row['Landmark']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>City</th>
                                                <td><?php echo $row['City']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Order Date</th>
                                                <td><?php echo $row['OrderTime']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Order Final Status</th>
                                                <td><?php
                                                    if ($row['OrderFinalStatus'] == "Order Confirmed") {
                                                        echo "Order Confirmed";
                                                    } elseif ($row['OrderFinalStatus'] == "Food being Prepared") {
                                                        echo "Food being Prepared";
                                                    } elseif ($row['OrderFinalStatus'] == "Food Pickup") {
                                                        echo "Food Pickup";
                                                    } elseif ($row['OrderFinalStatus'] == "Food Delivered") {
                                                        echo "Food Delivered";
                                                    } elseif ($row['OrderFinalStatus'] == "") {
                                                        echo "Wait for restaurant's approval";
                                                    } elseif ($row['OrderFinalStatus'] == "Order Cancelled") {
                                                        echo "Order Cancelled";
                                                    }
                                                ?></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-6" style="margin-top:2%">
                                        <?php  
                                            $query = mysqli_query($con, "SELECT tblfood.Image, tblfood.ItemName, tblfood.ItemDes, tblfood.ItemPrice, tblfood.ItemQty, tblorders.FoodId, tblorders.FoodQty FROM tblorders JOIN tblfood ON tblfood.ID = tblorders.FoodId WHERE tblorders.IsOrderPlaced = 1 AND tblorders.OrderNumber = '$oid'");
                                            $cnt = 1;
                                            $grandtotal = 0;
                                        ?>
                                        <table border="1" class="table table-bordered mg-b-0">
                                            <tr align="center">
                                                <td colspan="6" style="font-size:20px;color:blue">Order Details</td>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>Food</th>
                                                <th>Food Name</th>
                                                <th>Qty</th>
                                                <th>Price/Unit</th>
                                                <th>Total</th>
                                            </tr>
                                            <?php  
                                                while ($row1 = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><img src="itemimages/<?php echo $row1['Image']?>" width="60" height="40" alt="<?php echo $row['ItemName']?>"></td>
                                                <td><?php echo $row1['ItemName']; ?></td>
                                                <td><?php echo $qty = $row1['FoodQty']; ?></td>
                                                <td><?php echo $ppu = $row1['ItemPrice']; ?></td>
                                                <td><?php echo $total = $qty * $ppu; ?></td>
                                            </tr>
                                            <?php 
                                                $grandtotal += $total;
                                                $cnt++;
                                            } 
                                            ?>
                                            <tr>
                                                <th colspan="5" style="text-align:center">Grand Total</th>
                                                <td><?php echo $grandtotal; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <form name="submit" method="post"> 
                                    <table class="table mb-0">
                                        <?php
                                            if ($row['OrderFinalStatus'] == "Order Confirmed" || $row['OrderFinalStatus'] == "Food being Prepared" || $row['OrderFinalStatus'] == "Food Pickup" || $row['OrderFinalStatus'] == "") {
                                        ?>
                                        <tr>
                                            <th>Restaurant Remark:</th>
                                            <td>
                                                <input type="hidden" name="useremail" value="<?php echo $uemail; ?>">
                                                <textarea name="restremark" placeholder="" rows="12" cols="14" class="form-control wd-450" required="true"></textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Restaurant Status:</th>
                                            <td>
                                                <select name="status" class="form-control wd-450" required="true">
                                                    <option value="Order Confirmed" selected="true">Order Confirmed</option>
                                                    <option value="Order Cancelled">Order Cancelled</option>
                                                    <option value="Food being Prepared">Food being Prepared</option>
                                                    <option value="Food Pickup">Food Pickup</option>
                                                    <option value="Food Delivered">Food Delivered</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr align="center">
                                            <td colspan="2"><button type="submit" name="submit" class="btn btn-primary">Update Order</button></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </form>

                                <?php if ($row['OrderFinalStatus'] != "") { 
                                    $ret = mysqli_query($con, "SELECT tblfoodtracking.OrderCanclledByUser, tblfoodtracking.remark, tblfoodtracking.status AS fstatus, tblfoodtracking.StatusDate FROM tblfoodtracking WHERE tblfoodtracking.OrderId = '$oid'");
                                    $cnt = 1;
                                ?>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <tr align="center">
                                        <th colspan="4">Food Tracking History</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Remark</th>
                                        <th>Status</th>
                                        <th>Status Date</th>
                                    </tr>
                                    <?php  
                                        while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo $row['remark']; ?></td>
                                        <td><?php echo $row['fstatus']; ?></td>
                                        <td><?php echo $row['StatusDate']; ?></td>
                                    </tr>
                                    <?php 
                                        $cnt++;
                                        } 
                                    ?>
                                </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
<?php } ?> 
