<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    echo '<p>Invalid confession ID.</p>';
    return;
}

$confessionStmt = $conn->prepare("SELECT id, content, created_at FROM confessions WHERE id = ?");
$confessionStmt->bind_param('i', $id);
$confessionStmt->execute();
$confessionResult = $confessionStmt->get_result();
$confession = $confessionResult->fetch_assoc();
$confessionStmt->close();

if (!$confession) {
    echo '<p>Confession not found.</p>';
    return;
}

$countsSql = "SELECT
    SUM(CASE WHEN reaction = 'like' THEN 1 ELSE 0 END) AS likes_count,
    SUM(CASE WHEN reaction = 'dislike' THEN 1 ELSE 0 END) AS dislikes_count
FROM reactions
WHERE confession_id = ?";
$countsStmt = $conn->prepare($countsSql);
$countsStmt->bind_param('i', $id);
$countsStmt->execute();
$countsResult = $countsStmt->get_result();
$counts = $countsResult->fetch_assoc();
$countsStmt->close();

$commentsStmt = $conn->prepare("SELECT id, comment, created_at FROM comments WHERE confession_id = ? ORDER BY created_at ASC");
$commentsStmt->bind_param('i', $id);
$commentsStmt->execute();
$commentsResult = $commentsStmt->get_result();
?>
<h1>Confession details</h1>
<p><a href="index.php?page=confessions">Back to list</a></p>
<article>
    <p><?php echo nl2br(htmlspecialchars($confession['content'])); ?></p>
    <small>Posted at <?php echo htmlspecialchars($confession['created_at']); ?></small>
    <div>
        Likes: <?php echo (int) $counts['likes_count']; ?>
        | Dislikes: <?php echo (int) $counts['dislikes_count']; ?>
    </div>
</article>

<section>
    <h2>React</h2>
    <form method="post" action="actions/react.php">
        <input type="hidden" name="confession_id" value="<?php echo $id; ?>">
        <button type="submit" name="reaction" value="like">Like</button>
        <button type="submit" name="reaction" value="dislike">Dislike</button>
    </form>
</section>

<section>
    <h2>Comments</h2>
    <?php if ($commentsResult && $commentsResult->num_rows > 0): ?>
        <ul>
            <?php while ($comment = $commentsResult->fetch_assoc()): ?>
                <li>
                    <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                    <br>
                    <small><?php echo htmlspecialchars($comment['created_at']); ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No comments yet.</p>
    <?php endif; ?>
</section>

<section>
    <h2>Add Comment</h2>
    <form method="post" action="actions/add_comment.php">
        <input type="hidden" name="confession_id" value="<?php echo $id; ?>">
        <textarea name="comment" rows="4" cols="50" required></textarea>
        <br>
        <button type="submit">Submit comment</button>
    </form>
</section>
