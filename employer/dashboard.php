<?php
$pageTitle = 'Employer Dashboard';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['employer']);
$employer = fetch_one('SELECT * FROM employers WHERE user_id = ?', [(int) $user['id']]);
if (!$employer) {
    flash('error', 'Please complete your company profile first.');
    redirect('employer/company.php');
}
$employer = array_replace([
    'id' => 0,
    'business_name' => $user['name'] ?? 'Employer',
    'logo_path' => null,
    'verification_status' => 'pending',
], $employer);
$employerId = (int) $employer['id'];
$businessName = trim((string) $employer['business_name']) ?: ($user['name'] ?? 'Employer');
$stats = [
    'active_jobs' => fetch_one("SELECT COUNT(*) total FROM jobs WHERE employer_id = ? AND status = 'active'", [$employerId])['total'],
    'applicants' => fetch_one('SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE j.employer_id = ?', [$employerId])['total'],
    'pending' => fetch_one("SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE j.employer_id = ? AND a.status IN ('applied','screening')", [$employerId])['total'],
    'shortlisted' => fetch_one("SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE j.employer_id = ? AND a.status = 'shortlisted'", [$employerId])['total'],
    'interviews' => fetch_one("SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE j.employer_id = ? AND a.status = 'interview'", [$employerId])['total'],
    'hired' => fetch_one("SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE j.employer_id = ? AND a.status = 'hired'", [$employerId])['total'],
];
$jobs = fetch_all('SELECT * FROM jobs WHERE employer_id = ? ORDER BY created_at DESC LIMIT 8', [$employerId]);
$apps = fetch_all('SELECT a.*, u.name AS applicant, js.profile_photo, j.title AS job_title FROM applications a JOIN job_seekers js ON js.id = a.jobseeker_id JOIN users u ON u.id = js.user_id JOIN jobs j ON j.id = a.job_id WHERE j.employer_id = ? ORDER BY a.created_at DESC LIMIT 8', [$employerId]);
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head">
  <div class="title-with-avatar">
    <?= avatar($employer['logo_path'] ?? null, $businessName, 'avatar large logo-avatar') ?>
    <div><span class="eyebrow">Employer</span><h1><?= e($businessName) ?> Dashboard</h1></div>
  </div>
  <?= status_badge($employer['verification_status']) ?>
</section>
<div class="stat-grid">
  <article class="stat"><span>Active Job Posts</span><strong><?= (int) $stats['active_jobs'] ?></strong></article>
  <article class="stat"><span>Total Applicants</span><strong><?= (int) $stats['applicants'] ?></strong></article>
  <article class="stat"><span>Pending Applications</span><strong><?= (int) $stats['pending'] ?></strong></article>
  <article class="stat"><span>Shortlisted</span><strong><?= (int) $stats['shortlisted'] ?></strong></article>
  <article class="stat"><span>Interviews</span><strong><?= (int) $stats['interviews'] ?></strong></article>
  <article class="stat"><span>Hired</span><strong><?= (int) $stats['hired'] ?></strong></article>
</div>
<div class="grid two">
  <section class="panel">
    <div class="section-header compact"><h2>Recent Job Posts</h2><a href="<?= url('employer/jobs.php') ?>">Manage jobs</a></div>
    <div class="table-wrap"><table><thead><tr><th>Job</th><th>Status</th><th>Deadline</th></tr></thead><tbody>
      <?php foreach ($jobs as $job): ?>
        <tr><td><?= e($job['title']) ?><br><small><?= e($job['employment_type']) ?></small></td><td><?= status_badge($job['status']) ?></td><td><?= e($job['deadline']) ?></td></tr>
      <?php endforeach; ?>
    </tbody></table></div>
  </section>
  <section class="panel">
    <div class="section-header compact"><h2>Recent Applicants</h2><a href="<?= url('employer/applicants.php') ?>">View all</a></div>
    <div class="table-wrap"><table><thead><tr><th>Applicant</th><th>Job</th><th>Match</th><th>Status</th></tr></thead><tbody>
      <?php foreach ($apps as $app): ?>
        <tr><td><div class="identity"><?= avatar($app['profile_photo'] ?? null, $app['applicant']) ?><div><strong><?= e($app['applicant']) ?></strong></div></div></td><td><?= e($app['job_title']) ?></td><td><?= (int) $app['match_score'] ?>%</td><td><?= status_badge($app['status']) ?></td></tr>
      <?php endforeach; ?>
    </tbody></table></div>
  </section>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
