<?php
session_start();

global $dbh;
require("connection.php");
require("query.php");
echo "Save the note!";

$content = $_POST['content'];
$user_login = $_SESSION['login'];
$note_name = "Untitled_saved";


$metadata_user = MininoteUserMetaData::getUserMetaData($dbh, $user_login);
$path = $metadata_user->dirs;
print_r($path);

MininoteUser::createNote($dbh, $user_login, $note_name, $content);
//MininoteUser::createNote($dbh, $user_login, $note_name, $content);

?>