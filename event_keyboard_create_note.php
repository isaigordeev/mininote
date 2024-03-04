<?php
echo "Taped outside of the div!";

global $dbh;
global $_SESSION;
require("connection.php");
require("query.php");
echo "Create a new note!";

$user_login = $_POST['login'];
$note_name = "Untitled";
$content = "";

$_SESSION["isNote"] = true;


$metadata_user = MininoteUserMetaData::getUserMetaData($dbh, $user_login);
$path = $metadata_user->dirs;
print_r($path);

MininoteUser::createNote($dbh, $user_login, $note_name, $content);

?>
