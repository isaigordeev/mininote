<?php
session_start();

// Check if the user is logged in
if(isset($_SESSION['initiated'])) {
    // If user is logged in, return session data
    $sessionData = array(
        'initiated' => $_SESSION['initiated'],
        'note_number' => $_SESSION['note_number'],
        'login' => $_SESSION['login'],
        'loggedIn' => $_SESSION['loggedIn'],
    );
} else {
    // If user is not logged in, return empty session data
    $sessionData = array(
        'user_id' => null,
        'username' => null,
        'loggedin' => false
    );
}

// Output the session data as JSON
header('Content-Type: application/json');
echo json_encode($sessionData);
?>
