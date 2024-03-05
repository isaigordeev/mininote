<?php
session_start();

if(!isset($_SESSION['initiated'])){
    session_regenerate_id();
    $_SESSION['initiated'] = true;
    $_SESSION['note_number'] = 0;
    $_SESSION['isNote'] = false;
}

echo json_encode(array(
    'initiated' => $_SESSION['initiated'],
    'note_number' => $_SESSION['note_number'],
));
?>