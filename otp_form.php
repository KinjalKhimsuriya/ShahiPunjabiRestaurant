<?php 
    include_once('includes/dbconnection.php');
    session_start();
    include_once('header.php'); 
?>
<section>
    <div class="block">
        <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
        <div class="page-title-wrapper text-center">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="page-title-inner">
                    <h1 itemprop="headline">OTP verification</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="bread-crumbs-wrapper">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
            <li class="breadcrumb-item">OTP verification </li>
        </ol>
    </div>
</div>

<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="container">
                <?php
                if (isset($_COOKIE['success'])) {
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> <?php echo " " . $_COOKIE['success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                if (isset($_COOKIE['error'])) {
                ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong><?php echo " " . $_COOKIE['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="panel panel-default otp-card">
                <div class="panel-body" style="padding: 30px;">
                    <h2 class="text-center" style="margin-bottom: 20px;">Enter OTP</h2>
                    <p class="text center">Please enter the verification code sent to your email</p>

                    <form action="otp_form.php" method="post">
                        <div class="form-group text-center" name="otp">
                            <input type="text" class="form-control otp-input" maxlength="1" autofocus oninput="moveToNext(this, 0)" name="otp1" style="display:inline-block; width:40px; text-align:center; margin: 0 5px;">
                            <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 1)" name="otp2" style="display:inline-block; width:40px; text-align:center; margin: 0 5px;">
                            <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 2)" name="otp3" style="display:inline-block; width:40px; text-align:center; margin: 0 5px;">
                            <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 3)" name="otp4" style="display:inline-block; width:40px; text-align:center; margin: 0 5px;">
                            <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 4)" name="otp5" style="display:inline-block; width:40px; text-align:center; margin: 0 5px;">
                            <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 5)" name="otp6" style="display:inline-block; width:40px; text-align:center; margin: 0 5px;">
                        </div>

                        <div class="text-danger text-center" id="otpError" style="margin-bottom: 15px;"></div>
                        <div id="timer" class="text-danger text-center" style="margin-bottom: 15px;"></div>

                        <div class="form-group text-center" name="otp">
                            <button type="button" id="resend_otp" class="btn red-bg btn-block" style="display:none; color:white;">Resend OTP</button>
                        </div>
                        <script>
                            
                            let timeLeft = 120; // Default timer value
                            const timerDisplay = document.getElementById('timer');
                            const resendButton = document.getElementById('resend_otp');

                            // Function to check if the user is refreshing or coming from another page
                            function isPageRefresh() {
                                return !!sessionStorage.getItem('otpTimer'); // If otpTimer exists, it's a refresh
                            }

                            // If the page is refreshed, use sessionStorage value
                            if (isPageRefresh()) {
                                timeLeft = parseInt(sessionStorage.getItem('otpTimer'), 10);
                            } else {
                                // If the user comes from another page, reset timer
                                sessionStorage.setItem('otpTimer', 120);
                                timeLeft = 120;
                            }

                            function startCountdown() {
                                resendButton.style.display = "none"; // Hide the button initially
                                timerDisplay.innerHTML = `Resend OTP in ${timeLeft} seconds`;

                                const countdown = setInterval(() => {
                                    if (timeLeft <= 0) {
                                        clearInterval(countdown);
                                        timerDisplay.innerHTML = "You can now resend the OTP.";
                                        resendButton.style.display = "inline";
                                        sessionStorage.removeItem('otpTimer'); // Clear sessionStorage after timer ends
                                    } else {
                                        timerDisplay.innerHTML = `Resend OTP in ${timeLeft} seconds`;
                                        timeLeft -= 1;
                                        sessionStorage.setItem('otpTimer', timeLeft); // Update sessionStorage
                                    }
                                }, 1000);
                            }

                            // Start countdown only if the timer is above 0
                            if (timeLeft > 0) {
                                startCountdown();
                            } else {
                                resendButton.style.display = "inline";
                                timerDisplay.innerHTML = "You can now resend the OTP.";
                            }

                            resendButton.onclick = function(event) {
                                event.preventDefault(); // Prevent default form submission
                                sessionStorage.setItem('otpTimer', 120); // Reset timer
                                window.location.href = 'resend_otp_forgot_password.php';
                            };
                        </script>
                        <button type="submit" class="btn red-bg btn-block" style="color:white;" name="otp_btn">Verify OTP</button>
                    </form>

                    <div class="text-center" style="margin-top: 15px;">
                        <a href="login.php" style="color:#0C3B2E;">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function moveToNext(input, index) {
        if (input.value.length === input.maxLength) {
            if (index < 5) {
                input.parentElement.children[index + 1].focus();
            }
        }
    }
</script>

<?php include 'footer.php';
if (isset($_POST['otp_btn'])) {
    // echo $_SESSION['forgot_email'];
    if (isset($_SESSION['forgot_email'])) {
        // echo $email;
        $email = $_SESSION['forgot_email'];
        $otp1 = $_POST['otp1'];
        $otp2 = $_POST['otp2'];
        $otp3 = $_POST['otp3'];
        $otp4 = $_POST['otp4'];
        $otp5 = $_POST['otp5'];
        $otp6 = $_POST['otp6'];

        $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;
        // echo $otp;

        // Fetch the OTP from the database for the given email
        $query = "SELECT otp FROM password_token WHERE email = '$email' ";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $db_otp = $row['otp'];
            if (!$db_otp) {
                setcookie('error', 'OTP has expired. Regenerate New OTP', time() + 5, '/');
?>
                <script>
                    window.location.href = 'forgot-password.php';
                </script>
                <?php
            }
            // Compare the OTPs
            else {
                if ($otp == $db_otp) {
                    // Redirect to new password page
                ?>
                    <script>
                        window.location.href = 'reset-password.php';
                    </script>
                <?php

                } else {
                    setcookie('error', 'Incorrect OTP', time() + 5, '/');
                ?>

                    <script>
                        window.location.href = 'otp_form.php';
                    </script>
            <?php
                }
            }
        } else {
            setcookie('error', 'OTP has expired. Regenerate New OTP', time() + 5, '/');
            ?>
            <script>
                window.location.href = 'forgot-password.php';
            </script>
<?php
        }
    }
}
?>