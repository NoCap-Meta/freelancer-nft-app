<?php
include_once '../../global/connect.php';

$mappingid = $_REQUEST['mappingid'];
$password = $_REQUEST['password'];

$userid = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM asset_mapping"))['userid'];
$password = password_hash($password, PASSWORD_BCRYPT);
$updateSql = "UPDATE accounts SET password='$password' WHERE userid='$userid'";
if (mysqli_query($con, $updateSql)) {
    echo makeJSON(200, "Password updated");
} else {
    echo makeJSON(203, "Password updation failed");
}
?>