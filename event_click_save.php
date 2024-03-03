<?php
global $dbh;
require("connection.php");
require("query.php");
echo "Clicked outside of the div!";

$content = $_POST['content'];
$user_login = $_POST['login'];

//MininoteUser::createNote($dbh, $user_login, $content);


?>