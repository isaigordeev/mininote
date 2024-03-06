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


//$query = "SELECT name FROM `notes` WHERE name LIKE 'Untitled%' AND `user_id` = '$metadata_user->user_id'";
//
//$stmt = $dbh->prepare($query);
//$stmt->execute();
//
//$existingUntitledFiles = $stmt->fetchAll(PDO::FETCH_COLUMN);
//
//var_dump($existingUntitledFiles);
//
//$newUntitledNumber = 1;
//foreach ($existingUntitledFiles as $untitledFile) {
//    $number = intval(substr($untitledFile, 9)); // Extract the number part of the untitled file name
//    if ($number === $newUntitledNumber) {
//        $newUntitledNumber++; // If the current number matches the expected number, increment the expected number
//    } else {
//        break; // If there's a gap in the sequence, stop searching
//    }
//}
//
//$newUntitledTitle = "Untitled" . $newUntitledNumber;
//
//$note_name = $newUntitledTitle;

$dirsArray = json_decode($path, true);
//var_dump($dirsArray);

//if ($dirsArray !== null) {
//$untitledCount = 0;
//
//foreach ($dirsArray as $dir) {
//    if (strpos($dir, 'Untitled') !== false) {
//        $untitledCount++;
//    }
//}
//    $note_name = $note_name . ($untitledCount+1);
//}
//echo $note_name;


if ($dirsArray !== null) {
    $untitledNumbers = array();

    // Extract numbers from filenames starting with "Untitled"
    foreach ($dirsArray as $dir) {
        if (preg_match('/Untitled(\d+)/', $dir, $matches)) {
            $untitledNumbers[] = intval($matches[1]);
        }
    }

    // Find the lowest missing number
    $missingNumber = 1;
    while (in_array($missingNumber, $untitledNumbers)) {
        $missingNumber++;
    }

    $note_name .= 'Untitled' . $missingNumber;
}

//echo $note_name;


MininoteUser::createNote($dbh, $user_login, $note_name, $content);

echo $note_name;

?>
