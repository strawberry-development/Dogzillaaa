<?php
require_once '../classes/Blockchain.php';

session_start();

if (!isset($_SESSION['blockchain'])) {
    $blockchain = new Blockchain();
} else {
    $blockchain = unserialize($_SESSION['blockchain']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = isset($_POST['data']) ? htmlspecialchars($_POST['data']) : '';

    if ($data) {
        $blockchain->addBlock($data);

        $_SESSION['blockchain'] = serialize($blockchain);
    }

    header('Location: ../index.php?message=Block added successfully');
    exit();
}

header('Location: ../index.php?message=Invalid request');
exit();