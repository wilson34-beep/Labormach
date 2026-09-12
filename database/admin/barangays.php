<?php
$pageTitle = 'Barangay Monitoring';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(admin_roles());
$where = $user['role'] === 'barangay_admin' ? 'WHERE b.id = ' . (int) $user['barangay_id'] : '';
$rows = fetch_all("SELECT b.name,
  COUNT(DISTINCT js.id) job_seekers,
  SUM(CASE WHEN js.employment_status = 'employed' THEN 1 ELSE 0 END) employed,
  SUM(CASE WHEN js.employment_status IN ('unemployed','underemployed') THEN 1 ELSE 0 END) unemployed,
  COUNT(DISTINCT j.id) jobs
  FROM barangays b
  LEFT JOIN users u ON u.barangay_id = b.id AND u.role = 'jobseeker'
  LEFT JOIN job_seekers js ON js.user_id = u.id
  LEFT JOIN jobs j ON j.barangay_id = b.id
  $where
  GROUP BY b.id ORDER BY b.name");
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Employment Data Per Barangay</span><h1>Barangay Employment Monitoring</h1></div></section>
<section class="panel"><div class="table-wrap"><table><thead><tr><th>Barangay</th><th>Job Seekers</th><th>Employed</th><th>Unemployed / Underemployed</th><th>Available Jobs</th></tr></thead><tbody>
<?php foreach ($rows as $row): ?>
  <tr><td><?= e($row['name']) ?></td><td><?= (int) $row['job_seekers'] ?></td><td><?= (int) $row['employed'] ?></td><td><?= (int) $row['unemployed'] ?></td><td><?= (int) $row['jobs'] ?></td></tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>

