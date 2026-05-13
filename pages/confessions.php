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

// Get trending confessions
$trendingSql = "SELECT c.id, c.content, c.created_at,
    COUNT(DISTINCT co.id) + SUM(CASE WHEN r.reaction IS NOT NULL THEN 1 ELSE 0 END) AS engagement
FROM confessions c
LEFT JOIN comments co ON co.confession_id = c.id
LEFT JOIN reactions r ON r.confession_id = c.id
GROUP BY c.id
ORDER BY engagement DESC
LIMIT 5";
$trendingResult = $conn->query($trendingSql);
?>

<!-- Small Hero Section -->
<section class="confessions-hero">
    <div class="container">
        <h1>Community Confessions</h1>
        <p>Read anonymous thoughts, secrets, and stories shared by people.</p>
    </div>
</section>

<!-- Main Content -->
<div class="confessions-wrapper">
    <!-- Feed -->
    <div class="confessions-feed">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="confession-card">
                    <div class="confession-header">
                        <div class="user-info">
                            <div class="avatar">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div class="user-details">
                                <div class="username">Anonymous</div>
                                <div class="timestamp"><?php echo time_elapsed_string($row['created_at']); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="confession-content">
                        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    </div>
                    <div class="confession-reactions">
                        <button class="reaction-btn like-btn" data-confession-id="<?php echo $row['id']; ?>" data-reaction="like">
                            <span class="reaction-icon">👍</span>
                            <span class="reaction-count"><?php echo (int) $row['likes_count']; ?></span>
                        </button>
                        <button class="reaction-btn dislike-btn" data-confession-id="<?php echo $row['id']; ?>" data-reaction="dislike">
                            <span class="reaction-icon">👎</span>
                            <span class="reaction-count"><?php echo (int) $row['dislikes_count']; ?></span>
                        </button>
                        <a href="index.php?page=confession&id=<?php echo (int) $row['id']; ?>" class="reaction-btn comment-btn">
                            <span class="reaction-icon">💬</span>
                            <span class="reaction-count"><?php echo (int) $row['comments_count']; ?></span>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-confessions">
                <p>No confessions yet. Be the first to share!</p>
                <a href="index.php?page=add_confession" class="btn btn-primary">Post Confession</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <aside class="confessions-sidebar">
        <div class="sidebar-section trending">
            <h3>Trending Now</h3>
            <div class="trending-list">
                <?php if ($trendingResult && $trendingResult->num_rows > 0): ?>
                    <?php while ($trending = $trendingResult->fetch_assoc()): ?>
                        <a href="index.php?page=confession&id=<?php echo (int) $trending['id']; ?>" class="trending-item">
                            <p><?php echo substr(htmlspecialchars($trending['content']), 0, 100) . '...'; ?></p>
                            <span class="engagement">💬 <?php echo (int) $trending['engagement']; ?></span>
                        </a>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="sidebar-section guidelines">
            <h3>Community Guidelines</h3>
            <ul>
                <li>✓ Be respectful and kind</li>
                <li>✓ No hate speech</li>
                <li>✓ Keep it anonymous</li>
                <li>✓ Support others</li>
                <li>✓ No spam or ads</li>
            </ul>
        </div>
    </aside>
</div>

<!-- Floating Add Button -->
<a href="index.php?page=add_confession" class="floating-btn" title="Post Confession">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg>
</a>

<script>
// Time elapsed calculation
function timeAgo(dateStr) {
    const date = new Date(dateStr);
    const seconds = Math.floor((new Date() - date) / 1000);
    const intervals = {
        year: 31536000,
        month: 2592000,
        week: 604800,
        day: 86400,
        hour: 3600,
        minute: 60
    };
    for (const [name, value] of Object.entries(intervals)) {
        const interval = Math.floor(seconds / value);
        if (interval >= 1) {
            return interval + ' ' + name + (interval > 1 ? 's' : '') + ' ago';
        }
    }
    return 'just now';
}

// Reaction button functionality
document.querySelectorAll('.reaction-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if (this.classList.contains('comment-btn')) return;
        
        e.preventDefault();
        const confessionId = this.dataset.confessionId;
        const reaction = this.dataset.reaction;
        
        // Add animation
        this.classList.add('clicked');
        
        // Increment count
        const countEl = this.querySelector('.reaction-count');
        countEl.textContent = parseInt(countEl.textContent) + 1;
        
        // Send to server
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
