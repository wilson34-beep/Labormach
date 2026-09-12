<?php
$pageTitle = 'Announcements';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(admin_roles());
$sectionLastViewedAt = badge_opened((int) $user['id'], 'admin/announcements.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    execute_sql('INSERT INTO announcements (created_by, title, message, audience) VALUES (?, ?, ?, ?)', [(int) $user['id'], trim($_POST['title']), trim($_POST['message']), $_POST['audience']]);
    log_activity((int) $user['id'], 'announcement_create', trim($_POST['title']));
    flash('success', 'Announcement posted.');
    redirect('admin/announcements.php');
}
$items = fetch_all('SELECT a.*, u.name AS author FROM announcements a LEFT JOIN users u ON u.id = a.created_by ORDER BY a.created_at DESC');
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Notices</span><h1>Announcements</h1></div></section>
<form class="panel form-grid" method="post"><label>Title<input name="title" required></label><label>Audience<select name="audience"><option value="public">Public</option><option value="all">All</option><option value="employer">Employer</option><option value="jobseeker">Job Seeker</option><option value="admin">Admin</option></select></label><label class="full">Message<textarea name="message" rows="4" required></textarea></label><button class="button" type="submit">Publish</button></form>
<div class="card-grid"><?php foreach ($items as $item): ?><article class="card"><span class="badge neutral"><?= e($item['audience']) ?></span><h3><?= item_new_dot($item['created_at'] ?? null, $sectionLastViewedAt) ?><?= e($item['title']) ?></h3><p><?= e($item['message']) ?></p><small><?= e($item['author'] ?? 'System') ?> | <?= e($item['created_at']) ?></small></article><?php endforeach; ?></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
