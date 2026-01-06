<?php 
session_start();
include_once('includes/dbconnection.php');
include_once('header.php');
    $email = $_GET['email'];
    $token = $_GET['token'];
try {
if(isset($_GET['email']) && isset($_GET['token'])) {
    $sql = "SELECT * FROM tbluser WHERE Email = '$email' AND token = '$token'";
    $count = $con->query($sql);
    $r = mysqli_fetch_assoc($count);
    echo $r['email'];
    if ($count->num_rows == 1) {
        if ($r['status'] == 'Inactive') {
            $update = "UPDATE tbluser SET status = 'Active' WHERE Email = '$email'";
            if ($con->query($update)) {
                ?>
                    <script>alert("Account Verification Successful");</script>
                <?php

                // setcookie('success', 'Account Verification Successful', time() + 5, '/');
            } else {
                ?>
                    <script>alert("Error in verifying email");</script>
                <?php
                // setcookie('error', 'Error in verifying email', time() + 5, '/');
            }
        } else {
            ?>
                <script>alert("Already verified");</script>
            <?php
            // setcookie('success', 'Email already verified', time() + 5, '/');
        }
    } else {
        ?>
            <script>alert("Account not found");</script>
        <?php
        // setcookie('error', 'Email not registered', time() + 5, '/');
    }
}
} catch (\Throwable $th) {
}

?>
<script>window.location.href = "login.php";</script>