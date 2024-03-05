<?php

global $dbh;
require("connection.php");
require("query.php");
echo "Delete a note!";

$user_login = $_POST['login'];
MininoteUser::deleteNotes($dbh, $user_login);


?>