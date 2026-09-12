<?php
$pageTitle = 'Job Management';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['municipal_admin']);
$sectionLastViewedAt = badge_opened((int) $user['id'], 'admin/jobs.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['job_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    if (in_array($action, ['approved', 'active', 'rejected', 'closed', 'archived'], true)) {
        $job = fetch_one('SELECT j.title, e.user_id FROM jobs j JOIN employers e ON e.id = j.employer_id WHERE j.id = ?', [$id]);
        execute_sql('UPDATE jobs SET status = ?, rejection_reason = ?, updated_at = NOW() WHERE id = ?', [$action, trim($_POST['reason'] ?? ''), $id]);
        if ($job) {
            notify_user((int) $job['user_id'], 'Job post updated', 'Your job post "' . $job['title'] . '" is now ' . ucwords($action) . '.');
        }
        log_activity((int) $user['id'], 'job_' . $action, 'Updated job #' . $id);
        flash('success', 'Job post updated.');
    }
    redirect('admin/jobs.php');
}
$jobs = fetch_all('SELECT j.*, COALESCE(j.updated_at, j.created_at) AS changed_at, e.business_name, e.logo_path, b.name AS barangay_name FROM jobs j JOIN employers e ON e.id = j.employer_id LEFT JOIN barangays b ON b.id = j.barangay_id ORDER BY j.created_at DESC');
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Municipal Employment Officer</span><h1>Job Posting Management</h1></div></section>
<section class="panel"><div class="table-wrap"><table><thead><tr><th>Job</th><th>Employer</th><th>Barangay</th><th>Type</th><th>Deadline</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($jobs as $job): ?>
  <tr>
    <td><strong><?= item_new_dot($job['changed_at'] ?? null, $sectionLastViewedAt) ?><?= e($job['title']) ?></strong><br><small><?= e($job['category']) ?> | <?= e($job['required_skills']) ?></small></td>
    <td><div class="identity"><?= avatar($job['logo_path'] ?? null, $job['business_name'], 'avatar logo-avatar') ?><div><strong><?= e($job['business_name']) ?></strong></div></div></td>
    <td><?= e($job['barangay_name']) ?></td>
    <td><?= e($job['employment_type']) ?></td>
    <td><?= e($job['deadline']) ?></td>
    <td><?= status_badge($job['status']) ?></td>
    <td class="actions-cell"><form method="post"><input type="hidden" name="job_id" value="<?= (int) $job['id'] ?>"><input name="reason" placeholder="Reason"><button class="mini success" name="action" value="approved">Approve</button><button class="mini" name="action" value="active">Set Active</button><button class="mini danger" name="action" value="rejected">Reject</button><button class="mini warning" name="action" value="closed">Close</button></form></td>
  </tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
