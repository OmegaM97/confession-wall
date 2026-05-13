<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?page=confessions');
    exit;
}

$confession_id = isset($_POST['confession_id']) ? (int) $_POST['confession_id'] : 0;
$reaction = $_POST['reaction'] ?? '';

if ($confession_id <= 0 || !in_array($reaction, ['like', 'dislike'], true)) {
    header('Location: ../index.php?page=confession&id=' . $confession_id);
    exit;
}

$stmt = $conn->prepare('INSERT INTO reactions (confession_id, reaction) VALUES (?, ?)');
$stmt->bind_param('is', $confession_id, $reaction);
$stmt->execute();
$stmt->close();

header('Location: ../index.php?page=confession&id=' . $confession_id);
exit;
