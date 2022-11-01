<?php
include 'global/connect.php';
$payload = json_decode($_REQUEST['data']);
$email = $payload[0];
$password = $payload[1];
if (!is_writable(session_save_path())) {
    echo 'Session path "'.session_save_path().'" is not writable for PHP!'; 
}
if ($_SESSION['userid']!=""){
    header("location: /logout");
}
$user = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
if (mysqli_num_rows($user) > 0) {
    $user = mysqli_fetch_assoc($user);
    $hashed_password = $user['password'];   
    if ($password==$user['password']) {
        if(!isset($_SESSION)) { 
            session_start();    
        } 
        $userid = mysqli_fetch_assoc(mysqli_query($con, "SELECT userid FROM users WHERE email='$email'"))['userid'];
        $_SESSION['userid'] = $userid;
        // echo $_SESSION['userid'];
        echo makeJSON(200, "Logged in successfull");
    } else {
        echo makeJSON(203, "Password is incorrect");
        increaseRisk(2);    
    }
} else {
    echo makeJSON(203, "User not found");
    increaseRisk(1);
}
