<?php
session_start();
include_once('includes/dbconnection.php');
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['submit'])) {

        $guest = preg_replace("#[^0-9]#", "", $_POST['guest']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $phone = preg_replace("#[^0-9]#", "", $_POST['phone']);
        $date_res = htmlentities($_POST['date_res'], ENT_QUOTES, 'UTF-8');
        $time = htmlentities($_POST['time'], ENT_QUOTES, 'UTF-8');
        $suggestions = htmlentities($_POST['suggestions'], ENT_QUOTES, 'UTF-8');

        if ($guest != "" && $email && $phone != "" && $date_res != "" && $time != "" && $suggestions != "") {

            $check = $con->query("SELECT * FROM reservation WHERE no_of_guest='$guest' AND email='$email' AND phone='$phone' AND date_res='$date_res' AND time='$time' LIMIT 1");

            if ($check->num_rows) {

                $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>You have already placed a reservation with the same information</p>";

            } else {

                $insert = $con->query("INSERT INTO reservation(no_of_guest, email, phone, date_res, time, suggestions) VALUES('$guest', '$email', '$phone', '$date_res', '$time', '$suggestions')");

                if ($insert) {

                    $ins_id = $con->insert_id;
                    $reserve_code = "UNIQUE_" . $ins_id . substr($phone, 3, 8);

                    // 🔄 Save reservation code in DB
                    $con->query("UPDATE reservation SET reservation_code = '$reserve_code' WHERE id = $ins_id");

                    $msg = "<p style='padding: 15px; color: green; background: #eeffee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Reservation placed successfully. Your reservation code is <strong>$reserve_code</strong>. Please Note that reservation expires after one hour</p>";

                } else {
                    $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Could not place reservation. Please try again</p>";
                }

            }

        } else {
            $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Incomplete form data or Invalid data type</p>";
        }
    }
}
?>

<head>
  
    <title>Shahi Punjabi Restaurant | Book a table</title>
 
</head>
	
<title>ELIAM</title>

<link rel="stylesheet" href="css/main.css" />

<script src="js/jquery.min.js" ></script>

<script src="js/myscript.js"></script>
	
</head>

 
<?php include_once('header.php');?>

<section>
    <div class="block">
        <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
        <div class="page-title-wrapper text-center">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="page-title-inner">
                    <h1 itemprop="headline">BOOK A TABLE</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="parallax" onclick="remove_class()">
	
	<div class="parallax_head">
		
		<h2>Reserve</h2>
		<h3>Table Space</h3>
		
	</div>
	
</div>

<div class="content" onclick="remove_class()">
	
	<div class="inner_content">
		
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="hr_book_form">
			
			<h2 class="form_head"><span class="book_icon">BOOK A TABLE</span></h2>
            <p align="right" class="form_slg">We offer you the best reservation services</p>
			
			<?php echo "<br/>".$msg; ?>
			
			<div class="left">
				
				<div class="form_group">
					 
					 <label>No of Guest</label>
					<input type="number" placeholder="How many guests" min="1" name="guest" id="guest" required>
					
				</div>
				
				<div class="form_group">
					
					<label>Email</label>
					<input type="email" name="email" placeholder="Enter your email" required>
					
				</div>
				
				<div class="form_group">
					
					<label>Phone Number</label>
					<input type="text" name="phone" placeholder="Enter your phone number" required>
					
				</div>
				


                <div class="form_group">

                    <label>Date</label>

                    <input type="text" class="form-control datepicker" name="date_res" autocomplete="off">

				</div>
				
				<div class="form_group">
					
					<label>Time</label>
					<input type="time" name="time" placeholder="Select time for booking" required>
					
				</div>
				
				
			</div>
			
			<div class="left">
				
				<div class="form_group">
					
                    <label>Suggestions <small><b>(E.g No of Plates, How you want the setup to be)</b></small></label>
					<textarea name="suggestions" placeholder="your suggestions" required></textarea>
					
				</div>
				
				<div class="form_group">
					
                <?php if($_SESSION['fosuid']==""){?>
                    <br>
                                                <a class="btn pull-left red-bg brd-rd3" href="login.php" style="color:white;" title="Login">Make Your Booking</a>
                                                <?php } else {?>
                                                    <!-- <br> -->
                                                    <input type="submit" class="submit" name="submit" value="MAKE YOUR BOOKING" />
                                                <?php } ?>
					<!-- <input type="submit" class="submit" name="submit" value="MAKE YOUR BOOKING" /> -->
					
				</div>
				
			</div>
			
			<p class="clear"></p>
			
		</form>
		
	</div>
	
</div>


<?php include_once('footer.php');
include_once('includes/signin.php');
include_once('includes/signup.php');
?>
</main> 

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>

	
</body>

</html>