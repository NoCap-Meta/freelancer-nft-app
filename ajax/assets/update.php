<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include_once '../../session.php';
$payload = json_decode($_REQUEST['data']);
$assetid = $payload[0];
$assetTitle = $payload[1];
$assetPrice = $payload[2];
$assetBody = mysqli_real_escape_string($con, $payload[3]);
$tags = $payload[4];
$tags = json_encode($tags, true);
$updateSql = "UPDATE assets SET title = '$assetTitle', price = '$assetPrice', body = '$assetBody', tags = '$tags' WHERE assetid='$assetid'";
if (mysqli_query($con, $updateSql)) {
    echo makeJSON(200, "Updated");
} else {
    echo makeJSON(203, "Remapping failed. Contact system administrator");
}
