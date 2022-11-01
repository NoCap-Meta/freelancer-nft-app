<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include_once '../../session.php';
$payload = json_decode($_REQUEST['data']);
$name = $payload[0];
// echo $name;
if($name != "") {
    $authorid = substr(md5(microtime()), 0, 12);
    while(mysqli_num_rows(mysqli_query($con, "SELECT id FROM authors WHERE authorid='$authorid'"))>0) {
        $authorid = substr(md5(microtime()), 0, 12);
    }
    $insertSQL = "INSERT INTO authors (authorid, icon, name, about) VALUES ('$authorid', '', '$name', '')";
    if (mysqli_query($con, $insertSQL)) {
        echo makeJSON(200, "Artist Profile created successfully");
    } else {
        echo makeJSON(203, mysqli_error($con));
    }
} else {
    echo makeJSON(203, "Author name is empty");
}
?>