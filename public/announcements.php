<?php
require_once __DIR__ . '/../includes/auth.php';
ensure_schema_loaded_message();
$items = fetch_all("SELECT a.*, u.name AS author FROM announcements a LEFT JOIN users u ON u.id = a.created_by WHERE audience IN ('public','all') ORDER BY a.created_at DESC");
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Announcements</title><link rel="stylesheet" href="<?= url('assets/css/app.css?v=20260820d') ?>"></head>
<body class="public-page">
<header class="public-header"><a class="brand public-brand" href="<?= url('index.php') ?>"><img class="brand-logo" src="<?= url(APP_LOGO_PATH) ?>" alt="<?= APP_MUNICIPALITY ?> official seal"><strong>LaborMatch</strong><small><?= APP_MUNICIPALITY ?></small></a><nav><a href="<?= url('public/jobs.php') ?>">Jobs</a><a href="<?= url('auth/login.php') ?>">Login</a></nav></header>
<main class="public-main">
  <section class="section-header"><div><span class="eyebrow">Public Notices</span><h1>Announcements</h1></div></section>
  <div class="card-grid">
    <?php foreach ($items as $item): ?>
      <article class="card"><h3><?= e($item['title']) ?></h3><p><?= e($item['message']) ?></p><small><?= e($item['created_at']) ?></small></article>
    <?php endforeach; ?>
  </div>
</main>
</body></html>
