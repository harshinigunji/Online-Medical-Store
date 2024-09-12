<?php
session_start();
header('Content-Type: application/json');

$response = array('loggedIn' => false, 'username' => '');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $response['loggedIn'] = true;
    $response['username'] = $_SESSION['username'];
}

echo json_encode($response);
?>
