<?php ob_start(); ?>
<section class="container py-6"><div class="glass-card p-5 text-center"><h1>Page not found</h1><p class="text-muted">The page you requested could not be found.</p><a class="btn btn-primary rounded-pill" href="/">Return home</a></div></section>
<?php $content=ob_get_clean(); require __DIR__.'/../layouts/app.php'; ?>
