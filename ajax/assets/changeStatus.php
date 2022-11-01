<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include_once '../../session.php';
$payload = json_decode($_REQUEST['data']);
$assetid = $payload[0];
$field = $payload[1];
$value = $payload[2];
$updateSql = "UPDATE assets SET status = $value WHERE assetid='$assetid'";
if (mysqli_query($con, $updateSql)) {
    echo makeJSON(200, "Updated");
} else {
    echo makeJSON(203, "Remapping failed. Contact system administrator");
}
