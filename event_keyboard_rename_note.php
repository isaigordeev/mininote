<?php
session_start();

global $dbh;
global $_SESSION;
require("connection.php");
require("query.php");
//echo "Rename the note!";

$note_name = $_POST['note_name'];
$user_login = $_SESSION['login'];
$current_note = $_SESSION['currentNote'];
//$note_name = "Untitled";


//print_r($current_note);
//print_r($note_name);

echo MininoteUser::renameNote($dbh, $user_login, $current_note, $note_name);
//MininoteUser::modifyNote($dbh, $user_login, $note_name, $content);

?>