<?php
session_start();

require("connection.php");
require("query.php");
echo "Save the note!";

$content = $_POST['content'];
$note_name = $_POST['note_name'];
$user_login = $_SESSION['login'];
//$note_name = "Untitled";


$metadata_user = MininoteUserMetaData::getUserMetaData($dbh, $user_login);
$path = $metadata_user->dirs;
//print_r($path);
print_r($content);
print_r($note_name);

MininoteUser::modifyNote($dbh, $user_login, $note_name, $content);
//MininoteUser::createNote($dbh, $user_login, $note_name, $content);

?>