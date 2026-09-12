<?php
$pageTitle = 'Company Profile';
require_once __DIR__ . '/../includes/auth.php';
$user = require_login(['employer']);
$employer = fetch_one('SELECT * FROM employers WHERE user_id = ?', [(int) $user['id']]);
$employerExists = (bool) $employer;
$employerDefaults = [
    'business_name' => '',
    'business_address' => '',
    'business_type' => '',
    'industry' => '',
    'contact_person' => $user['name'] ?? '',
    'company_description' => '',
    'logo_path' => null,
    'business_permit_path' => null,
    'supporting_document_path' => null,
    'verification_status' => 'pending',
];
$employer = $employerExists ? array_replace($employerDefaults, $employer) : $employerDefaults;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $logo = save_upload('logo', 'logos', ['jpg', 'jpeg', 'png']) ?: ($employer['logo_path'] ?? null);
        $permit = save_upload('business_permit', 'documents', ['jpg', 'jpeg', 'png', 'pdf']) ?: ($employer['business_permit_path'] ?? null);
        $support = save_upload('supporting_document', 'documents', ['jpg', 'jpeg', 'png', 'pdf']) ?: ($employer['supporting_document_path'] ?? null);
        if ($employerExists) {
            execute_sql('UPDATE employers SET business_name=?, business_address=?, business_type=?, industry=?, contact_person=?, company_description=?, logo_path=?, business_permit_path=?, supporting_document_path=?, verification_status=?, updated_at=NOW() WHERE user_id=?', [
                trim($_POST['business_name']), trim($_POST['business_address']), trim($_POST['business_type']), trim($_POST['industry']), trim($_POST['contact_person']), trim($_POST['company_description']), $logo, $permit, $support, 'pending', (int) $user['id']
            ]);
        } else {
            execute_sql('INSERT INTO employers (user_id, business_name, business_address, business_type, industry, contact_person, company_description, logo_path, business_permit_path, supporting_document_path, verification_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                (int) $user['id'], trim($_POST['business_name']), trim($_POST['business_address']), trim($_POST['business_type']), trim($_POST['industry']), trim($_POST['contact_person']), trim($_POST['company_description']), $logo, $permit, $support, 'pending'
            ]);
        }
        execute_sql('UPDATE users SET contact_number=?, updated_at=NOW() WHERE id=?', [trim($_POST['contact_number']), (int) $user['id']]);
        log_activity((int) $user['id'], 'company_update', 'Updated employer company profile.');
        flash('success', 'Company profile submitted for municipal verification.');
        redirect('employer/company.php');
    } catch (Throwable $exception) {
        flash('error', $exception->getMessage());
    }
}
$companyName = trim((string) $employer['business_name']) ?: ($user['name'] ?? 'Employer');
require __DIR__ . '/../includes/page_start.php';
?>
<section class="page-head"><div><span class="eyebrow">Employer Verification</span><h1>Company Profile</h1></div><?= status_badge($employer['verification_status']) ?></section>
<form class="panel form-grid" method="post" enctype="multipart/form-data">
  <div class="profile-preview full">
    <?= avatar($employer['logo_path'] ?? null, $companyName, 'avatar large logo-avatar') ?>
    <div>
      <strong><?= e($companyName) ?></strong>
      <small><?= !empty($employer['logo_path']) ? 'Company logo saved' : 'No company logo uploaded yet' ?></small>
    </div>
  </div>
  <label>Business Name<input name="business_name" value="<?= e($employer['business_name']) ?>" required></label>
  <label>Industry<input name="industry" value="<?= e($employer['industry']) ?>"></label>
  <label>Business Type<input name="business_type" value="<?= e($employer['business_type']) ?>"></label>
  <label>Contact Person<input name="contact_person" value="<?= e($employer['contact_person']) ?>"></label>
  <label>Contact Number<input name="contact_number" value="<?= e($user['contact_number']) ?>"></label>
  <label>Business Address<input name="business_address" value="<?= e($employer['business_address']) ?>"></label>
  <label>Company Logo<input type="file" name="logo" accept="image/*"></label>
  <label>Business Permit<input type="file" name="business_permit" accept=".pdf,image/*"></label>
  <label class="full">Supporting Documents<input type="file" name="supporting_document" accept=".pdf,image/*"></label>
  <label class="full">Company Description<textarea name="company_description" rows="5"><?= e($employer['company_description']) ?></textarea></label>
  <button class="button" type="submit">Save and Submit for Verification</button>
</form>
<?php require __DIR__ . '/../includes/footer.php'; ?>
