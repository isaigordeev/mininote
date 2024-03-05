<?php
session_start();

global $dbh;
global $_SESSION;
require("connection.php");
require("query.php");
echo "Privée!";

$user_login = $_SESSION['login'];
$current_note = $_SESSION['currentNote'];
//$note_name = "Untitled";


MininoteUser::makeNotePrivate($dbh, $user_login, $current_note);

?>