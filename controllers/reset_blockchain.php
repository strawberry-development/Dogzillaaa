<?php
session_start();

if (isset($_SESSION['blockchain'])) {
    unset($_SESSION['blockchain']);

    $message = "Blockchain has been reset successfully.";
} else {
    $message = "No blockchain data found to reset.";
}

header("Location: ../views/index.php?message=" . urlencode($message));
exit();