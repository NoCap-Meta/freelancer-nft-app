<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include_once "../../session.php";
$payload = json_decode($_REQUEST['data']);

$artistName = $payload[0];
$artistEmail = $payload[1];
$artistPass1 = $payload[2];
$artistPass2 = $payload[3];

if ($artistPass1==$artistPass2){
    $manager = ""; // Change it to $_SESSION['uid'] when session is setup
    $userid = substr(md5(microtime()), 0, 12);
    while(mysqli_num_rows(mysqli_query($con, "SELECT id FROM accounts WHERE userid='$userid'"))>0) {
        $userid = substr(md5(microtime()), 0, 12);
    }
    $password = password_hash($artistPass1, PASSWORD_BCRYPT);
    $insertSQL = "INSERT INTO accounts (userid, name, email, password, manager) VALUES ('$userid', '$artistName', '$artistEmail', '$password', '$manager')";

    $checkEmail = mysqli_num_rows(mysqli_query($con, "SELECT * FROM accounts WHERE email='$artistEmail'"));
    if ($checkEmail == 0) {
        if (mysqli_query($con, $insertSQL)){
            echo makeJSON(200, "Account created. Please map to the asset.");
        } else {
            echo makeJSON(203, "Account creation failed. Report to system administrator.");    
        }
    } else {
        echo makeJSON(203, "Account with the email already exists");
    }        
} else {
    echo makeJSON(203, "Passwords do not match");
}