<?php
session_start();
include_once('includes/dbconnection.php');

// If not logged in, redirect to logout
if (!isset($_SESSION['fosuid']) || strlen($_SESSION['fosuid']) == 0) {
    header('location:logout.php');
    exit();
}

// Update profile
if (isset($_POST['updateprofile'])) {
   $sid = $_SESSION['fosuid'];  // Get the logged-in user ID
   $fname = $_POST['firstname']; // Get the first name from form input
   $lname = $_POST['lastname'];  // Get the last name from form input
   $email = $_POST['email'];     // Get the email from form input
   $profile_image = $_FILES['profile']['name']; // Get the uploaded image name

   // If a file is uploaded, handle image upload
   if (!empty($profile_image)) {
       // Handle image upload
       $target_dir = "assets/images/profile/";
       $target_file = $target_dir . basename($_FILES["profile"]["name"]);
       $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

       // Check if the uploaded file is an image
       $check = getimagesize($_FILES["profile"]["tmp_name"]);
       if ($check !== false) {
           // Move the uploaded file to the server directory
           if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
               $profile_image = basename($_FILES["profile"]["name"]);
           } else {
               setcookie("error", "Sorry, there was an error uploading your file.", time() + 5, "/");
               header("Location: my-account.php");
               exit();
           }
       } else {
           setcookie("error", "File is not an image.", time() + 5, "/");
           header("Location: my-account.php");
           exit();
       }
   } else {
       // If no new file is uploaded, retain the old profile image by not changing it in the database
       $current_user_query = mysqli_query($con, "SELECT profile FROM tbluser WHERE ID='$sid'");
       $row = mysqli_fetch_assoc($current_user_query);
       $profile_image = $row['profile']; // Retain the old profile image
   }

   // Update user data in the database
   $query = mysqli_query($con, "UPDATE tbluser SET FirstName='$fname', LastName='$lname', Email='$email', profile='$profile_image' WHERE ID='$sid'");

   // Check if the query is successful and set success or error message accordingly
   if ($query) {
       setcookie("success", "Your profile has been updated.", time() + 5, "/");
   } else {
       setcookie("error", "Something went wrong. Please try again.", time() + 5, "/");
   }

   // Redirect to the same page
   header("Location: my-account.php");
   exit();
}

// Change password
if (isset($_POST['changepassword'])) {
    $userid = $_SESSION['fosuid'];
    $cpassword = $_POST['currentpassword'];
    $newpassword = $_POST['newpassword'];
   
    $query = mysqli_query($con, "SELECT ID FROM tbluser WHERE ID='$userid' AND Password='$cpassword'");
    if (mysqli_num_rows($query) > 0) {
        mysqli_query($con, "UPDATE tbluser SET Password='$newpassword' WHERE ID='$userid'");
        setcookie("success", "Your password changed successfully.", time() + 5, "/");
    } else {
        setcookie("error", "Your current password is incorrect.", time() + 5, "/");
    }
    header("Location: my-account.php");
    exit();
}
?>

 
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="" />
      <meta name="keywords" content="" />
      <title>Shahi Punjabi Restaurant | My Account</title>
      <link rel="stylesheet" href="assets/css/icons.min.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/main.css">
      <link rel="stylesheet" href="assets/css/red-color.css">
      <link rel="stylesheet" href="assets/css/yellow-color.css">
      <link rel="stylesheet" href="assets/css/responsive.css">
      <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
      <script type="text/javascript">
function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
} 

</script>
          <script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

</script>
   </head>
    
      <?php include_once('header.php');?>
      <section>
         <div class="block">
            <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
            <div class="page-title-wrapper text-center">
               <div class="col-md-12 col-sm-12 col-lg-12">
                  <div class="page-title-inner">
                     <h1 itemprop="headline">My Account</h1>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <div class="bread-crumbs-wrapper">
         <div class="container">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
               <li class="breadcrumb-item">Dashboard</li>
            </ol>
         </div>
      </div>
      <section>
         <div class="block less-spacing gray-bg top-padd30">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-lg-12">
                     <div class="sec-box">
                        <div class="dashboard-tabs-wrapper">
                           <div class="row">
                              <div class="col-md-4 col-sm-12 col-lg-4">
                                 <div class="profile-sidebar brd-rd5 wow fadeIn" data-wow-delay="0.2s">
                                    <div class="profile-sidebar-inner brd-rd5">

                                <?php
