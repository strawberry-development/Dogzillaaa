<?php
require_once '../classes/Blockchain.php';

session_start();

if (!isset($_SESSION['blockchain'])) {
    $blockchain = new Blockchain();
} else {
    $blockchain = unserialize($_SESSION['blockchain']);
}

$isValid = $blockchain->isChainValid() ? "Valid" : "Invalid";

header('Location: ../views/verify.php?status=' . $isValid);