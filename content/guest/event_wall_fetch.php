<?php

session_start();
global $dbh;
require("connection.php");
require("query.php");

//$user_login = $_POST['login'];
$user_login = $_SESSION["login"];
//$user_login = "isai";
//var_dump($_SESSION);

echo json_encode(MininoteUser::getPublic($dbh), true);
?>
