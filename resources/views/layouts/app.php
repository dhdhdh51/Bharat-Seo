<?php use App\Helpers\Security; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= Security::e($title ?? 'CareerForge AI') ?></title>
  <meta name="description" content="CareerForge AI is a configurable AI CV builder SaaS for ATS-friendly resumes, job matching, cover letters, and admin-managed AI providers.">
  <meta property="og:title" content="<?= Security::e($title ?? 'CareerForge AI') ?>"><meta property="og:type" content="website"><meta property="og:description" content="Build, optimize, scan, and export professional CVs with AI assistance.">
  <meta name="twitter:card" content="summary_large_image"><link rel="canonical" href="/">
  <script type="application/ld+json">{"@context":"https://schema.org","@type":"SoftwareApplication","name":"CareerForge AI","applicationCategory":"BusinessApplication","operatingSystem":"Web"}</script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top"><div class="container"><a class="navbar-brand fw-black" href="/">CareerForge <span>AI</span></a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button><div id="nav" class="collapse navbar-collapse"><ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2"><li><a class="nav-link" href="/builder">Builder</a></li><li><a class="nav-link" href="/dashboard">Dashboard</a></li><li><a class="nav-link" href="/admin">Admin</a></li><li><a class="nav-link" href="/login">Login</a></li><li><a class="btn btn-primary rounded-pill px-4" href="/register">Start Free</a></li></ul></div></div></nav>
<main><?= $content ?? '' ?></main>
<footer class="py-5 border-top bg-white"><div class="container"><div class="row g-4"><div class="col-md-5"><h5>CareerForge AI</h5><p class="text-muted">A commercial SaaS foundation for AI-assisted CV creation with configurable providers, credits, plans, security, and deployment workflows.</p></div><div class="col"><a href="#" class="footer-link">Privacy</a><a href="#" class="footer-link">Terms</a><a href="#" class="footer-link">Refunds</a><a href="#" class="footer-link">Cookies</a></div></div></div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><script src="/assets/js/app.js"></script>
</body></html>
