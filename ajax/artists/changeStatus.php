<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include_once '../../session.php';
$payload = json_decode($_REQUEST['data']);
$mappingid = $payload[0];
$field = $payload[1];
$value = $payload[2];
$updateSql = "UPDATE asset_mapping SET $field = $value WHERE mappingid='$mappingid'";
if (mysqli_query($con, $updateSql)) {
    echo makeJSON(200, "Updated");
} else {
    echo makeJSON(203, "Remapping failed. Contact system administrator");
}
