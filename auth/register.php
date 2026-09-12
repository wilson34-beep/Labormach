<?php
require_once __DIR__ . '/../includes/auth.php';
ensure_schema_loaded_message();
$barangays = fetch_all('SELECT * FROM barangays ORDER BY name');
$role = in_array($_GET['role'] ?? '', ['employer', 'jobseeker'], true) ? $_GET['role'] : 'jobseeker';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = in_array($_POST['role'] ?? '', ['employer', 'jobseeker'], true) ? $_POST['role'] : 'jobseeker';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $barangayId = (int) ($_POST['barangay_id'] ?? 0);

    if ($name === '' || $email === '' || strlen($password) < 6) {
        flash('error', 'Please complete all required fields. Password must be at least 6 characters.');
    } elseif ($password !== $confirmPassword) {
        flash('error', 'Password confirmation does not match.');
    } elseif (fetch_one('SELECT id FROM users WHERE email = ?', [$email])) {
        flash('error', 'Email is already registered.');
    } else {
        db()->beginTransaction();
        try {
            execute_sql(
                'INSERT INTO users (barangay_id, name, email, password_hash, role, contact_number, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())',
                [$barangayId ?: null, $name, $email, password_hash($password, PASSWORD_DEFAULT), $role, trim($_POST['contact_number'] ?? ''), $role === 'jobseeker' ? 'active' : 'pending']
            );
            $userId = (int) db()->lastInsertId();
            if ($role === 'employer') {
                $businessName = trim($_POST['business_name'] ?? $name);
                execute_sql(
                    'INSERT INTO employers (user_id, business_name, business_address, business_type, industry, contact_person, verification_status) VALUES (?, ?, ?, ?, ?, ?, ?)',
                    [$userId, $businessName, trim($_POST['business_address'] ?? ''), trim($_POST['business_type'] ?? ''), trim($_POST['industry'] ?? ''), $name, 'pending']
                );
                notify_users_by_role(['municipal_admin'], 'New employer account', $businessName . ' registered and is waiting for verification.');
                notify_user($userId, 'Registration received', 'Your employer account was created. Please complete your company profile for verification.');
            } else {
                execute_sql(
                    'INSERT INTO job_seekers (user_id, address, education, employment_status, skills, verification_status) VALUES (?, ?, ?, ?, ?, ?)',
                    [$userId, trim($_POST['address'] ?? ''), trim($_POST['education'] ?? ''), 'unemployed', trim($_POST['skills'] ?? ''), 'pending']
                );
                notify_users_by_role(['municipal_admin', 'barangay_admin'], 'New job seeker account', $name . ' registered and is waiting for profile verification.', $barangayId ?: null);
                notify_user($userId, 'Registration received', 'Your job seeker account was created. Please complete your profile for verification.');
            }
            log_activity($userId, 'register', 'New ' . $role . ' account registered.');
            db()->commit();
            flash('success', 'Registration successful. You can now log in.');
            redirect('auth/login.php');
        } catch (Throwable $exception) {
            db()->rollBack();
            flash('error', 'Registration failed: ' . $exception->getMessage());
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - LaborMatch</title>
  <link rel="stylesheet" href="<?= url('assets/css/app.css?v=20260820d') ?>">
</head>
<body class="auth-page">
  <form class="auth-card wide" method="post">
    <a class="brand public-brand" href="<?= url('index.php') ?>"><img class="brand-logo" src="<?= url(APP_LOGO_PATH) ?>" alt="<?= APP_MUNICIPALITY ?> official seal"><strong>LaborMatch</strong><small><?= APP_MUNICIPALITY ?>, <?= APP_PROVINCE ?></small></a>
    <?php require __DIR__ . '/../includes/flash.php'; ?>
    <h1>Register</h1>
    <div class="form-grid">
      <label>Account Type
        <select name="role" id="roleSelect">
          <option value="jobseeker" <?= selected($role, 'jobseeker') ?>>Job Seeker</option>
          <option value="employer" <?= selected($role, 'employer') ?>>Employer</option>
        </select>
      </label>
      <label>Barangay
        <select name="barangay_id">
          <?php foreach ($barangays as $barangay): ?>
            <option value="<?= (int) $barangay['id'] ?>"><?= e($barangay['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label>Full Name / Contact Person<input name="name" required></label>
      <label>Email<input type="email" name="email" required></label>
      <label>Contact Number<input name="contact_number"></label>
      <div class="password-pair full">
        <label>Password<input id="registerPassword" type="password" name="password" required></label>
        <label>Confirm Password<input id="registerConfirmPassword" type="password" name="confirm_password" required></label>
        <button type="button" class="password-toggle icon-button" data-toggle-password data-password-targets="registerPassword registerConfirmPassword" aria-label="Show passwords" title="Show passwords">
          <span class="icon-show"><?= icon('eye') ?></span>
          <span class="icon-hide"><?= icon('eye-off') ?></span>
        </button>
      </div>
      <label class="jobseeker-only">Address<input name="address"></label>
      <label class="jobseeker-only">Education<input name="education" placeholder="College, Vocational, High School"></label>
      <label class="jobseeker-only full">Skills<textarea name="skills" rows="3" placeholder="Masonry, Carpentry"></textarea></label>
      <label class="employer-only">Business Name<input name="business_name"></label>
      <label class="employer-only">Industry<input name="industry"></label>
      <label class="employer-only">Business Type<input name="business_type"></label>
      <label class="employer-only">Business Address<input name="business_address"></label>
    </div>
    <button class="button" type="submit"><?= icon('user-plus') ?><span>Create Account</span></button>
    <a href="<?= url('auth/login.php') ?>">Already have an account?</a>
  </form>
  <script src="<?= url('assets/js/app.js?v=20260820d') ?>"></script>
</body>
</html>
