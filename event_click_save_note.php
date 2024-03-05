<?php
global $dbh;
require("connection.php");
require("query.php");
echo "Clicked outside of the div!";

$content = $_POST['content'];
$user_login = $_SESSION['login'];
$note_name = "Untitled";

//MininoteUser::createNote($dbh, $user_login, $note_name, $content);

?>