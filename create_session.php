<?php
session_start();

//if (!isset($_SESSION['user_id'])) {
//    $_SESSION['user_id'] = uniqid();
//    $_SESSION['username'] = 'John Doe';
//}

if(!isset($_SESSION['initiated'])){
    session_regenerate_id();
    $_SESSION['initiated'] = true;
    $_SESSION['note_number'] = 0;
    $_SESSION['isNote'] = false;
}

// Output a response
echo json_encode(array(
    'initiated' => $_SESSION['initiated'],
    'note_number' => $_SESSION['note_number'],
));
?>