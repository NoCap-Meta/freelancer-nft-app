<?php
function openseaParser($con){
    $row = mysqli_query($con, "SELECT * FROM assets WHERE opensea!=''");
    while($r = mysqli_fetch_assoc($row)){
        $assetid = $r['assetid'];
        $full_url = $r['opensea'];
        $url = explode("/", $full_url);
        $contract = $url[5];
        $token = $url[6]; 
        $updateSql = "UPDATE assets SET contract='$contract', token='$token' WHERE assetid='$assetid'";
        mysqli_query($con, $updateSql);
    }
}
