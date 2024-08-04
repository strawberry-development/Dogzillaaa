<?php
session_start();

if (isset($_SESSION['blockchain'])) {
    $blockchain = $_SESSION['blockchain'];

    $fileName = 'blockchain_' . date('Y-m-d_H-i-s') . '.dat';
    $filePath = '../archives/' . $fileName;

    if (file_put_contents($filePath, $blockchain) !== false) {
        $message = "Blockchain has been archived successfully.";
    } else {
        $message = "Failed to archive the blockchain. Please try again.";
    }
} else {
    $message = "No blockchain data found to archive.";
}

header("Location: ../views/index.php?message=" . urlencode($message));
exit();