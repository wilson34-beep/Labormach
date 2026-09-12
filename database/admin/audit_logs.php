<?php
$pageTitle = 'Audit Logs';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['municipal_admin']);
$sectionLastViewedAt = badge_opened((int) $user['id'], 'admin/audit_logs.php');
$logs = fetch_all('SELECT l.*, u.name FROM activity_logs l LEFT JOIN users u ON u.id = l.user_id ORDER BY l.created_at DESC LIMIT 200');
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Security</span><h1>Audit Logs</h1></div></section>
<section class="panel"><div class="table-wrap"><table><thead><tr><th>Date</th><th>User</th><th>Action</th><th>Details</th></tr></thead><tbody><?php foreach ($logs as $log): ?><tr><td><?= item_new_dot($log['created_at'] ?? null, $sectionLastViewedAt) ?><?= e($log['created_at']) ?></td><td><?= e($log['name'] ?? 'System') ?></td><td><?= e($log['action']) ?></td><td><?= e($log['details']) ?></td></tr><?php endforeach; ?></tbody></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
