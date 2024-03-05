<?php
session_start();

global $dbh;
global $_SESSION;

require("connection.php");
require("query.php");

$content = $_POST['content'];
$note_name = $_SESSION['currentNote'];
//$note_name = $_POST['note_name'];

$user_login = $_SESSION['login'];
//$note_name = "Untitled";


echo ($content);
echo ($note_name);
echo $user_login;

MininoteUser::modifyNote($dbh, $user_login, $note_name, $content);
?>