<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include_once '../../session.php';
$payload = json_decode($_REQUEST['data']);
$assetid = $payload[0];
$about = mysqli_real_escape_string($con, $payload[1]);
$authorid = mysqli_fetch_assoc(mysqli_query($con, "SELECT authorid FROM assets WHERE assetid='$assetid'"))["authorid"];
$updateSql = "UPDATE authors SET about = '$about' WHERE authorid='$authorid'";
if (mysqli_query($con, $updateSql)) {
    echo makeJSON(200, "Updated");
} else {
    echo makeJSON(203, "Remapping failed. Contact system administrator");
}
