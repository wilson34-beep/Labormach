<?php
$pageTitle = 'Training Management';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['municipal_admin']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    execute_sql('INSERT INTO trainings (title, provider, category, description, slots, location, status, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [
        trim($_POST['title']), trim($_POST['provider']), trim($_POST['category']), trim($_POST['description']), (int) $_POST['slots'], trim($_POST['location']), $_POST['status'], $_POST['start_date'] ?: null, $_POST['end_date'] ?: null
    ]);
    log_activity((int) $user['id'], 'training_create', 'Created training ' . trim($_POST['title']));
    flash('success', 'Training program added.');
    redirect('admin/trainings.php');
}
$trainings = fetch_all('SELECT * FROM trainings ORDER BY created_at DESC');
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Training and Certification</span><h1>Training Management</h1></div></section>
<form class="panel form-grid" method="post">
  <label>Title<input name="title" required></label><label>Provider<input name="provider" required></label><label>Category<input name="category" required></label><label>Slots<input type="number" name="slots" value="25"></label>
  <label>Location<input name="location" value="General MacArthur"></label><label>Status<select name="status"><option value="open">Open</option><option value="closed">Closed</option><option value="completed">Completed</option></select></label>
  <label>Start Date<input type="date" name="start_date"></label><label>End Date<input type="date" name="end_date"></label><label class="full">Description<textarea name="description" rows="3"></textarea></label>
  <button class="button" type="submit">Add Training</button>
</form>
<section class="panel"><div class="table-wrap"><table><thead><tr><th>Program</th><th>Provider</th><th>Slots</th><th>Status</th><th>Schedule</th></tr></thead><tbody>
<?php foreach ($trainings as $training): ?>
  <tr><td><?= e($training['title']) ?><br><small><?= e($training['category']) ?></small></td><td><?= e($training['provider']) ?></td><td><?= (int) $training['slots'] ?></td><td><?= status_badge($training['status']) ?></td><td><?= e($training['start_date']) ?> - <?= e($training['end_date']) ?></td></tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>

