<?php
$pageTitle = 'Barangay Admin Accounts';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['municipal_admin']);
$sectionLastViewedAt = badge_opened((int) $user['id'], 'admin/barangay_admins.php');
$barangays = fetch_all('SELECT * FROM barangays ORDER BY name');
$assignedBarangays = fetch_all("SELECT u.barangay_id, u.name, u.email, b.name AS barangay_name FROM users u LEFT JOIN barangays b ON b.id = u.barangay_id WHERE u.role = 'barangay_admin' AND u.barangay_id IS NOT NULL");
$assignedBarangayIds = array_flip(array_map('intval', array_column($assignedBarangays, 'barangay_id')));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $barangayId = (int) ($_POST['barangay_id'] ?? 0);

        if ($name === '' || $email === '' || $barangayId <= 0 || strlen($password) < 6) {
            flash('error', 'Please complete all required fields. Password must be at least 6 characters.');
        } elseif ($password !== $confirmPassword) {
            flash('error', 'Password confirmation does not match.');
        } elseif (fetch_one('SELECT id FROM users WHERE email = ?', [$email])) {
            flash('error', 'Email is already registered.');
        } elseif ($existingAdmin = fetch_one("SELECT u.name, u.email, b.name AS barangay_name FROM users u LEFT JOIN barangays b ON b.id = u.barangay_id WHERE u.role = 'barangay_admin' AND u.barangay_id = ? LIMIT 1", [$barangayId])) {
            flash('error', ($existingAdmin['barangay_name'] ?? 'This barangay') . ' already has a barangay admin: ' . ($existingAdmin['name'] ?? $existingAdmin['email']) . '. Delete or reassign the existing account first.');
        } else {
            execute_sql(
                "INSERT INTO users (barangay_id, name, email, password_hash, role, contact_number, status, email_verified_at, created_at) VALUES (?, ?, ?, ?, 'barangay_admin', ?, 'verified', NOW(), NOW())",
                [$barangayId, $name, $email, password_hash($password, PASSWORD_DEFAULT), trim($_POST['contact_number'] ?? '')]
            );
            $createdId = (int) db()->lastInsertId();
            notify_user($createdId, 'Barangay admin account created', 'Your barangay admin account is ready. You can now monitor your assigned barangay.');
            log_activity((int) $user['id'], 'barangay_admin_create', 'Created barangay admin account for ' . $email . '.');
            flash('success', 'Barangay admin account created.');
            redirect('admin/barangay_admins.php');
        }
    } elseif (in_array($action, ['verified', 'active', 'suspended'], true)) {
        $targetId = (int) ($_POST['user_id'] ?? 0);
        if ($targetId !== (int) $user['id']) {
            execute_sql("UPDATE users SET status = ?, updated_at = NOW() WHERE id = ? AND role = 'barangay_admin'", [$action, $targetId]);
            log_activity((int) $user['id'], 'barangay_admin_' . $action, 'Updated barangay admin account #' . $targetId);
            flash('success', 'Barangay admin account updated.');
        }
        redirect('admin/barangay_admins.php');
    } elseif ($action === 'delete') {
        $targetId = (int) ($_POST['user_id'] ?? 0);
        if ($targetId !== (int) $user['id']) {
            execute_sql("DELETE FROM users WHERE id = ? AND role = 'barangay_admin'", [$targetId]);
            log_activity((int) $user['id'], 'barangay_admin_delete', 'Deleted barangay admin account #' . $targetId);
            flash('success', 'Barangay admin account deleted.');
        }
        redirect('admin/barangay_admins.php');
    }
}

$admins = fetch_all("SELECT u.*, COALESCE(u.updated_at, u.created_at) AS changed_at, b.name AS barangay_name FROM users u LEFT JOIN barangays b ON b.id = u.barangay_id WHERE u.role = 'barangay_admin' ORDER BY b.name, u.name");
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Municipal Admin</span><h1>Barangay Admin Accounts</h1></div></section>

<form class="panel form-grid" method="post">
  <input type="hidden" name="action" value="create">
  <label>Assigned Barangay
    <select name="barangay_id" required>
      <option value="">Select barangay</option>
      <?php foreach ($barangays as $barangay): ?>
        <?php $isAssigned = isset($assignedBarangayIds[(int) $barangay['id']]); ?>
        <option value="<?= (int) $barangay['id'] ?>" <?= $isAssigned ? 'disabled' : '' ?>><?= e($barangay['name']) ?><?= $isAssigned ? ' (assigned)' : '' ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Full Name<input name="name" required></label>
  <label>Email<input type="email" name="email" required></label>
  <label>Contact Number<input name="contact_number"></label>
  <div class="password-pair full">
    <label>Password<input id="barangayAdminPassword" type="password" name="password" required></label>
    <label>Confirm Password<input id="barangayAdminConfirmPassword" type="password" name="confirm_password" required></label>
    <button type="button" class="password-toggle icon-button" data-toggle-password data-password-targets="barangayAdminPassword barangayAdminConfirmPassword" aria-label="Show passwords" title="Show passwords">
      <span class="icon-show"><?= icon('eye') ?></span>
      <span class="icon-hide"><?= icon('eye-off') ?></span>
    </button>
  </div>
  <button class="button" type="submit"><?= icon('user-plus') ?><span>Create Barangay Admin</span></button>
</form>

<section class="panel">
  <div class="section-header compact"><h2>Existing Barangay Admins</h2></div>
  <div class="table-wrap">
    <table><thead><tr><th>Admin</th><th>Barangay</th><th>Contact</th><th>Status</th><th>Actions</th></tr></thead><tbody>
      <?php foreach ($admins as $admin): ?>
        <tr>
          <td><strong><?= item_new_dot($admin['changed_at'] ?? null, $sectionLastViewedAt) ?><?= e($admin['name']) ?></strong><br><small><?= e($admin['email']) ?></small></td>
          <td><?= e($admin['barangay_name'] ?? 'Unassigned') ?></td>
          <td><?= e($admin['contact_number']) ?></td>
          <td><?= status_badge($admin['status']) ?></td>
          <td class="actions-cell">
            <form method="post">
              <input type="hidden" name="user_id" value="<?= (int) $admin['id'] ?>">
              <button class="mini success" name="action" value="verified">Verify</button>
              <button class="mini" name="action" value="active">Activate</button>
              <button class="mini warning" name="action" value="suspended">Suspend</button>
              <button class="mini danger" name="action" value="delete" data-confirm="Delete this barangay admin account? This cannot be undone." data-confirm-title="Delete Barangay Admin" data-confirm-action="Delete">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody></table>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
