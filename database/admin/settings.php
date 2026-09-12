<?php
$pageTitle = 'Settings';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(admin_roles());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'profile') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $contactNumber = trim($_POST['contact_number'] ?? '');
        $photo = $user['profile_photo'] ?? null;
        $duplicate = fetch_one('SELECT id FROM users WHERE email = ? AND id <> ?', [$email, (int) $user['id']]);

        if ($name === '' || $email === '') {
            flash('error', 'Name and email are required.');
        } elseif ($duplicate) {
            flash('error', 'Email is already used by another account.');
        } else {
            try {
                if ($user['role'] === 'barangay_admin') {
                    $photo = save_upload('profile_photo', 'profiles', ['jpg', 'jpeg', 'png']) ?: $photo;
                }
                execute_sql('UPDATE users SET name = ?, email = ?, contact_number = ?, profile_photo = ?, updated_at = NOW() WHERE id = ?', [$name, $email, $contactNumber, $photo, (int) $user['id']]);
            } catch (Throwable $exception) {
                flash('error', $exception->getMessage());
                redirect('admin/settings.php');
            }
            log_activity((int) $user['id'], 'settings_profile_update', 'Updated admin account settings.');
            flash('success', 'Account settings updated.');
            redirect('admin/settings.php');
        }
    } elseif ($action === 'password') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $freshUser = fetch_one('SELECT * FROM users WHERE id = ?', [(int) $user['id']]);

        if (!$freshUser || !password_verify($currentPassword, $freshUser['password_hash'])) {
            flash('error', 'Current password is incorrect.');
        } elseif (strlen($newPassword) < 6) {
            flash('error', 'New password must be at least 6 characters.');
        } elseif ($newPassword !== $confirmPassword) {
            flash('error', 'Password confirmation does not match.');
        } else {
            execute_sql('UPDATE users SET password_hash = ?, updated_at = NOW() WHERE id = ?', [password_hash($newPassword, PASSWORD_DEFAULT), (int) $user['id']]);
            log_activity((int) $user['id'], 'settings_password_update', 'Changed admin account password.');
            flash('success', 'Password changed.');
            redirect('admin/settings.php');
        }
    }
}

$user = current_user() ?: $user;
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head">
  <div><span class="eyebrow">Admin</span><h1>Settings</h1></div>
  <a class="close-page" href="<?= url(role_home($user['role'])) ?>" aria-label="Close settings" title="Close settings"><?= icon('x') ?></a>
</section>

<div class="grid two">
  <form class="panel form-grid" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="profile">
    <div class="section-header compact full"><h2>Account Details</h2></div>
    <?php if ($user['role'] === 'municipal_admin'): ?>
      <div class="profile-preview official-profile full">
        <?= avatar(APP_LOGO_PATH, APP_MUNICIPALITY . ' Official Logo', 'avatar large logo-avatar') ?>
        <div>
          <strong><?= e(APP_MUNICIPALITY) ?> Municipal Admin</strong>
          <small>Official logo is used for this account profile</small>
        </div>
      </div>
    <?php elseif ($user['role'] === 'barangay_admin'): ?>
      <div class="profile-preview full">
        <?= avatar($user['profile_photo'] ?? null, $user['name'], 'avatar large') ?>
        <div>
          <strong><?= e($user['name']) ?></strong>
          <small><?= !empty($user['profile_photo']) ? 'Profile photo saved' : 'No profile photo uploaded yet' ?></small>
        </div>
      </div>
      <label class="full">Profile Photo<input type="file" name="profile_photo" accept="image/*"></label>
    <?php endif; ?>
    <label>Full Name<input name="name" value="<?= e($user['name']) ?>" required></label>
    <label>Email<input type="email" name="email" value="<?= e($user['email']) ?>" required></label>
    <label>Contact Number<input name="contact_number" value="<?= e($user['contact_number']) ?>"></label>
    <label>Role<input value="<?= e(ucwords(str_replace('_', ' ', $user['role']))) ?>" disabled></label>
    <?php if ($user['role'] === 'barangay_admin'): ?>
      <label class="full">Assigned Barangay<input value="<?= e($user['barangay_name'] ?? 'Unassigned') ?>" disabled></label>
    <?php endif; ?>
    <button class="button" type="submit"><?= icon('settings') ?><span>Save Settings</span></button>
  </form>

  <form class="panel form-grid" method="post">
    <input type="hidden" name="action" value="password">
    <div class="section-header compact full"><h2>Change Password</h2></div>
    <label class="full">Current Password
      <span class="password-field">
        <input id="currentPassword" type="password" name="current_password" required>
        <button type="button" class="password-toggle icon-button" data-toggle-password data-password-targets="currentPassword" aria-label="Show current password" title="Show current password">
          <span class="icon-show"><?= icon('eye') ?></span>
          <span class="icon-hide"><?= icon('eye-off') ?></span>
        </button>
      </span>
    </label>
    <div class="password-pair full">
      <label>New Password<input id="newPassword" type="password" name="new_password" required></label>
      <label>Confirm New Password<input id="confirmNewPassword" type="password" name="confirm_password" required></label>
      <button type="button" class="password-toggle icon-button" data-toggle-password data-password-targets="newPassword confirmNewPassword" aria-label="Show new passwords" title="Show new passwords">
        <span class="icon-show"><?= icon('eye') ?></span>
        <span class="icon-hide"><?= icon('eye-off') ?></span>
      </button>
    </div>
    <button class="button" type="submit"><?= icon('settings') ?><span>Change Password</span></button>
  </form>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
