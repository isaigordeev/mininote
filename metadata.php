<?php
session_start();

$metadata = $_SESSION['login'];
// Output metadata as JSON
echo $metadata;
?>
