<?php
require_once __DIR__ . '/../includes/auth.php';
ensure_schema_loaded_message();
$where = "WHERE j.status IN ('approved','active')";
$params = [];
if (!empty($_GET['q'])) {
    $where .= " AND (j.title LIKE ? OR e.business_name LIKE ? OR j.category LIKE ? OR j.required_skills LIKE ?)";
    $term = '%' . $_GET['q'] . '%';
    $params = [$term, $term, $term, $term];
}
$jobs = fetch_all("SELECT j.*, e.business_name, e.logo_path, b.name AS barangay_name FROM jobs j JOIN employers e ON e.id = j.employer_id LEFT JOIN barangays b ON b.id = j.barangay_id $where ORDER BY j.created_at DESC", $params);
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Available Jobs</title><link rel="stylesheet" href="<?= url('assets/css/app.css?v=20260820d') ?>"></head>
<body class="public-page">
<header class="public-header"><a class="brand public-brand" href="<?= url('index.php') ?>"><img class="brand-logo" src="<?= url(APP_LOGO_PATH) ?>" alt="<?= APP_MUNICIPALITY ?> official seal"><strong>LaborMatch</strong><small><?= APP_MUNICIPALITY ?></small></a><nav><a href="<?= url('auth/login.php') ?>">Login</a><a class="button" href="<?= url('auth/register.php') ?>">Register</a></nav></header>
<main class="public-main">
  <section class="section-header"><div><span class="eyebrow">Guest Browse</span><h1>Available Jobs</h1></div></section>
  <form class="toolbar" method="get"><input name="q" value="<?= e($_GET['q'] ?? '') ?>" placeholder="Search job, company, category, skill"><button class="button" type="submit">Search</button></form>
  <div class="card-grid">
    <?php foreach ($jobs as $job): ?>
      <article class="card">
        <span class="badge success"><?= e($job['category']) ?></span>
        <h3><?= e($job['title']) ?></h3>
        <div class="identity">
          <?= avatar($job['logo_path'] ?? null, $job['business_name'], 'avatar logo-avatar') ?>
          <p><strong><?= e($job['business_name']) ?></strong><br><small><?= e($job['barangay_name'] ?? 'Any barangay') ?></small></p>
        </div>
        <p><?= e($job['required_skills']) ?></p>
        <p><?= e($job['employment_type']) ?> | Deadline: <?= e($job['deadline']) ?></p>
        <a class="button secondary" href="<?= url('auth/login.php') ?>">Login to Apply</a>
      </article>
    <?php endforeach; ?>
  </div>
</main>
</body></html>
