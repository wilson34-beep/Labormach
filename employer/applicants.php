<?php
$pageTitle = 'Applicant Management';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['employer']);
$sectionLastViewedAt = badge_opened((int) $user['id'], 'employer/applicants.php');
$employer = fetch_one('SELECT * FROM employers WHERE user_id = ?', [(int) $user['id']]);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appId = (int) ($_POST['application_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    $app = fetch_one('SELECT a.*, js.user_id FROM applications a JOIN jobs j ON j.id = a.job_id JOIN job_seekers js ON js.id = a.jobseeker_id WHERE a.id = ? AND j.employer_id = ?', [$appId, $employer['id']]);
    if ($app && in_array($status, ['screening','shortlisted','interview','hired','rejected'], true)) {
        execute_sql('UPDATE applications SET status = ?, hiring_result = ?, updated_at = NOW() WHERE id = ?', [$status, $status === 'hired' ? 'Hired' : null, $appId]);
        notify_user((int) $app['user_id'], 'Application updated', 'Your application status is now ' . $status . '.');
        log_activity((int) $user['id'], 'application_' . $status, 'Updated application #' . $appId);
        flash('success', 'Applicant status updated.');
    }
    redirect('employer/applicants.php');
}
$apps = fetch_all('SELECT a.*, COALESCE(a.updated_at, a.created_at) AS changed_at, u.name, u.email, js.education, js.skills, js.years_experience, js.profile_photo, js.resume_path, j.title AS job_title FROM applications a JOIN job_seekers js ON js.id = a.jobseeker_id JOIN users u ON u.id = js.user_id JOIN jobs j ON j.id = a.job_id WHERE j.employer_id = ? ORDER BY a.created_at DESC', [$employer['id']]);
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Employer</span><h1>Applicant Management</h1></div></section>
<section class="panel"><div class="table-wrap"><table><thead><tr><th>Applicant</th><th>Job</th><th>Skills</th><th>Experience</th><th>Match</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($apps as $app): ?>
  <tr>
    <td><div class="identity"><?= avatar($app['profile_photo'] ?? null, $app['name']) ?><div><strong><?= item_new_dot($app['changed_at'] ?? null, $sectionLastViewedAt) ?><?= e($app['name']) ?></strong><br><small><?= e($app['email']) ?></small><?php if ($app['resume_path']): ?><br><a href="<?= url($app['resume_path']) ?>">Download Resume</a><?php endif; ?></div></div></td>
    <td><?= e($app['job_title']) ?></td>
    <td><?= e($app['skills']) ?></td>
    <td><?= (int) $app['years_experience'] ?> years</td>
    <td><?= (int) $app['match_score'] ?>%</td>
    <td><?= status_badge($app['status']) ?></td>
    <td><form method="post" class="inline-form"><input type="hidden" name="application_id" value="<?= (int) $app['id'] ?>"><select name="status"><option value="screening">Screening</option><option value="shortlisted">Shortlist</option><option value="interview">Interview</option><option value="hired">Hired</option><option value="rejected">Reject</option></select><button class="mini" type="submit">Update</button></form></td>
  </tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
