<?php
session_start();
//echo "Taped outside of the div!";

global $dbh;
global $_SESSION;
require("connection.php");
require("query.php");
echo "Delete a note!";

$user_login = $_SESSION['login'];
$currentNote = $_SESSION['currentNote'];

$metadata_user = MininoteUserMetaData::getUserMetaData($dbh, $user_login);
$path = $metadata_user->dirs;



MininoteUser::deleteNote($dbh, $user_login, $currentNote);
?>
