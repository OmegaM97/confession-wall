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

<div class="confession-detail-wrapper">
    <div class="confession-detail-container">
        <!-- Back Button -->
        <a href="index.php?page=confessions" class="back-btn">← Back to Confessions</a>

        <!-- Full Confession Card -->
        <article class="full-confession-card">
            <div class="confession-header">
                <div class="user-info">
                    <div class="avatar">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="user-details">
                        <div class="username">Anonymous</div>
                        <div class="timestamp"><?php echo htmlspecialchars($confession['created_at']); ?></div>
                    </div>
                </div>
            </div>

            <div class="confession-body">
                <p><?php echo nl2br(htmlspecialchars($confession['content'])); ?></p>
            </div>

            <!-- Reactions -->
            <div class="confession-reactions">
                <button class="reaction-btn like-btn" data-confession-id="<?php echo $id; ?>" data-reaction="like">
                    <span class="reaction-icon">👍</span>
                    <span class="reaction-count"><?php echo (int) $counts['likes_count']; ?></span>
                </button>
                <button class="reaction-btn dislike-btn" data-confession-id="<?php echo $id; ?>" data-reaction="dislike">
                    <span class="reaction-icon">👎</span>
                    <span class="reaction-count"><?php echo (int) $counts['dislikes_count']; ?></span>
                </button>
            </div>
        </article>

        <!-- Comments Section -->
        <section class="comments-section">
            <h2>Comments (<?php echo $commentsResult ? $commentsResult->num_rows : 0; ?>)</h2>
            
            <?php if ($commentsResult && $commentsResult->num_rows > 0): ?>
                <div class="comments-list">
                    <?php while ($comment = $commentsResult->fetch_assoc()): ?>
                        <div class="comment-card">
                            <div class="comment-header">
                                <div class="user-info">
                                    <div class="avatar-small">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="comment-author">Anonymous</div>
                                        <div class="comment-time"><?php echo time_elapsed_string($comment['created_at']); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-body">
                                <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="no-comments">No comments yet. Be the first to comment!</p>
            <?php endif; ?>
        </section>

        <!-- Add Comment Form -->
        <section class="add-comment-section">
            <h2>Add Your Comment</h2>
            <form method="post" action="actions/add_comment.php" class="comment-form">
                <input type="hidden" name="confession_id" value="<?php echo $id; ?>">
                <textarea name="comment" placeholder="Share your thoughts anonymously..." rows="4" required></textarea>
                <button type="submit" class="btn-submit">Post Comment</button>
            </form>
        </section>
    </div>
</div>

<style>
.confession-detail-wrapper {
  padding: 2rem 20px;
  max-width: 800px;
  margin: 2rem auto;
}

.confession-detail-container {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.back-btn {
  display: inline-block;
  color: var(--sky-blue);
  text-decoration: none;
  font-weight: 600;
  margin-bottom: 1rem;
  transition: all 0.3s ease;
}

.back-btn:hover {
  color: var(--dark-text);
  transform: translateX(-5px);
}

.full-confession-card {
  background: var(--white);
  border: 1px solid rgba(56, 189, 248, 0.1);
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 5px 20px rgba(56, 189, 248, 0.08);
}

.confession-body {
  margin: 1.5rem 0;
  font-size: 1.1rem;
  line-height: 1.8;
  color: var(--dark-text);
}

.comments-section {
  margin-top: 2rem;
}

.comments-section h2 {
  margin-bottom: 1.5rem;
}

.comments-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 2rem;
}

.comment-card {
  background: rgba(56, 189, 248, 0.05);
  border: 1px solid rgba(56, 189, 248, 0.1);
  border-radius: 12px;
  padding: 1.25rem;
}

.comment-header {
  display: flex;
  align-items: center;
  margin-bottom: 0.75rem;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.avatar-small {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: var(--gradient);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--white);
  flex-shrink: 0;
}

.comment-author {
  font-weight: 600;
  color: var(--dark-text);
}

.comment-time {
  font-size: 0.8rem;
  color: var(--soft-gray);
}

.comment-body {
  color: var(--dark-text);
  line-height: 1.6;
}

.no-comments {
  color: var(--soft-gray);
  font-style: italic;
}

.add-comment-section {
  background: var(--white);
  border: 1px solid rgba(56, 189, 248, 0.1);
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 5px 20px rgba(56, 189, 248, 0.08);
}

.comment-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.comment-form textarea {
  padding: 1rem;
  border: 1px solid rgba(56, 189, 248, 0.2);
  border-radius: 10px;
  font-family: inherit;
  font-size: 1rem;
  resize: vertical;
  color: var(--dark-text);
}

.comment-form textarea::placeholder {
  color: var(--soft-gray);
}

.btn-submit {
  background: var(--gradient);
  color: var(--white);
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 1rem;
}

.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(56, 189, 248, 0.3);
}

@media (max-width: 480px) {
  .confession-detail-wrapper {
    padding: 1rem 15px;
  }

  .full-confession-card,
  .add-comment-section {
    padding: 1.5rem;
  }

  .confession-body {
    font-size: 1rem;
  }
}
</style>

<script>
document.querySelectorAll('.reaction-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const confessionId = this.dataset.confessionId;
        const reaction = this.dataset.reaction;
        
        this.classList.add('clicked');
        const countEl = this.querySelector('.reaction-count');
        countEl.textContent = parseInt(countEl.textContent) + 1;
        
        fetch('actions/react.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'confession_id=' + confessionId + '&reaction=' + reaction
        });
    });
});
</script>
