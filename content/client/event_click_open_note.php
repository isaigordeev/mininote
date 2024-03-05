<?php
session_start();
echo "Taped outside of the div!";

global $dbh;
global $_SESSION;
require("connection.php");
require("query.php");
echo "Create a new note!";

$user_login = $_SESSION['login'];
$note_name = "Untitled";
$content = "";


$metadata_user = MininoteUserMetaData::getUserMetaData($dbh, $user_login);

echo MininoteUser::openNote($dbh, $user_login, $note_name);

?>
