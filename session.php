<?php
// error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once 'global/connect.php';

// debug_backtrace() || die (header("location: logout.php"));
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
if(!isset($_SESSION)) { 
    session_start();
    // echo "Started";    
} else {
    // echo "Running";
}
// $userid = $_SESSION['userid'];
// echo $userid;
$userid = "h788hh7887h";
// $userid = $_SESSION['userid'];
$_SESSION['userid'] = $userid;

if ($userid != "") {
    $user = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users WHERE userid='$userid'"));
    $_SESSION['admin'] = $user['admin'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['verified'] = $user['verified'];    
    $_SESSION['balance'] = $user['balance'];
    $_SESSION['credit'] = $user['credit'];
    $_SESSION['active'] = $user['active'];

    
    if ($_SESSION['active'] != 1) {
        header("location: /logout.php?action=suspended");
    }
    if ($_SESSION['verified'] != 1) {
        header("location: /logout.php?action=verify");

    }
} else {
    header("location: /login");
}

