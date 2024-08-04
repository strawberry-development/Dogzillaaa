<?php
// Start session to keep track of blockchain state
session_start();

// Initialize blockchain if it doesn't exist in session
if (!isset($_SESSION['blockchain'])) {
    require_once 'classes/Blockchain.php';
    $blockchain = new Blockchain();
    $_SESSION['blockchain'] = serialize($blockchain);
}

// Redirect to the main view
header('Location: views/index.php');
exit();