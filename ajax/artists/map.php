<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include_once '../../session.php';
$payload = json_decode($_REQUEST['data']);
$user = $payload[0];
$asset = $payload[1];
// echo $name;
if($user!="" && $asset!="") {
    $mappingid = substr(md5(microtime()), 0, 12);
    while(mysqli_num_rows(mysqli_query($con, "SELECT id FROM asset_mapping WHERE mappingid='$mappingid'"))>0) {
        $mappingid = substr(md5(microtime()), 0, 12);
    }
    $insertSQL = "INSERT INTO asset_mapping (mappingid, userid, assetid) VALUES ('$mappingid', '$user', '$asset')";
    $checkRow = mysqli_num_rows(mysqli_query($con, "SELECT * FROM asset_mapping WHERE userid='$userid' AND assetid='$assetid'"));
    if ($checkRow == 0){
        if (mysqli_query($con, $insertSQL)) {
            echo makeJSON(200, "Mapping added");
        } else {
            echo makeJSON(203, mysqli_error($con));
        }
    } else {
        echo makeJSON(203, "Author name is empty");
    }
} else {
    echo makeJSON(203, "Author name is empty");
}
?>