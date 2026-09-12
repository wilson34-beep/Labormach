<?php
$pageTitle = 'Employer Verification';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['municipal_admin']);
$sectionLastViewedAt = badge_opened((int) $user['id'], 'admin/employers.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['employer_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    $employer = fetch_one('SELECT * FROM employers WHERE id = ?', [$id]);
    if ($employer) {
        if (in_array($action, ['verified', 'rejected', 'pending'], true)) {
            execute_sql('UPDATE employers SET verification_status = ?, updated_at = NOW() WHERE id = ?', [$action, $id]);
            execute_sql('UPDATE users SET status = ? WHERE id = ?', [$action === 'verified' ? 'verified' : $action, (int) $employer['user_id']]);
            notify_user((int) $employer['user_id'], 'Employer verification updated', 'Your employer verification status is now ' . $action . '.');
        } elseif (in_array($action, ['suspended', 'active'], true)) {
            execute_sql('UPDATE users SET status = ? WHERE id = ?', [$action, (int) $employer['user_id']]);
        }
        log_activity((int) $user['id'], 'employer_' . $action, 'Updated employer #' . $id);
        flash('success', 'Employer updated.');
    }
    redirect('admin/employers.php');
}
$employers = fetch_all("SELECT e.*, GREATEST(COALESCE(e.updated_at, e.created_at, '1970-01-01 00:00:00'), COALESCE(u.updated_at, u.created_at, '1970-01-01 00:00:00')) AS changed_at, u.name, u.email, u.contact_number, u.status FROM employers e JOIN users u ON u.id = e.user_id ORDER BY e.created_at DESC");
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Municipal Admin</span><h1>Employer Verification</h1></div></section>
<section class="panel"><div class="table-wrap"><table><thead><tr><th>Employer</th><th>Industry</th><th>Documents</th><th>Verification</th><th>Account</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($employers as $employer): ?>
  <tr>
    <td><div class="identity"><?= avatar($employer['logo_path'] ?? null, $employer['business_name'], 'avatar logo-avatar') ?><div><strong><?= item_new_dot($employer['changed_at'] ?? null, $sectionLastViewedAt) ?><?= e($employer['business_name']) ?></strong><br><small><?= e($employer['email']) ?></small></div></div></td>
    <td><?= e($employer['industry']) ?><br><small><?= e($employer['business_type']) ?></small></td>
    <td><?= $employer['business_permit_path'] ? '<a href="' . url($employer['business_permit_path']) . '">Business Permit</a>' : 'No permit uploaded' ?></td>
    <td><?= status_badge($employer['verification_status']) ?></td>
    <td><?= status_badge($employer['status']) ?></td>
    <td class="actions-cell"><form method="post"><input type="hidden" name="employer_id" value="<?= (int) $employer['id'] ?>"><button class="mini success" name="action" value="verified">Approve</button><button class="mini danger" name="action" value="rejected">Reject</button><button class="mini warning" name="action" value="suspended">Suspend</button><button class="mini" name="action" value="active">Activate</button></form></td>
  </tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
