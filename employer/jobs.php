<?php
$pageTitle = 'Employer Job Posting';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['employer']);
$sectionLastViewedAt = badge_opened((int) $user['id'], 'employer/jobs.php');
$employer = fetch_one('SELECT * FROM employers WHERE user_id = ?', [(int) $user['id']]);
if (!$employer) {
    redirect('employer/company.php');
}
$barangays = fetch_all('SELECT * FROM barangays ORDER BY name');
$editJob = !empty($_GET['edit']) ? fetch_one('SELECT * FROM jobs WHERE id = ? AND employer_id = ?', [(int) $_GET['edit'], $employer['id']]) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save';
    $jobId = (int) ($_POST['job_id'] ?? 0);
    if ($action === 'delete') {
        execute_sql('DELETE FROM jobs WHERE id = ? AND employer_id = ?', [$jobId, $employer['id']]);
        flash('success', 'Job deleted.');
        redirect('employer/jobs.php');
    }
    if ($action === 'close') {
        execute_sql("UPDATE jobs SET status = 'closed', updated_at = NOW() WHERE id = ? AND employer_id = ?", [$jobId, $employer['id']]);
        flash('success', 'Job closed.');
        redirect('employer/jobs.php');
    }
    $status = $action === 'submit' ? 'pending' : 'draft';
    $params = [
        (int) $_POST['barangay_id'], trim($_POST['title']), trim($_POST['description']), trim($_POST['category']), trim($_POST['required_skills']),
        trim($_POST['education_requirement']), (int) $_POST['experience_years'], (float) $_POST['salary_min'], (float) $_POST['salary_max'],
        $_POST['employment_type'], (int) $_POST['vacancies'], trim($_POST['location']), trim($_POST['contact_info']), $_POST['deadline'] ?: null, $status
    ];
    if ($jobId > 0) {
        $params[] = $jobId;
        $params[] = $employer['id'];
        execute_sql('UPDATE jobs SET barangay_id=?, title=?, description=?, category=?, required_skills=?, education_requirement=?, experience_years=?, salary_min=?, salary_max=?, employment_type=?, vacancies=?, location=?, contact_info=?, deadline=?, status=?, updated_at=NOW() WHERE id=? AND employer_id=?', $params);
    } else {
        array_unshift($params, $employer['id']);
        execute_sql('INSERT INTO jobs (employer_id, barangay_id, title, description, category, required_skills, education_requirement, experience_years, salary_min, salary_max, employment_type, vacancies, location, contact_info, deadline, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $params);
    }
    if ($action === 'submit') {
        notify_users_by_role(['municipal_admin', 'barangay_admin'], 'New job post for approval', $employer['business_name'] . ' submitted "' . trim($_POST['title']) . '" for review.', (int) $_POST['barangay_id']);
    }
    log_activity((int) $user['id'], 'job_save', 'Saved job post.');
    flash('success', $action === 'submit' ? 'Job submitted for municipal approval.' : 'Job saved as draft.');
    redirect('employer/jobs.php');
}
$jobs = fetch_all('SELECT j.*, COALESCE(j.updated_at, j.created_at) AS changed_at, b.name AS barangay_name FROM jobs j LEFT JOIN barangays b ON b.id = j.barangay_id WHERE employer_id = ? ORDER BY created_at DESC', [$employer['id']]);
$job = $editJob ?: ['id' => 0, 'barangay_id' => '', 'title' => '', 'description' => '', 'category' => '', 'required_skills' => '', 'education_requirement' => '', 'experience_years' => 0, 'salary_min' => '', 'salary_max' => '', 'employment_type' => 'Full-Time', 'vacancies' => 1, 'location' => APP_MUNICIPALITY, 'contact_info' => $user['contact_number'], 'deadline' => ''];
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Employer</span><h1>Job Posting</h1></div></section>
<form class="panel form-grid" method="post">
  <input type="hidden" name="job_id" value="<?= (int) $job['id'] ?>">
  <label>Job Title<input name="title" value="<?= e($job['title']) ?>" required></label>
  <label>Category<input name="category" value="<?= e($job['category']) ?>" required></label>
  <label>Barangay<select name="barangay_id"><?php foreach ($barangays as $barangay): ?><option value="<?= (int) $barangay['id'] ?>" <?= selected((string) $job['barangay_id'], (string) $barangay['id']) ?>><?= e($barangay['name']) ?></option><?php endforeach; ?></select></label>
  <label>Employment Type<select name="employment_type"><?php foreach (['Full-Time','Part-Time','Contractual','Temporary','Internship','Work From Home'] as $type): ?><option <?= selected($job['employment_type'], $type) ?>><?= e($type) ?></option><?php endforeach; ?></select></label>
  <label>Required Skills<input name="required_skills" value="<?= e($job['required_skills']) ?>"></label>
  <label>Education Requirement<input name="education_requirement" value="<?= e($job['education_requirement']) ?>"></label>
  <label>Experience Years<input type="number" name="experience_years" value="<?= (int) $job['experience_years'] ?>"></label>
  <label>Number of Vacancies<input type="number" name="vacancies" value="<?= (int) $job['vacancies'] ?>"></label>
  <label>Salary Min<input type="number" step="0.01" name="salary_min" value="<?= e((string) $job['salary_min']) ?>"></label>
  <label>Salary Max<input type="number" step="0.01" name="salary_max" value="<?= e((string) $job['salary_max']) ?>"></label>
  <label>Work Location<input name="location" value="<?= e($job['location']) ?>"></label>
  <label>Application Deadline<input type="date" name="deadline" value="<?= e($job['deadline']) ?>"></label>
  <label class="full">Contact Information<input name="contact_info" value="<?= e($job['contact_info']) ?>"></label>
  <label class="full">Job Description<textarea name="description" rows="5" required><?= e($job['description']) ?></textarea></label>
  <div class="full actions"><button class="button secondary" name="action" value="save">Save Draft</button><button class="button" name="action" value="submit">Submit for Approval</button></div>
</form>
<section class="panel"><h2>Manage Jobs</h2><div class="table-wrap"><table><thead><tr><th>Job</th><th>Barangay</th><th>Status</th><th>Deadline</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($jobs as $item): ?>
  <tr><td><?= item_new_dot($item['changed_at'] ?? null, $sectionLastViewedAt) ?><?= e($item['title']) ?><br><small><?= e($item['category']) ?></small></td><td><?= e($item['barangay_name']) ?></td><td><?= status_badge($item['status']) ?></td><td><?= e($item['deadline']) ?></td><td class="actions-cell"><a class="mini" href="<?= url('employer/jobs.php?edit=' . (int) $item['id']) ?>">Edit</a><form method="post"><input type="hidden" name="job_id" value="<?= (int) $item['id'] ?>"><button class="mini warning" name="action" value="close">Close</button><button class="mini danger" name="action" value="delete" onclick="return confirm('Delete job?')">Delete</button></form></td></tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
