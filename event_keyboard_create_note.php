<?php
session_start();
//echo "Taped outside of the div!";

global $dbh;
global $_SESSION;
require("connection.php");
require("query.php");
//echo "Create a new note!";

$user_login = $_SESSION['login'];
$note_name = "Untitled";
$content = "";

$metadata_user = MininoteUserMetaData::getUserMetaData($dbh, $user_login);
$path = $metadata_user->dirs;

$dirsArray = json_decode($path, true);
//var_dump($dirsArray);

if ($dirsArray !== null) {
$untitledCount = 0;

foreach ($dirsArray as $dir) {
    if (strpos($dir, 'Untitled') !== false) {
        $untitledCount++;
    }
}
    $note_name = $note_name . ($untitledCount+1);
}


MininoteUser::createNote($dbh, $user_login, $note_name, $content);

echo $note_name;

?>
