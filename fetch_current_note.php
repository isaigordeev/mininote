<?php
session_start();
echo $_POST['currentNote'];
echo "post cur note";
$_SESSION['currentNote'] = $_POST['currentNote'];

?>
