<?php
require_once __DIR__ . '/../includes/auth.php';
ensure_schema_loaded_message();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $user = fetch_one('SELECT * FROM users WHERE email = ?', [$email]);

    if ($user && password_verify($password, $user['password_hash']) && $user['status'] !== 'suspended') {
        login_user($user);
        redirect(role_home($user['role']));
    }
    flash('error', 'Invalid login credentials or suspended account.');
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - LaborMatch</title>
  <link rel="stylesheet" href="<?= url('assets/css/app.css?v=20260820d') ?>">
</head>
<body class="auth-page">
  <form class="auth-card" method="post">
    <a class="brand public-brand" href="<?= url('index.php') ?>"><img class="brand-logo" src="<?= url(APP_LOGO_PATH) ?>" alt="<?= APP_MUNICIPALITY ?> official seal"><strong>LaborMatch</strong><small><?= APP_MUNICIPALITY ?>, <?= APP_PROVINCE ?></small></a>
    <?php require __DIR__ . '/../includes/flash.php'; ?>
    <h1>Login</h1>
    <label>Email Address<input type="email" name="email" required></label>
    <label>Password
      <span class="password-field">
        <input id="loginPassword" type="password" name="password" required>
        <button type="button" class="password-toggle icon-button" data-toggle-password data-password-targets="loginPassword" aria-label="Show password" title="Show password">
          <span class="icon-show"><?= icon('eye') ?></span>
          <span class="icon-hide"><?= icon('eye-off') ?></span>
        </button>
      </span>
    </label>
    <button class="button" type="submit"><?= icon('log-in') ?><span>Login</span></button>
    <a href="<?= url('auth/register.php') ?>">Create an account</a>
  </form>
  <script src="<?= url('assets/js/app.js?v=20260820d') ?>"></script>
</body>
</html>
