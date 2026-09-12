<?php
$pageTitle = 'Reports and Analytics';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['municipal_admin']);
$summary = [
    ['Registered Job Seekers', fetch_one("SELECT COUNT(*) total FROM users WHERE role='jobseeker'")['total']],
    ['Registered Employers', fetch_one("SELECT COUNT(*) total FROM users WHERE role='employer'")['total']],
    ['Job Vacancies', fetch_one('SELECT COALESCE(SUM(vacancies),0) total FROM jobs WHERE status IN ("approved","active")')['total']],
    ['Applicants', fetch_one('SELECT COUNT(*) total FROM applications')['total']],
    ['Hired Applicants', fetch_one("SELECT COUNT(*) total FROM applications WHERE status='hired'")['total']],
];
if (($_GET['export'] ?? '') === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="labormatch-report.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Metric', 'Value']);
    foreach ($summary as $row) {
        fputcsv($out, $row);
    }
    exit;
}
$skills = fetch_all('SELECT category, COUNT(*) total FROM skills GROUP BY category ORDER BY total DESC');
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Analytics</span><h1>Reports and Analytics</h1></div><a class="button" href="<?= url('admin/reports.php?export=csv') ?>">Export CSV</a></section>
<div class="stat-grid"><?php foreach ($summary as $row): ?><article class="stat"><span><?= e($row[0]) ?></span><strong><?= (int) $row[1] ?></strong></article><?php endforeach; ?></div>
<section class="panel"><h2>Most In-Demand Skills Categories</h2><?php foreach ($skills as $skill): ?><div class="bar-row"><span><?= e($skill['category']) ?></span><div><b style="width: <?= min(100, (int) $skill['total'] * 12) ?>%"></b></div><strong><?= (int) $skill['total'] ?></strong></div><?php endforeach; ?></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>

