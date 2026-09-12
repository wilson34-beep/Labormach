<?php
$pageTitle = 'Admin Dashboard';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(admin_roles());
$isMunicipal = $user['role'] === 'municipal_admin';
$barangayFilter = $isMunicipal ? '' : ' AND u.barangay_id = ' . (int) $user['barangay_id'];
$jobBarangayFilter = $isMunicipal ? '' : ' AND j.barangay_id = ' . (int) $user['barangay_id'];

$stats = [
    'job_seekers' => (int) fetch_one("SELECT COUNT(*) total FROM users u WHERE u.role = 'jobseeker' $barangayFilter")['total'],
    'new_accounts' => (int) fetch_one($isMunicipal ? "SELECT COUNT(*) total FROM users WHERE role <> 'municipal_admin' AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)" : "SELECT COUNT(*) total FROM users WHERE role = 'jobseeker' AND barangay_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)", $isMunicipal ? [] : [(int) $user['barangay_id']])['total'],
    'pending_seekers' => (int) fetch_one("SELECT COUNT(*) total FROM users u LEFT JOIN job_seekers js ON js.user_id = u.id WHERE u.role = 'jobseeker' $barangayFilter AND (u.status IN ('pending','active') OR js.verification_status = 'pending')")['total'],
    'employers' => (int) fetch_one("SELECT COUNT(*) total FROM users WHERE role = 'employer'")['total'],
    'pending_employers' => (int) fetch_one("SELECT COUNT(*) total FROM employers WHERE verification_status = 'pending'")['total'],
    'verified_employers' => (int) fetch_one("SELECT COUNT(*) total FROM employers WHERE verification_status = 'verified'")['total'],
    'active_jobs' => (int) fetch_one("SELECT COUNT(*) total FROM jobs j WHERE j.status = 'active' $jobBarangayFilter")['total'],
    'pending_jobs' => (int) fetch_one("SELECT COUNT(*) total FROM jobs j WHERE j.status = 'pending' $jobBarangayFilter")['total'],
    'applications' => (int) fetch_one("SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE 1=1 $jobBarangayFilter")['total'],
    'hired' => (int) fetch_one("SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE a.status = 'hired' $jobBarangayFilter")['total'],
    'pending_applications' => (int) fetch_one("SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE a.status IN ('applied','screening','shortlisted','interview') $jobBarangayFilter")['total'],
    'new_notifications' => (int) fetch_one('SELECT COUNT(*) total FROM notifications WHERE user_id = ? AND is_seen = 0', [(int) $user['id']])['total'],
];
$skills = fetch_all("SELECT category, COUNT(*) total FROM skills GROUP BY category ORDER BY total DESC");
$barangays = fetch_all("SELECT b.name, COUNT(js.id) seekers FROM barangays b LEFT JOIN users u ON u.barangay_id = b.id AND u.role = 'jobseeker' LEFT JOIN job_seekers js ON js.user_id = u.id GROUP BY b.id ORDER BY seekers DESC");
$activities = fetch_all('SELECT l.*, u.name FROM activity_logs l LEFT JOIN users u ON u.id = l.user_id ORDER BY l.created_at DESC LIMIT 8');
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head">
  <div>
    <span class="eyebrow"><?= $isMunicipal ? 'Municipal Administrator' : 'Barangay Administrator' ?></span>
    <h1><?= $isMunicipal ? 'General MacArthur Dashboard' : e($user['barangay_name'] ?? 'Barangay') . ' Dashboard' ?></h1>
  </div>
</section>
<div class="stat-grid">
  <article class="stat"><span>Job Seekers</span><strong><?= $stats['job_seekers'] ?></strong></article>
  <article class="stat"><span>New Accounts This Week</span><strong><?= $stats['new_accounts'] ?></strong></article>
  <article class="stat"><span>Pending Job Seeker Reviews</span><strong><?= $stats['pending_seekers'] ?></strong></article>
  <article class="stat"><span>Employers</span><strong><?= $stats['employers'] ?></strong></article>
  <?php if ($isMunicipal): ?><article class="stat"><span>Pending Employer Reviews</span><strong><?= $stats['pending_employers'] ?></strong></article><?php endif; ?>
  <article class="stat"><span>Verified Employers</span><strong><?= $stats['verified_employers'] ?></strong></article>
  <article class="stat"><span>Active Jobs</span><strong><?= $stats['active_jobs'] ?></strong></article>
  <article class="stat"><span>Pending Jobs</span><strong><?= $stats['pending_jobs'] ?></strong></article>
  <article class="stat"><span>Applications</span><strong><?= $stats['applications'] ?></strong></article>
  <article class="stat"><span>Hired Applicants</span><strong><?= $stats['hired'] ?></strong></article>
  <article class="stat"><span>Pending Applications</span><strong><?= $stats['pending_applications'] ?></strong></article>
  <article class="stat"><span>New Notifications</span><strong><?= $stats['new_notifications'] ?></strong></article>
</div>
<div class="grid two">
  <section class="panel">
    <h2>Available Jobs by Skill Category</h2>
    <?php foreach ($skills as $skill): ?>
      <div class="bar-row"><span><?= e($skill['category']) ?></span><div><b style="width: <?= min(100, (int) $skill['total'] * 12) ?>%"></b></div><strong><?= (int) $skill['total'] ?></strong></div>
    <?php endforeach; ?>
  </section>
  <section class="panel">
    <h2>Barangay Employment Monitoring</h2>
    <?php foreach ($barangays as $barangay): ?>
      <div class="bar-row"><span><?= e($barangay['name']) ?></span><div><b style="width: <?= min(100, (int) $barangay['seekers'] * 20) ?>%"></b></div><strong><?= (int) $barangay['seekers'] ?></strong></div>
    <?php endforeach; ?>
  </section>
</div>
<section class="panel">
  <h2>Recent Activities</h2>
  <div class="table-wrap">
    <table><thead><tr><th>User</th><th>Action</th><th>Details</th><th>Date</th></tr></thead><tbody>
      <?php foreach ($activities as $activity): ?>
        <tr><td><?= e($activity['name'] ?? 'System') ?></td><td><?= e($activity['action']) ?></td><td><?= e($activity['details']) ?></td><td><?= e($activity['created_at']) ?></td></tr>
      <?php endforeach; ?>
    </tbody></table>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
