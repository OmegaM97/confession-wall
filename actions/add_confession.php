<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?page=add_confession');
    exit;
}

$content = trim($_POST['content'] ?? '');
if ($content === '') {
    header('Location: ../index.php?page=add_confession');
    exit;
}

$stmt = $conn->prepare('INSERT INTO confessions (content) VALUES (?)');
$stmt->bind_param('s', $content);
$stmt->execute();
$stmt->close();

header('Location: ../index.php?page=confessions');
exit;
