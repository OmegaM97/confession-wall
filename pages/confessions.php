<?php
$sql = "SELECT c.id, c.content, c.created_at,
    COUNT(DISTINCT co.id) AS comments_count,
    SUM(CASE WHEN r.reaction = 'like' THEN 1 ELSE 0 END) AS likes_count,
    SUM(CASE WHEN r.reaction = 'dislike' THEN 1 ELSE 0 END) AS dislikes_count
FROM confessions c
LEFT JOIN comments co ON co.confession_id = c.id
LEFT JOIN reactions r ON r.confession_id = c.id
GROUP BY c.id
ORDER BY c.created_at DESC";
$result = $conn->query($sql);
?>
<h1>Confessions</h1>
<p><a href="index.php?page=add_confession">Add confession</a></p>
<?php if ($result && $result->num_rows > 0): ?>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <a href="index.php?page=confession&id=<?php echo (int) $row['id']; ?>">
                    <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                </a>
                <div>
                    Comments: <?php echo (int) $row['comments_count']; ?>
                    | Likes: <?php echo (int) $row['likes_count']; ?>
                    | Dislikes: <?php echo (int) $row['dislikes_count']; ?>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No confessions found.</p>
<?php endif; ?>
