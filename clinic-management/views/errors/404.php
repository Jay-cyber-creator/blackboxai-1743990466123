<?php
$title = 'Page Not Found';
ob_start();
?>
<div class="text-center py-5">
    <h1 class="display-1 text-danger">404</h1>
    <h2 class="mb-4">Page Not Found</h2>
    <p class="lead">The page you are looking for doesn't exist or has been moved.</p>
    <a href="/" class="btn btn-primary">Return Home</a>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>