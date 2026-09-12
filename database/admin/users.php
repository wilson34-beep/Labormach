<?php
$pageTitle = 'Job Seeker Management';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(admin_roles());
$sectionLastViewedAt = badge_opened((int) $user['id'], 'admin/users.php');
$isMunicipal = $user['role'] === 'municipal_admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['user_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    $target = fetch_one("SELECT * FROM users WHERE id = ? AND role = 'jobseeker'", [$id]);
    if ($target && ($isMunicipal || (int) $target['barangay_id'] === (int) $user['barangay_id'])) {
        if ($action === 'verify') {
            execute_sql("UPDATE users SET status = 'verified' WHERE id = ?", [$id]);
            execute_sql("UPDATE job_seekers SET verification_status = 'verified' WHERE user_id = ?", [$id]);
            notify_user($id, 'Profile verified', 'Your LaborMatch job seeker profile has been verified.');
        } elseif (in_array($action, ['active', 'suspended', 'rejected'], true)) {
            execute_sql('UPDATE users SET status = ? WHERE id = ?', [$action, $id]);
        } elseif ($action === 'delete') {
            execute_sql('DELETE FROM users WHERE id = ?', [$id]);
        }
        log_activity((int) $user['id'], 'jobseeker_' . $action, 'Updated job seeker account #' . $id);
        flash('success', 'Job seeker account updated.');
    }
    redirect('admin/users.php');
}

$where = "WHERE u.role = 'jobseeker'";
$params = [];
if (!$isMunicipal) {
    $where .= ' AND u.barangay_id = ?';
    $params[] = (int) $user['barangay_id'];
}
foreach (['q', 'gender', 'employment_status'] as $filter) {
    if (!empty($_GET[$filter])) {
        if ($filter === 'q') {
            $where .= ' AND (u.name LIKE ? OR u.email LIKE ? OR js.skills LIKE ?)';
            $term = '%' . $_GET[$filter] . '%';
            array_push($params, $term, $term, $term);
        } else {
            $where .= " AND js.$filter = ?";
            $params[] = $_GET[$filter];
        }
    }
}
$seekers = fetch_all("SELECT u.*, GREATEST(COALESCE(u.updated_at, u.created_at, '1970-01-01 00:00:00'), COALESCE(js.updated_at, js.created_at, '1970-01-01 00:00:00')) AS changed_at, b.name AS barangay_name, js.gender, js.education, js.employment_status, js.skills, js.years_experience, js.profile_photo, js.verification_status FROM users u JOIN job_seekers js ON js.user_id = u.id LEFT JOIN barangays b ON b.id = u.barangay_id $where ORDER BY u.created_at DESC", $params);
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Admin</span><h1>Job Seeker Management</h1></div></section>
<form class="toolbar" method="get">
  <input name="q" value="<?= e($_GET['q'] ?? '') ?>" placeholder="Search name, email, skills">
  <select name="gender"><option value="">Gender</option><option <?= selected($_GET['gender'] ?? '', 'Male') ?>>Male</option><option <?= selected($_GET['gender'] ?? '', 'Female') ?>>Female</option></select>
  <select name="employment_status"><option value="">Employment Status</option><option value="unemployed">Unemployed</option><option value="employed">Employed</option><option value="underemployed">Underemployed</option></select>
  <button class="button" type="submit">Filter</button>
</form>
<section class="panel">
  <div class="table-wrap">
    <table><thead><tr><th>Name</th><th>Barangay</th><th>Education</th><th>Status</th><th>Skills</th><th>Account</th><th>Actions</th></tr></thead><tbody>
      <?php foreach ($seekers as $seeker): ?>
        <tr>
          <td><div class="identity"><?= avatar($seeker['profile_photo'] ?? null, $seeker['name']) ?><div><strong><?= item_new_dot($seeker['changed_at'] ?? null, $sectionLastViewedAt) ?><?= e($seeker['name']) ?></strong><br><small><?= e($seeker['email']) ?></small></div></div></td>
          <td><?= e($seeker['barangay_name']) ?></td>
          <td><?= e($seeker['education']) ?></td>
          <td><?= e($seeker['employment_status']) ?></td>
          <td><?= e($seeker['skills']) ?></td>
          <td><?= status_badge($seeker['status']) ?></td>
          <td class="actions-cell">
            <form method="post"><input type="hidden" name="user_id" value="<?= (int) $seeker['id'] ?>"><button name="action" value="verify" class="mini success">Verify</button><button name="action" value="suspended" class="mini warning">Suspend</button><button name="action" value="active" class="mini">Activate</button><button name="action" value="delete" class="mini danger" onclick="return confirm('Delete account?')">Delete</button></form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody></table>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
