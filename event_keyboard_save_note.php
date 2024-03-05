<?php

global $dbh;
global $_SESSION;
require("connection.php");
require("query.php");
echo "Create a note!";

$content = $_POST['content'];
$user_login = $_SESSION['login'];
$note_name = "Untitled2";

echo $_SESSION;


$metadata_user = MininoteUserMetaData::getUserMetaData($dbh, $user_login);
$path = $metadata_user->dirs;
print_r($path);

MininoteUser::createNote($dbh, $user_login, $note_name, $content);
//MininoteUser::createNote($dbh, $user_login, $note_name, $content);

?>