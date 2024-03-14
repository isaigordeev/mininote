<?php

global $dbh;
require("connection.php");
require("query.php");
echo "Make all public!";

$user_login = $_POST['login'];
MininoteUser::makeAllPublic($dbh, $user_login);

?>