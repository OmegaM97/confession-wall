<?php
require_once __DIR__ . '/config/db.php';

$page = $_GET['page'] ?? 'home';
$validPages = ['home', 'confessions', 'confession', 'add_confession'];
if (!in_array($page, $validPages, true)) {
    $page = 'home';
}

?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/navbar.php'; ?>

<div class="container">
    <?php
    $pageFile = __DIR__ . '/pages/' . $page . '.php';
    if (file_exists($pageFile)) {
        include $pageFile;
    } else {
        echo '<p>Page not found.</p>';
    }
    ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
