<?php
session_start();
global $dbh;
require("connection.php");
require("query.php");

//$user_login = $_POST['login'];
$user_login = $_SESSION["login"];
//$user_login = "isai";
$metadata_user = MininoteUserMetaData::getUserMetaData($dbh, $user_login);
//var_dump($_SESSION);
$path = $metadata_user->dirs;

$arrayData = json_decode($path, true);
echo $path;
?>