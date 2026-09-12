<?php
$pageTitle = 'Skills Database';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['municipal_admin']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['action'] ?? '') === 'add') {
        execute_sql('INSERT IGNORE INTO skills (category, name) VALUES (?, ?)', [trim($_POST['category'] ?? ''), trim($_POST['name'] ?? '')]);
        flash('success', 'Skill added.');
    } elseif (($_POST['action'] ?? '') === 'delete') {
        execute_sql('DELETE FROM skills WHERE id = ?', [(int) $_POST['skill_id']]);
        flash('success', 'Skill deleted.');
    }
    redirect('admin/skills.php');
}
$skills = fetch_all('SELECT * FROM skills ORDER BY category, name');
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Centralized Skills</span><h1>Skills Database</h1></div></section>
<form class="panel form-grid" method="post"><input type="hidden" name="action" value="add"><label>Category<input name="category" required></label><label>Skill Name<input name="name" required></label><button class="button" type="submit">Add Skill</button></form>
<section class="panel"><div class="table-wrap"><table><thead><tr><th>Category</th><th>Skill</th><th>Action</th></tr></thead><tbody>
<?php foreach ($skills as $skill): ?>
  <tr><td><?= e($skill['category']) ?></td><td><?= e($skill['name']) ?></td><td><form method="post"><input type="hidden" name="skill_id" value="<?= (int) $skill['id'] ?>"><button class="mini danger" name="action" value="delete">Delete</button></form></td></tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>

