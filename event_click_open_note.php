<?php
session_start();

global $dbh;
global $_SESSION;
require("connection.php");
require("query.php");

$user_login = $_SESSION['login'];
$note_name = $_POST['note_name'];

echo MininoteUser::openNoteExtended($dbh, $user_login, $note_name);

?>
