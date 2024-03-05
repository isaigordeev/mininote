<?php
session_start();

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    // If user is logged in, return session data
    $sessionData = array(
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'loggedin' => true
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
