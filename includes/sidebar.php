<?php
$user = $user ?? current_user();
$role = $user['role'] ?? 'guest';
$nav = [];
$accountImage = null;
$navCounts = [];
if ($role === 'municipal_admin') {
    $accountImage = APP_LOGO_PATH;
    $nav = [
        'admin/dashboard.php' => 'Dashboard',
        'admin/users.php' => 'Job Seekers',
        'admin/barangay_admins.php' => 'Barangay Admins',
        'admin/employers.php' => 'Employers',
        'admin/jobs.php' => 'Job Management',
        'admin/applications.php' => 'Applications',
        'admin/skills.php' => 'Skills Database',
        'admin/trainings.php' => 'Training',
        'admin/barangays.php' => 'Barangay Monitoring',
        'admin/reports.php' => 'Reports',
        'admin/announcements.php' => 'Announcements',
        'admin/audit_logs.php' => 'Audit Logs',
    ];
    $navCounts = [
        'admin/users.php' => badge_count_new((int) $user['id'], 'admin/users.php', "SELECT COUNT(*) total FROM users u LEFT JOIN job_seekers js ON js.user_id = u.id WHERE u.role = 'jobseeker' AND (u.status IN ('pending','active') OR js.verification_status = 'pending') AND GREATEST(COALESCE(u.updated_at, u.created_at, '1970-01-01 00:00:00'), COALESCE(js.updated_at, js.created_at, '1970-01-01 00:00:00')) > ?"),
        'admin/barangay_admins.php' => badge_count_new((int) $user['id'], 'admin/barangay_admins.php', "SELECT COUNT(*) total FROM users WHERE role = 'barangay_admin' AND status IN ('pending','active') AND COALESCE(updated_at, created_at) > ?"),
        'admin/employers.php' => badge_count_new((int) $user['id'], 'admin/employers.php', "SELECT COUNT(*) total FROM employers e JOIN users u ON u.id = e.user_id WHERE e.verification_status = 'pending' AND GREATEST(COALESCE(e.updated_at, e.created_at, '1970-01-01 00:00:00'), COALESCE(u.updated_at, u.created_at, '1970-01-01 00:00:00')) > ?"),
        'admin/jobs.php' => badge_count_new((int) $user['id'], 'admin/jobs.php', "SELECT COUNT(*) total FROM jobs WHERE status = 'pending' AND COALESCE(updated_at, created_at) > ?"),
        'admin/applications.php' => badge_count_new((int) $user['id'], 'admin/applications.php', "SELECT COUNT(*) total FROM applications WHERE status IN ('applied','screening','shortlisted','interview') AND COALESCE(updated_at, created_at) > ?"),
        'admin/audit_logs.php' => badge_count_new((int) $user['id'], 'admin/audit_logs.php', 'SELECT COUNT(*) total FROM activity_logs WHERE DATE(created_at) = CURDATE() AND created_at > ?'),
        'notifications.php' => (int) fetch_one('SELECT COUNT(*) total FROM notifications WHERE user_id = ? AND is_seen = 0', [(int) $user['id']])['total'],
    ];
} elseif ($role === 'barangay_admin') {
    $barangayId = (int) ($user['barangay_id'] ?? 0);
    $accountImage = $user['profile_photo'] ?? null;
    $nav = [
        'admin/dashboard.php' => 'Dashboard',
        'admin/users.php' => 'Barangay Job Seekers',
        'admin/applications.php' => 'Applications',
        'admin/barangays.php' => 'Barangay Monitoring',
        'admin/announcements.php' => 'Announcements',
    ];
    $navCounts = [
        'admin/users.php' => badge_count_new((int) $user['id'], 'admin/users.php', "SELECT COUNT(*) total FROM users u LEFT JOIN job_seekers js ON js.user_id = u.id WHERE u.role = 'jobseeker' AND u.barangay_id = ? AND (u.status IN ('pending','active') OR js.verification_status = 'pending') AND GREATEST(COALESCE(u.updated_at, u.created_at, '1970-01-01 00:00:00'), COALESCE(js.updated_at, js.created_at, '1970-01-01 00:00:00')) > ?", [$barangayId]),
        'admin/applications.php' => badge_count_new((int) $user['id'], 'admin/applications.php', "SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE j.barangay_id = ? AND a.status IN ('applied','screening','shortlisted','interview') AND COALESCE(a.updated_at, a.created_at) > ?", [$barangayId]),
        'admin/announcements.php' => badge_count_new((int) $user['id'], 'admin/announcements.php', "SELECT COUNT(*) total FROM announcements WHERE audience IN ('public','all','admin') AND created_at > ?"),
        'notifications.php' => (int) fetch_one('SELECT COUNT(*) total FROM notifications WHERE user_id = ? AND is_seen = 0', [(int) $user['id']])['total'],
    ];
} elseif ($role === 'employer') {
    $accountImage = fetch_one('SELECT logo_path FROM employers WHERE user_id = ?', [(int) $user['id']])['logo_path'] ?? null;
    $sidebarEmployer = fetch_one('SELECT id FROM employers WHERE user_id = ?', [(int) $user['id']]);
    $employerId = (int) ($sidebarEmployer['id'] ?? 0);
    $nav = [
        'employer/dashboard.php' => 'Dashboard',
        'employer/company.php' => 'Company Profile',
        'employer/jobs.php' => 'Job Posting',
        'employer/applicants.php' => 'Applicants',
        'employer/interviews.php' => 'Interviews',
    ];
    $navCounts = [
        'employer/jobs.php' => badge_count_new((int) $user['id'], 'employer/jobs.php', "SELECT COUNT(*) total FROM jobs WHERE employer_id = ? AND status IN ('draft','pending','rejected') AND COALESCE(updated_at, created_at) > ?", [$employerId]),
        'employer/applicants.php' => badge_count_new((int) $user['id'], 'employer/applicants.php', "SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE j.employer_id = ? AND a.status IN ('applied','screening','shortlisted') AND COALESCE(a.updated_at, a.created_at) > ?", [$employerId]),
        'employer/interviews.php' => badge_count_new((int) $user['id'], 'employer/interviews.php', "SELECT COUNT(*) total FROM applications a JOIN jobs j ON j.id = a.job_id WHERE j.employer_id = ? AND a.status = 'interview' AND COALESCE(a.updated_at, a.created_at) > ?", [$employerId]),
        'notifications.php' => (int) fetch_one('SELECT COUNT(*) total FROM notifications WHERE user_id = ? AND is_seen = 0', [(int) $user['id']])['total'],
    ];
} elseif ($role === 'jobseeker') {
    $sidebarSeeker = fetch_one('SELECT id, profile_photo FROM job_seekers WHERE user_id = ?', [(int) $user['id']]);
    $accountImage = $sidebarSeeker['profile_photo'] ?? null;
    $seekerId = (int) ($sidebarSeeker['id'] ?? 0);
    $nav = [
        'jobseeker/dashboard.php' => 'Dashboard',
        'jobseeker/jobs.php' => 'Find Jobs',
        'jobseeker/recommended.php' => 'Recommended Jobs',
        'jobseeker/applications.php' => 'Applications',
        'jobseeker/saved_jobs.php' => 'Saved Jobs',
        'jobseeker/training.php' => 'Training',
    ];
    $navCounts = [
        'jobseeker/applications.php' => badge_count_new((int) $user['id'], 'jobseeker/applications.php', "SELECT COUNT(*) total FROM applications WHERE jobseeker_id = ? AND status IN ('applied','screening','shortlisted','interview') AND COALESCE(updated_at, created_at) > ?", [$seekerId]),
        'jobseeker/saved_jobs.php' => badge_count_new((int) $user['id'], 'jobseeker/saved_jobs.php', 'SELECT COUNT(*) total FROM saved_jobs WHERE jobseeker_id = ? AND created_at > ?', [$seekerId]),
        'jobseeker/training.php' => badge_count_new((int) $user['id'], 'jobseeker/training.php', "SELECT COUNT(*) total FROM trainings WHERE status = 'open' AND created_at > ?"),
        'notifications.php' => (int) fetch_one('SELECT COUNT(*) total FROM notifications WHERE user_id = ? AND is_seen = 0', [(int) $user['id']])['total'],
    ];
}
$navIcons = [
    'admin/dashboard.php' => 'dashboard',
    'admin/users.php' => 'users',
    'admin/barangay_admins.php' => 'user-plus',
    'admin/employers.php' => 'building',
    'admin/jobs.php' => 'briefcase',
    'admin/applications.php' => 'file',
    'admin/skills.php' => 'spark',
    'admin/trainings.php' => 'graduation',
    'admin/barangays.php' => 'map',
    'admin/reports.php' => 'chart',
    'admin/announcements.php' => 'megaphone',
    'admin/audit_logs.php' => 'activity',
    'notifications.php' => 'bell',
    'admin/settings.php' => 'settings',
    'employer/dashboard.php' => 'dashboard',
    'employer/company.php' => 'building',
    'employer/jobs.php' => 'briefcase',
    'employer/applicants.php' => 'users',
    'employer/interviews.php' => 'bell',
    'jobseeker/dashboard.php' => 'dashboard',
    'jobseeker/profile.php' => 'users',
    'jobseeker/jobs.php' => 'briefcase',
    'jobseeker/recommended.php' => 'spark',
    'jobseeker/applications.php' => 'file',
    'jobseeker/saved_jobs.php' => 'briefcase',
    'jobseeker/training.php' => 'graduation',
];
$notificationCount = (int) ($navCounts['notifications.php'] ?? 0);
$accountType = ucwords(str_replace('_', ' ', $role));
$accountSettingsPath = match ($role) {
    'municipal_admin', 'barangay_admin' => 'admin/settings.php',
    'employer' => 'employer/company.php',
    'jobseeker' => 'jobseeker/profile.php',
    default => 'index.php',
};
$accountSettingsLabel = $role === 'jobseeker' ? 'My Profile' : 'Settings';
$accountAvatarClass = in_array($role, ['municipal_admin', 'employer'], true) ? 'avatar logo-avatar' : 'avatar';
?>
<aside class="sidebar">
  <a class="brand" href="<?= url(role_home($role)) ?>">
    <img class="brand-logo" src="<?= url(APP_LOGO_PATH) ?>" alt="<?= APP_MUNICIPALITY ?> official seal">
    <strong>LaborMatch</strong>
    <small><?= APP_MUNICIPALITY ?>, <?= APP_PROVINCE ?></small>
  </a>
  <nav>
    <?php foreach ($nav as $path => $label): ?>
      <?php $count = (int) ($navCounts[$path] ?? 0); ?>
      <a href="<?= url($path) ?>"><?= icon($navIcons[$path] ?? 'spark') ?><span class="nav-label"><?= e($label) ?></span><?php if ($count > 0): ?><span class="nav-count"><?= $count > 99 ? '99+' : $count ?></span><?php endif; ?></a>
    <?php endforeach; ?>
  </nav>
