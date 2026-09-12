<?php
$pageTitle = 'Interview Scheduling';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['employer']);
$sectionLastViewedAt = badge_opened((int) $user['id'], 'employer/interviews.php');
$employer = fetch_one('SELECT * FROM employers WHERE user_id = ?', [(int) $user['id']]);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appId = (int) $_POST['application_id'];
    $app = fetch_one('SELECT a.*, js.user_id FROM applications a JOIN jobs j ON j.id = a.job_id JOIN job_seekers js ON js.id = a.jobseeker_id WHERE a.id = ? AND j.employer_id = ?', [$appId, $employer['id']]);
    if ($app) {
        execute_sql("UPDATE applications SET status='interview', interview_date=?, interview_time=?, interview_location=?, interview_type=?, interview_notes=?, updated_at=NOW() WHERE id=?", [$_POST['interview_date'], $_POST['interview_time'], trim($_POST['interview_location']), $_POST['interview_type'], trim($_POST['interview_notes']), $appId]);
        notify_user((int) $app['user_id'], 'Interview scheduled', 'An interview has been scheduled for your application.');
        flash('success', 'Interview scheduled.');
    }
    redirect('employer/interviews.php');
}
$apps = fetch_all("SELECT a.*, COALESCE(a.updated_at, a.created_at) AS changed_at, u.name AS applicant, js.profile_photo, j.title AS job_title FROM applications a JOIN job_seekers js ON js.id = a.jobseeker_id JOIN users u ON u.id = js.user_id JOIN jobs j ON j.id = a.job_id WHERE j.employer_id = ? AND a.status IN ('shortlisted','interview') ORDER BY a.interview_date IS NULL DESC, a.interview_date ASC", [$employer['id']]);
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Employer</span><h1>Interview Scheduling</h1></div></section>
<section class="panel"><div class="table-wrap"><table><thead><tr><th>Applicant</th><th>Job</th><th>Schedule</th><th>Type</th><th>Notes</th><th>Action</th></tr></thead><tbody>
<?php foreach ($apps as $app): ?>
  <tr>
    <td><div class="identity"><?= avatar($app['profile_photo'] ?? null, $app['applicant']) ?><div><strong><?= item_new_dot($app['changed_at'] ?? null, $sectionLastViewedAt) ?><?= e($app['applicant']) ?></strong></div></div></td><td><?= e($app['job_title']) ?></td><td><?= e($app['interview_date']) ?> <?= e($app['interview_time']) ?></td><td><?= e($app['interview_type']) ?></td><td><?= e($app['interview_notes']) ?></td>
    <td><form method="post" class="inline-form"><input type="hidden" name="application_id" value="<?= (int) $app['id'] ?>"><input type="date" name="interview_date" required><input type="time" name="interview_time" required><input name="interview_location" placeholder="Location"><select name="interview_type"><option>Face-to-face</option><option>Online</option><option>Phone Interview</option></select><input name="interview_notes" placeholder="Notes"><button class="mini" type="submit">Schedule</button></form></td>
  </tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
