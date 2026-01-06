<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');
   if (strlen($_SESSION['fosuid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['placeorder'])){
//getting address
$fnaobno=$_POST['flatbldgnumber'];
$street=$_POST['streename'];
$area=$_POST['area'];
$lndmark=$_POST['landmark'];
$city=$_POST['city'];
$userid=$_SESSION['fosuid'];
//genrating order number
$orderno= mt_rand(100000000, 999999999);
$query="update tblorders set OrderNumber='$orderno',IsOrderPlaced='1' where UserId='$userid' and IsOrderPlaced is null;";
$query.="insert into tblorderaddresses(UserId,Ordernumber,Flatnobuldngno,StreetName,Area,Landmark,City) values('$userid','$orderno','$fnaobno','$street','$area','$lndmark','$city');";

$result = mysqli_multi_query($con, $query);
if ($result) {
//Code for email
$toemail=$_SESSION['uemail'];
$subj="FOS Order Confirmation";       
$heade .= "MIME-Version: 1.0"."\r\n";
$heade .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
$heade .= 'From:FOS<noreply@yourdomain.com>'."\r\n";    // Put your sender email here
$msgec.="<html></body><div><div>Hello,</div></br></br>";
$msgec.="<div style='padding-top:8px;'> Your order has been placed successfully <br />
<strong> Order Number: </strong> $orderno </br>
</div><div></div></body></html>";
mail($toemail,$subj,$msgec,$heade);
echo '<script>alert("Your order placed successfully. Order number is "+"'.$orderno.'")</script>';
echo "<script>window.location.href='my-account.php'</script>";

}
}   

//Code deletion
if(isset($_GET['delid'])) {
$rid=$_GET['delid'];
$query=mysqli_query($con,"delete from tblorders where ID='$rid'");
echo '<script>alert("Food item deleted")</script>';
echo "<script>window.location.href='cart.php'</script>";

}

// if (isset($_POST['rating']) && isset($_POST['review'])) {
//     $name = $_SESSION['fname'];
//     $userid = $_SESSION['fosuid'];
//     $rating = intval($_POST['rating']);
//     $review = mysqli_real_escape_string($con, $_POST['review']);

//     $query = "INSERT INTO review (id, name, message, rate, ReviewDate) VALUES ('$userid', '$name', '$rating', '$review', NOW())";
//     $result = mysqli_query($con, $query);

//     if ($result) {
//         echo "<script>alert('Review submitted successfully'); window.location.href='track-order.php.php';</script>";
//     } else {
//         echo "<script>alert('Something went wrong.'); window.location.href='cart.php';</script>";
//     }
// }
?>


<head>
    <title>Shahi Punjabi Restaurant | Food Details</title>
</head>

<?php include_once('header.php'); ?>


<section>
    <div class="block">
        <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
        <div class="page-title-wrapper text-center">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="page-title-inner">
                    <h1 itemprop="headline">Cart</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="bread-crumbs-wrapper">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
            <li class="breadcrumb-item">My Cart</li>
        </ol>
    </div>
</div>

<section>
    <div class="block gray-bg bottom-padd210 top-padd30">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sec-box">
                        <div class="sec-wrapper">

                            <div class="col-md-12 col-sm-12 col-lg-12">

                                <div class="booking-table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Food Item</th>
                                                <th>Qty</th>
                                                <th>Per Unit Price</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $userid= $_SESSION['fosuid'];
                                                $query=mysqli_query($con,"select tblorders.ID as frid,tblfood.Image,tblfood.ItemName,tblfood.ItemDes,tblfood.ItemPrice,tblfood.ItemQty,tblorders.FoodId,tblorders.FoodQty from tblorders join tblfood on tblfood.ID=tblorders.FoodId where tblorders.UserId='$userid' and tblorders.IsOrderPlaced is null");
                                                $num=mysqli_num_rows($query);
                                                if($num>0){
                                                while ($row=mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <td><img src="admin/itemimages/<?php echo $row['Image']; ?>" width="100"
                                                        height="80" alt="<?php echo $row['ItemName']; ?>"></td>
                                                <td>
                                                    <a href="food-detail.php?fid=<?php echo $row['FoodId']; ?>" title=""
                                                        itemprop="url"><?php echo $row['ItemName']; ?></a>
                                                </td>
                                                <td><?php echo $qty = $row['FoodQty']; ?></td>
                                                <td>₹ <?php echo $ppu = $row['ItemPrice']; ?></td>
                                                <td><?php echo $total = $qty * $ppu; ?></td>
                                                <td><a href="cart.php?delid=<?php echo $row['frid']; ?>"
                                                        onclick="return confirm('Do you really want to delete?');";><i
                                                            class="fa fa-trash" aria-hidden="true"
                                                            title="Delete this food item"></i></a></span></td>
                                            </tr>

                                            <?php $grandtotal+=$total;}?>
                                            <thead>
                                                <tr>
                                                    <th colspan="4" style="text-align:center;">Grand Total</th>
                                                    <th style="text-align:center;">₹ <?php echo $grandtotal; ?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <form method="post">
                                                <tr>

                                                    <thead>
                                                        <tr>
                                                            <th colspan="4" style="text-align:center;">Cash On
                                                                Delivery</th>
                                                            <th style="text-align:center;">pay online</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <form method="post">
                                                <tr>

                                                    <td colspan="3">
                                                        <input type="text" name="flatbldgnumber"
                                                            placeholder="Flat or Building Number" class="form-control"
                                                            required="true">
                                                    </td>
                                                    <td colspan="3">
                                                        <input type="text" name="streename" placeholder="Street Name"
                                                            class="form-control" required="true">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <input type="text" name="area" placeholder="Area"
                                                            class="form-control" required="true">
                                                    </td>
                                                    <td colspan="3">
                                                        <input type="text" name="landmark"
                                                            placeholder="Landmark if any" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <input type="text" name="city" placeholder="City"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <button type="submit" name="placeorder"
                                                            class="btn theme-btn btn-lg">Place order</button>
                                                    </td>
                                                </tr>
                                            </form>

                                            <?php } else {?>
                                            <tr>
                                                <td colspan="6" style="color:red">You cart is empty</td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Section Box -->
    </div>


    <!-- <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 style="margin-top: 40px;">Write a Review</h3>
                <form id="reviewForm" method="post" action="submit-review.php">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" name="name" class="form-control" value="
                        <?php echo $_SESSION['fname'];?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Rating</label>
                        <select name="rating" class="form-control" required>
                            <option value="">Select Rating</option>
                            <option value="1">⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Your Review</label>
                        <textarea name="review" class="form-control" rows="4" placeholder="Write your experience here..." required></textarea>
                    </div>
                    <button type="submit" class="btn theme-btn btn-lg">Submit Review</button>
                </form>
            </div>
        </div>
    </div> -->
</section>

<!-- red section -->
</main>
<?php include_once('footer.php');
?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="assets/js/google-map-int2.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>


</body>

</html>
<?php } ?>