$pid=$_SESSION['fosuid'];
$ret=mysqli_query($con,"select * from tbluser where ID='$pid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>  

                                       <div class="user-info red-bg">
                                          <img class="brd-rd50" src="assets/images/profile/<?php echo $row['profile'] ?>" alt="<?php echo $row['profile'] ?>" itemprop="image" height="73px" width="73px">
                                          <!-- <img class="brd-rd50" src="assets/images/profile.png" alt="user-avatar.jpg" itemprop="image"> -->
                                          <div class="user-info-inner">
                                             <h5 itemprop="headline"><a href="#" title="" itemprop="url"><?php  echo $row['FirstName']." ".$row['LastName'];?></a></h5>
                                             <span><a href="#" title="" itemprop="url"><?php  echo $row['Email'];?></a></span>
                                             <a class="brd-rd3 sign-out-btn yellow-bg" href="logout.php" title="" itemprop="url"><i class="fa fa-sign-out"></i> SIGN OUT</a>
                                          </div>
                                       </div>
                                   <?php } ?>
                                       <ul class="nav nav-tabs">
                                          <li class="active"><a href="#my-orders" data-toggle="tab"><i class="fa fa-shopping-basket"></i> MY ORDERS</a></li>
                                          <li><a href="#statement" data-toggle="tab"><i class="fa fa-wpforms"></i> Change Password</a></li>
                                          <li><a href="#account-settings" data-toggle="tab"><i class="fa fa-cog"></i> Profile</a></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-8 col-sm-12 col-lg-8">
                                 <div class="tab-content">
                                    <?php //if($msg) {echo $msg; }?>
                                    <?php if(isset($_COOKIE['success'])) { ?>
                                       <div class="alert alert-success alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                                          <?php echo $_COOKIE['success']; ?>
                                       </div>
                                    <?php setcookie("error", "", time() - 3600, "/"); } ?>

                                    <?php if(isset($_COOKIE['error'])) { ?>
                                       <div class="alert alert-danger alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                                          <?php echo $_COOKIE['error']; ?>
                                       </div>
                                    <?php setcookie("error", "", time() - 3600, "/"); } ?>

                  
                                    <div class="tab-pane fade in active" id="my-orders">
                                       <div class="tabs-wrp brd-rd5">
                                          <h4 itemprop="headline">MY ORDERS</h4>
                                          <hr />
                                          <div class="select-wrap-inner">
                                     
                                          </div>
                                          <div class="order-list">

