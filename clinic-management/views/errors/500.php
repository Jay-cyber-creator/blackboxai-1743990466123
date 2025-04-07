<?php
$title = 'Server Error';
ob_start();
?>
<div class="text-center py-5">
    <h1 class="display-1 text-danger">500</h1>
    <h2 class="mb-4">Internal Server Error</h2>
    <p class="lead">Something went wrong on our end. Please try again later.</p>
    <a href="/" class="btn btn-primary">Return Home</a>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>