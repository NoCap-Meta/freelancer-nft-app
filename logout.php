<?php
if(!isset($_SESSION)) { 
    session_start();    
} 
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
session_destroy();

$action = $_REQUEST['action'];
$path = "/login";
if ($action != ""){
    $path .= "?action=".$action;
}

header("location: $path");
?>