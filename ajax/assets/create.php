<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include_once '../../session.php';
$payload = json_decode($_REQUEST['data']);
$assetImg = $payload[0];
$assetid = $payload[1];
$assetTitle = $payload[2];
$assetPrice = $payload[3];
$assetQty = $payload[4];
$assetBody = mysqli_real_escape_string($con, $payload[5]);
$assetTags = json_encode($payload[6]);
$authorid = $payload[7];

$assetid = substr(md5(microtime()), 0, 12);
while(mysqli_num_rows(mysqli_query($con, "SELECT id FROM assets WHERE assetid='$assetid'"))>0) {
  $assetid = substr(md5(microtime()), 0, 12);
}
if(mysqli_num_rows(mysqli_query($con, "SELECT id FROM authors WHERE authorid='$authorid'")) > 0){
  $insertSql = "INSERT INTO assets (assetid, authorid, image, title, price, currency, qty, body, tags) VALUES ('$assetid', '$authorid', '$assetImg', '$assetTitle', '$assetPrice', 'INR', '$assetQty', '$assetBody', '$assetTags')";
  // echo $insertSql;
  if (mysqli_query($con, $insertSql)){
    echo makeJSON(200, $assetid);
  } else {
    echo makeJSON(203, "Asset could not be added");
  }
} else {
  echo makeJSON(203, "Invalid Author Account Mapping");
}
