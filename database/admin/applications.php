<?php
$pageTitle = 'Application Monitoring';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(admin_roles());
$sectionLastViewedAt = badge_opened((int) $user['id'], 'admin/applications.php');
$filter = $user['role'] === 'barangay_admin' ? 'WHERE j.barangay_id = ' . (int) $user['barangay_id'] : '';
$apps = fetch_all("SELECT a.*, COALESCE(a.updated_at, a.created_at) AS changed_at, js.id AS seeker_id, js.profile_photo, u.name AS applicant, e.business_name, e.logo_path, j.title AS job_title FROM applications a JOIN job_seekers js ON js.id = a.jobseeker_id JOIN users u ON u.id = js.user_id JOIN jobs j ON j.id = a.job_id JOIN employers e ON e.id = j.employer_id $filter ORDER BY a.created_at DESC");
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Recruitment Process</span><h1>Application Monitoring</h1></div></section>
<section class="panel"><div class="table-wrap"><table><thead><tr><th>Applicant</th><th>Employer</th><th>Job</th><th>Match</th><th>Status</th><th>Interview</th><th>Date Applied</th></tr></thead><tbody>
<?php foreach ($apps as $app): ?>
  <tr><td><div class="identity"><?= avatar($app['profile_photo'] ?? null, $app['applicant']) ?><div><strong><?= item_new_dot($app['changed_at'] ?? null, $sectionLastViewedAt) ?><?= e($app['applicant']) ?></strong></div></div></td><td><div class="identity"><?= avatar($app['logo_path'] ?? null, $app['business_name'], 'avatar logo-avatar') ?><div><strong><?= e($app['business_name']) ?></strong></div></div></td><td><?= e($app['job_title']) ?></td><td><?= (int) $app['match_score'] ?>%</td><td><?= status_badge($app['status']) ?></td><td><?= e(trim(($app['interview_date'] ?? '') . ' ' . ($app['interview_time'] ?? ''))) ?></td><td><?= e($app['created_at']) ?></td></tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
