<?php
require_once __DIR__ . '/../includes/auth.php';
ensure_schema_loaded_message();
$trainings = fetch_all("SELECT * FROM trainings WHERE status = 'open' ORDER BY start_date ASC");
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Training Programs</title><link rel="stylesheet" href="<?= url('assets/css/app.css?v=20260820d') ?>"></head>
<body class="public-page">
<header class="public-header"><a class="brand public-brand" href="<?= url('index.php') ?>"><img class="brand-logo" src="<?= url(APP_LOGO_PATH) ?>" alt="<?= APP_MUNICIPALITY ?> official seal"><strong>LaborMatch</strong><small><?= APP_MUNICIPALITY ?></small></a><nav><a href="<?= url('public/jobs.php') ?>">Jobs</a><a href="<?= url('auth/login.php') ?>">Login</a></nav></header>
<main class="public-main">
  <section class="section-header"><div><span class="eyebrow">Training</span><h1>Open Training Programs</h1></div></section>
  <div class="card-grid">
    <?php foreach ($trainings as $training): ?>
      <article class="card"><span class="badge success"><?= e($training['status']) ?></span><h3><?= e($training['title']) ?></h3><p><?= e($training['provider']) ?> | <?= e($training['location']) ?></p><p><?= e($training['description']) ?></p><p>Slots: <?= (int) $training['slots'] ?></p></article>
    <?php endforeach; ?>
  </div>
</main>
</body></html>
