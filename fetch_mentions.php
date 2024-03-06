<?php

session_start();
global $dbh;
require("connection.php");
require("query.php");

$user_login = $_SESSION["login"];
$currentNote = $_SESSION["currentNote"];

echo json_encode(MininoteUser::getMentions($dbh, $user_login, $currentNote), true);

?>