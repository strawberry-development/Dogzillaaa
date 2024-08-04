<?php
require_once '../classes/Blockchain.php';

session_start();

if (!isset($_SESSION['blockchain'])) {
    $blockchain = new Blockchain();
} else {
    $blockchain = unserialize($_SESSION['blockchain']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];
    $newBlock = new Block(count($blockchain->chain), strtotime("now"), ["data" => $data]);
    $blockchain->addBlock($newBlock);

    $_SESSION['blockchain'] = serialize($blockchain);
}

header('Location: ../index.php');