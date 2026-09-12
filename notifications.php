<?php
$pageTitle = 'Notifications';
require_once __DIR__ . '/includes/auth.php';
$user = require_login();

$allowedFilters = ['all', 'unread', 'read'];
$filter = $_GET['filter'] ?? 'all';
if (!in_array($filter, $allowedFilters, true)) {
    $filter = 'all';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $notificationId = (int) ($_POST['notification_id'] ?? 0);

    if ($action === 'mark_read' && $notificationId > 0) {
        execute_sql('UPDATE notifications SET is_read = 1, is_seen = 1 WHERE id = ? AND user_id = ?', [$notificationId, (int) $user['id']]);
        flash('success', 'Notification marked as read.');
    } elseif ($action === 'mark_unread' && $notificationId > 0) {
        execute_sql('UPDATE notifications SET is_read = 0, is_seen = 1 WHERE id = ? AND user_id = ?', [$notificationId, (int) $user['id']]);
        flash('success', 'Notification marked as unread.');
    } elseif ($action === 'mark_all_read') {
        execute_sql('UPDATE notifications SET is_read = 1, is_seen = 1 WHERE user_id = ?', [(int) $user['id']]);
        flash('success', 'All notifications marked as read.');
    } elseif ($action === 'mark_all_unread') {
        execute_sql('UPDATE notifications SET is_read = 0, is_seen = 1 WHERE user_id = ?', [(int) $user['id']]);
        flash('success', 'All notifications marked as unread.');
    } elseif ($action === 'delete' && $notificationId > 0) {
        execute_sql('DELETE FROM notifications WHERE id = ? AND user_id = ?', [$notificationId, (int) $user['id']]);
        flash('success', 'Notification deleted.');
    } elseif ($action === 'delete_all') {
        execute_sql('DELETE FROM notifications WHERE user_id = ?', [(int) $user['id']]);
        flash('success', 'All notifications deleted.');
    }

    redirect('notifications.php?filter=' . urlencode($filter));
}

execute_sql('UPDATE notifications SET is_seen = 1 WHERE user_id = ?', [(int) $user['id']]);

$where = 'WHERE user_id = ?';
$params = [(int) $user['id']];
if ($filter === 'unread') {
    $where .= ' AND is_read = 0';
} elseif ($filter === 'read') {
    $where .= ' AND is_read = 1';
}

$counts = fetch_one('SELECT COUNT(*) total, SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) unread, SUM(CASE WHEN is_read = 1 THEN 1 ELSE 0 END) read_total FROM notifications WHERE user_id = ?', [(int) $user['id']]) ?: ['total' => 0, 'unread' => 0, 'read_total' => 0];
$items = fetch_all("SELECT * FROM notifications $where ORDER BY is_read ASC, created_at DESC", $params);
require __DIR__ . '/includes/page_start.php';
?>
<section class="page-head">
  <div><span class="eyebrow">Alerts</span><h1>Notifications</h1></div>
  <div class="actions">
    <a class="close-page" href="<?= url(role_home($user['role'])) ?>" aria-label="Close notifications" title="Close notifications"><?= icon('x') ?></a>
    <form class="inline-form" method="post">
      <input type="hidden" name="action" value="mark_all_read">
      <button class="mini success" type="submit">Mark All Read</button>
    </form>
    <form class="inline-form" method="post">
      <input type="hidden" name="action" value="mark_all_unread">
      <button class="mini warning" type="submit">Mark All Unread</button>
    </form>
    <form class="inline-form" method="post">
      <input type="hidden" name="action" value="delete_all">
      <button class="mini danger" type="submit" data-confirm="Delete all notifications? This cannot be undone." data-confirm-title="Delete All Notifications" data-confirm-action="Delete All">Delete All</button>
    </form>
  </div>
</section>

<?php require __DIR__ . '/includes/flash.php'; ?>

<section class="panel notification-toolbar">
  <div class="actions">
    <a class="mini <?= $filter === 'all' ? 'active' : '' ?>" href="<?= url('notifications.php?filter=all') ?>">All</a>
    <a class="mini <?= $filter === 'unread' ? 'active' : '' ?>" href="<?= url('notifications.php?filter=unread') ?>">Unread</a>
    <a class="mini <?= $filter === 'read' ? 'active' : '' ?>" href="<?= url('notifications.php?filter=read') ?>">Read</a>
  </div>
</section>

<div class="notification-list">
  <?php foreach ($items as $item): ?>
    <?php $isUnread = (int) $item['is_read'] === 0; ?>
    <article class="card notification-card <?= $isUnread ? 'is-unread' : '' ?>">
      <div class="section-header compact">
        <div>
          <div class="notification-title">
            <?php if ($isUnread): ?><span class="unread-dot" aria-label="Unread notification"></span><?php endif; ?>
            <h3><?= e($item['title']) ?></h3>
          </div>
          <small><?= e($item['created_at']) ?></small>
        </div>
        <?= status_badge($isUnread ? 'unread' : 'read') ?>
      </div>
      <p><?= e($item['message']) ?></p>
      <form class="inline-form" method="post">
        <input type="hidden" name="notification_id" value="<?= (int) $item['id'] ?>">
        <?php if ($isUnread): ?>
          <button class="mini success" type="submit" name="action" value="mark_read">Mark Read</button>
        <?php else: ?>
          <button class="mini warning" type="submit" name="action" value="mark_unread">Mark Unread</button>
        <?php endif; ?>
        <button class="mini danger" type="submit" name="action" value="delete" data-confirm="Delete this notification? This cannot be undone." data-confirm-title="Delete Notification" data-confirm-action="Delete">Delete</button>
      </form>
    </article>
  <?php endforeach; ?>
  <?php if (!$items): ?>
    <article class="card"><h3>No notifications</h3><p>New alerts and account updates will appear here.</p></article>
  <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
