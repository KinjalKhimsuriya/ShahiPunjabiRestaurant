<?php
include_once('includes/dbconnection.php');

if (isset($_GET['email1'])) {
    $email = $_GET['email1'];
    $q = "SELECT * FROM `tbluser` WHERE `email`='$email'";
    $result = $con->query($q);
    if ($result->num_rows > 0) {
        echo 'true';
    } else {
        echo 'false';
    }
}