<?php
$uid=$_SESSION['fosuid'];
      $query=mysqli_query($con,"select * from  tblorderaddresses  where UserId='$uid'");
      $count=1;
      $num=mysqli_num_rows( $query);
      if($num>0){
              while($row=mysqli_fetch_array($query))
              { ?>  

                                             <div class="order-item brd-rd5">
                                                <div class="order-thumb brd-rd5">
                                                   <a href="#" title="" itemprop="url"><img src="assets/images/order.jpg" alt="order-img1.jpg" itemprop="image"></a>
                                            
                                                </div>
                                                <div class="order-info">
                                                   <span class="red-clr"><b>Order Date :</b> <?php echo $row['OrderTime']?></span>
                                                   <h4 itemprop="headline"><a href="#" title="" itemprop="url">Order # <?php echo $row['Ordernumber'];?></a></h4>
                                                   <span class="processing brd-rd3"> <?php $status=$row['OrderFinalStatus'];
if($status==''){
 echo "Waiting for Restaurant confirmation";   
} else{
echo $status;
}

                                                    ?></span>
                                                   <a class="brd-rd2" href="order-details.php?onumber=<?php echo $row['Ordernumber'];?>" title="Order Detail" itemprop="url">Order Details</a>

                                                   <ul class="post-meta">
                                                               
                                     <li style="font-size:16px;"> <a href="javascript:void(0);" onClick="popUpWindow('trackorder.php?oid=<?php echo htmlentities($row['Ordernumber']);?>');" title="Track order"><i class="flaticon-transport"></i> Track Order</a></li>
                                                                    </ul>
                                                </div>
                                             </div>
                                         <?php } } else {?>
                                    <h5 style="color:red">No order found</h5>
                                     <?php } ?>
                                          </div>
                                
                                          <!-- Pagination Wrapper -->
                                       </div>
                                    </div>
              
                                    <div class="tab-pane fade" id="statement">
                                       <div class="tabs-wrp brd-rd5">
                                          <h4 itemprop="headline">Change Password</h4>
                                      
            <form method="post" class="profile-info-form" name="changepassword" onsubmit="return checkpass();">
                                         <div class="col-md-12 col-sm-12 col-lg-12">
                                                               <label>Current Password<sup>*</sup></label>
                                                               <input class="brd-rd3" type="password" name="currentpassword" id="currentpassword" >
                                                            </div>

   <div class="col-md-12 col-sm-12 col-lg-12">
                                                               <label>New Password<sup>*</sup></label>
                                                               <input class="brd-rd3" type="password" id="newpassword" value="" name="newpassword"  >
                                                            </div>

   <div class="col-md-12 col-sm-12 col-lg-12">
                                                               <label>Confirm Password<sup>*</sup></label>
                                                               <input class="brd-rd3" type="password" id="confirmpassword" value="" name="confirmpassword"  >
                                                            </div>


                      
                                                         <div class="col-md-12 col-sm-12 col-lg-12">
                                <button class="red-bg brd-rd3" type="submit" name="changepassword">Change Password</button>
                            </div>
                                                        </form>
                                       </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-settings">
                                       <div class="tabs-wrp account-settings brd-rd5">
                                          <h4 itemprop="headline">My Profile</h4>
                                          <div class="account-settings-inner">
                                             <div class="row">
                                     

<?php
$pid=$_SESSION['fosuid'];
$ret=mysqli_query($con,"select * from tbluser where ID='$pid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>    
<form method="post" class="profile-info-form" enctype="multipart/form-data">
                                                <div class="col-md-12 col-sm-12 col-lg-12">
                                                   <div class="profile-info-form-wrap">
                                                      <form class="profile-info-form" enctype="multipart/form-data" >
                                                         <div class="row mrg20">
                                                            <div class="col-md-12 col-sm-12 col-lg-12">
                                                               <label>First Name<sup>*</sup></label>
                                                               <input class="brd-rd3" type="text" value="<?php  echo $row['FirstName'];?>" id="firstname" name="firstname" required="true">
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-lg-12">
                                                               <label>Last Name <sup>*</sup></label>
                                                               <input class="brd-rd3" type="text" value="<?php  echo $row['LastName'];?>" id="lastname" name="lastname" required="true">
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-lg-12">
                                                               <label>Email address <sup>*</sup></label>
                                                               <input class="brd-rd3" type="text" name="email" value="<?php  echo $row['Email'];?>" readonly="true">
                                                            </div>

                                                            <div class="col-md-12 col-sm-12 col-lg-12">
                                                               <label>Profile <sup></sup></label>
                                                               <input class="brd-rd3" type="file" name="profile">
                                                            </div>
                                                      
                                                            <div class="col-md-6 col-sm-6 col-lg-6">
                                                               <label>Mobile Number <sup>*</sup></label>
                                                               <input class="brd-rd3" type="text" id="mobilenumber" name="mobilenumber" value="<?php echo $row['MobileNumber'];?>" readonly="true">
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-lg-6">
                                                               <label>Registraton Date </label>
                                                               <input class="brd-rd3" type="text" name="regdate" value="<?php  echo $row['RegDate'];?>" readonly="true">
                                                            </div>
                                                            
                                                      
                                                         <div class="col-md-12 col-sm-12 col-lg-12">
                                <button class="red-bg brd-rd3" type="submit" name="updateprofile">Update Profile</button>
                            </div>
                                                         </div>
                                                      </form>
                                                   </div>
                                                </div>
</form>
                                            <?php } ?>
                            
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Section Box -->
                  </div>
               </div>
            </div>
         </div>
      </section>
      <?php include_once('footer.php'); ?>
      </main>
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/plugins.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
      <script src="assets/js/google-map-int.js"></script>
      <script src="../../www.google.com/recaptcha/api.js"></script>
      <script src="assets/js/main.js"></script>
   </body>
</html>
<?php //} ?>