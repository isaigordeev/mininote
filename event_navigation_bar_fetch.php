<?php
global $dbh;
global $_SESSION;
require("connection.php");
require("query.php");

//$user_login = $_POST['login'];
$user_login = "isai";
$note_name = "Untitled";
$content = "";

$metadata_user = MininoteUserMetaData::getUserMetaData($dbh, $user_login);
$path = $metadata_user->dirs;

//$arrayData = json_decode($path, true);
//$jsonData = json_encode($arrayData);

//print_r(gettype($jsonData));

echo $path;
?>