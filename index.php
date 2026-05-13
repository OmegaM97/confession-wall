<?php
require_once __DIR__ . '/config/db.php';

$page = $_GET['page'] ?? 'home';
$validPages = ['home', 'confessions', 'confession', 'add_confession', 'about'];
if (!in_array($page, $validPages, true)) {
    $page = 'home';
}

?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php if ($page !== 'home'): ?>
<?php include __DIR__ . '/includes/navbar.php'; ?>
<?php endif; ?>

<?php if ($page !== 'home'): ?>
<div class="container">
<?php endif; ?>
    <?php
    $pageFile = __DIR__ . '/pages/' . $page . '.php';
    if (file_exists($pageFile)) {
        include $pageFile;
    } else {
        echo '<p>Page not found.</p>';
    }
    ?>
<?php if ($page !== 'home'): ?>
</div>
<?php endif; ?>

<?php if ($page !== 'home'): ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
<?php endif; ?>