</aside>
<main class="main">
  <header class="topbar">
    <div></div>
    <div class="topbar-actions">
      <a class="top-icon-button" href="<?= url('notifications.php') ?>" aria-label="Notifications" title="Notifications">
        <?= icon('bell') ?>
        <?php if ($notificationCount > 0): ?><span class="nav-count"><?= $notificationCount > 99 ? '99+' : $notificationCount ?></span><?php endif; ?>
      </a>
      <div class="account-menu">
        <button class="account-toggle" type="button" data-account-toggle aria-expanded="false" aria-haspopup="true">
          <?= avatar($accountImage, $user['name'] ?? 'Guest', $accountAvatarClass) ?>
          <span>
            <strong><?= e($user['name'] ?? 'Guest') ?></strong>
            <small><?= e($accountType) ?></small>
          </span>
        </button>
        <div class="account-dropdown" data-account-dropdown>
          <a href="<?= url($accountSettingsPath) ?>"><?= icon($role === 'jobseeker' ? 'users' : 'settings') ?><span><?= e($accountSettingsLabel) ?></span></a>
          <a href="<?= url('auth/logout.php') ?>" data-confirm="Are you sure you want to logout from LaborMatch?" data-confirm-title="Confirm Logout" data-confirm-action="Logout"><?= icon('log-out') ?><span>Logout</span></a>
        </div>
      </div>
    </div>
  </header>
