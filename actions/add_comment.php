<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?page=confessions');
    exit;
}

$confession_id = isset($_POST['confession_id']) ? (int) $_POST['confession_id'] : 0;
$comment = trim($_POST['comment'] ?? '');

if ($confession_id <= 0 || $comment === '') {
    header('Location: ../index.php?page=confession&id=' . $confession_id);
    exit;
}

$stmt = $conn->prepare('INSERT INTO comments (confession_id, comment) VALUES (?, ?)');
$stmt->bind_param('is', $confession_id, $comment);
$stmt->execute();
$stmt->close();

header('Location: ../index.php?page=confession&id=' . $confession_id);
exit;
