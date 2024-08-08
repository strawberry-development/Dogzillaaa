<?php
require_once '../classes/Blockchain.php';

session_start();

if (!isset($_SESSION['blockchain'])) {
    $blockchain = new Blockchain();
    $_SESSION['blockchain'] = serialize($blockchain);
} else {
    $blockchain = unserialize($_SESSION['blockchain']);
}

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dogzillaaa</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/logo/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/logo/favicon-16x16.png">
    <link rel="manifest" href="../assets/img/logo/site.webmanifest">
</head>
<body>
<header>
    <h1>Dogzillaaa</h1>
</header>

<!-- Display message -->
<?php if ($message): ?>
    <div class="message-container">
        <p class="message"><?php echo $message; ?></p>
    </div>
<?php endif; ?>

<main>
    <section class="links-section">
        <a href="../controllers/verify_block.php">Verify Blockchain</a>
        <a href="../controllers/reset_blockchain.php" class="reset-button">Reset Blockchain</a>
        <a href="../controllers/archive_blockchain.php" class="archive-button">Archive Blockchain</a>
    </section>
    <section id="blockchain">
        <?php foreach ($blockchain->getChain() as $block): ?>
            <div class="block">
                <p><strong>Index:</strong> <?php echo $block->index; ?></p>
                <p><strong>Timestamp:</strong> <?php echo date('Y-m-d H:i:s', $block->timestamp); ?></p>
                <p><strong>Data:</strong> <?php echo htmlspecialchars(json_encode($block->data)); ?></p>
                <p><strong>Previous Hash:</strong> <?php echo htmlspecialchars($block->previousHash); ?></p>
                <p><strong>Hash:</strong> <?php echo htmlspecialchars($block->hash); ?></p>
                <p><strong>Nonce:</strong> <?php echo htmlspecialchars($block->nonce); ?></p>
                <p><strong>Elo Reward:</strong> <?php echo htmlspecialchars($block->eloReward); ?></p>
            </div>
        <?php endforeach; ?>
    </section>

    <section class="form-section">
        <form action="../controllers/generate_block.php" method="post">
            <input type="text" name="data" placeholder="Enter data" required>
            <button type="submit">Generate Block</button>
        </form>
    </section>
</main>
</body>
</html>