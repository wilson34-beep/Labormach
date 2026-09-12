<?php
require_once __DIR__ . '/includes/auth.php';
ensure_schema_loaded_message();
$jobs = fetch_all("SELECT j.*, e.business_name, e.logo_path, b.name AS barangay_name FROM jobs j JOIN employers e ON e.id = j.employer_id LEFT JOIN barangays b ON b.id = j.barangay_id WHERE j.status IN ('approved','active') ORDER BY j.created_at DESC LIMIT 6");
$announcements = fetch_all("SELECT * FROM announcements WHERE audience IN ('public','all') ORDER BY created_at DESC LIMIT 3");
$stats = [
    'jobs' => (int) fetch_one("SELECT COUNT(*) total FROM jobs WHERE status IN ('approved','active')")['total'],
    'seekers' => (int) fetch_one("SELECT COUNT(*) total FROM users WHERE role = 'jobseeker' AND status <> 'suspended'")['total'],
    'employers' => (int) fetch_one("SELECT COUNT(*) total FROM employers WHERE verification_status = 'verified'")['total'],
    'barangays' => (int) fetch_one('SELECT COUNT(*) total FROM barangays')['total'],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LaborMatch - General MacArthur</title>
  <link rel="stylesheet" href="<?= url('assets/css/app.css?v=20260820d') ?>">
</head>
<body class="public-page">
  <header class="public-header">
    <a class="brand public-brand" href="<?= url('index.php') ?>"><img class="brand-logo" src="<?= url(APP_LOGO_PATH) ?>" alt="<?= APP_MUNICIPALITY ?> official seal"><strong>LaborMatch</strong><small><?= APP_MUNICIPALITY ?>, <?= APP_PROVINCE ?></small></a>
    <nav>
      <a href="<?= url('public/jobs.php') ?>">Jobs</a>
      <a href="<?= url('public/training.php') ?>">Training</a>
      <a href="<?= url('public/announcements.php') ?>">Announcements</a>
      <a class="button secondary" href="<?= url('auth/login.php') ?>">Login</a>
      <a class="button" href="<?= url('auth/register.php') ?>">Register</a>
    </nav>
  </header>
  <section class="hero">
    <div class="hero-inner">
      <div>
        <span class="eyebrow">Municipality of General MacArthur</span>
        <h1>LaborMatch for General MacArthur, Eastern Samar.</h1>
        <p>A municipal employment portal for local hiring, barangay monitoring, skills records, training updates, applications, and employer verification.</p>
        <div class="actions">
          <a class="button" href="<?= url('auth/register.php?role=jobseeker') ?>">Create Job Seeker Account</a>
          <a class="button secondary" href="<?= url('auth/register.php?role=employer') ?>">Register Employer</a>
        </div>
      </div>
      <div class="hero-visual">
        <div class="hero-logo-panel">
          <img src="<?= url(APP_LOGO_PATH) ?>" alt="<?= APP_MUNICIPALITY ?> official seal">
        </div>
        <div class="guest-stats">
          <div class="guest-stat"><strong><?= $stats['barangays'] ?></strong><span>Barangays covered</span></div>
          <div class="guest-stat"><strong><?= $stats['jobs'] ?></strong><span>Open jobs</span></div>
          <div class="guest-stat"><strong><?= $stats['employers'] ?></strong><span>Verified employers</span></div>
          <div class="guest-stat"><strong><?= $stats['seekers'] ?></strong><span>Registered job seekers</span></div>
        </div>
      </div>
    </div>
  </section>
  <main class="public-main">
    <section class="feature-band">
      <article class="card">
        <span class="eyebrow">Municipal</span>
        <h3>Employment monitoring</h3>
        <p>General MacArthur admins can track applicants, employers, jobs, training, reports, and barangay employment activity.</p>
      </article>
      <article class="card">
        <span class="eyebrow">Barangay</span>
        <h3>Barangay-level records</h3>
        <p>Barangay admins can focus on local job seekers, applications, announcements, and employment needs in their area.</p>
      </article>
      <article class="card">
        <span class="eyebrow">Hiring</span>
        <h3>Verified local matching</h3>
        <p>Employers and residents work from complete profiles, uploaded documents, skill records, and application status updates.</p>
      </article>
    </section>
    <section class="section-header">
      <div>
        <span class="eyebrow">Available Jobs</span>
        <h2>Open opportunities</h2>
      </div>
      <a href="<?= url('public/jobs.php') ?>">Browse all</a>
    </section>
    <div class="card-grid guest-section">
      <?php foreach ($jobs as $job): ?>
        <article class="card">
          <span class="badge success"><?= e($job['category']) ?></span>
          <h3><?= e($job['title']) ?></h3>
          <div class="identity">
            <?= avatar($job['logo_path'] ?? null, $job['business_name'], 'avatar logo-avatar') ?>
            <p><strong><?= e($job['business_name']) ?></strong><br><small><?= e($job['barangay_name'] ?? 'General MacArthur') ?></small></p>
          </div>
          <p><?= e($job['employment_type']) ?> | <?= e($job['vacancies']) ?> vacancies</p>
          <a class="button secondary" href="<?= url('public/jobs.php') ?>">View Details</a>
        </article>
      <?php endforeach; ?>
    </div>
    <section class="section-header">
      <div>
        <span class="eyebrow">Municipal Announcements</span>
        <h2>Latest notices</h2>
      </div>
    </section>
    <div class="card-grid">
      <?php foreach ($announcements as $item): ?>
        <article class="card">
          <h3><?= e($item['title']) ?></h3>
          <p><?= e($item['message']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </main>
</body>
</html>
