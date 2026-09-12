<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function flashes(): array
{
    $items = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $items;
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function selected(?string $actual, ?string $expected): string
{
    return (string) $actual === (string) $expected ? 'selected' : '';
}

function checked(?bool $condition): string
{
    return $condition ? 'checked' : '';
}

function initials(?string $name): string
{
    $name = trim((string) $name);
    if ($name === '') {
        return 'GM';
    }
    $words = preg_split('/\s+/', $name);
    $letters = '';
    foreach ($words as $word) {
        if ($word !== '') {
            $letters .= strtoupper(substr($word, 0, 1));
        }
        if (strlen($letters) >= 2) {
            break;
        }
    }
    return $letters ?: 'GM';
}

function avatar(?string $path, ?string $name, string $class = 'avatar'): string
{
    $safeClass = preg_replace('/[^a-zA-Z0-9_\-\s]/', '', $class) ?: 'avatar';
    $displayName = trim((string) $name) ?: 'Account';
    if ($path) {
        return '<span class="' . e($safeClass) . '"><img src="' . url($path) . '" alt="' . e($displayName) . ' profile image"></span>';
    }
    return '<span class="' . e($safeClass) . ' avatar-fallback" aria-hidden="true">' . e(initials($displayName)) . '</span>';
}

function icon(string $name, string $class = 'icon'): string
{
    $safeClass = preg_replace('/[^a-zA-Z0-9_\-\s]/', '', $class) ?: 'icon';
    $paths = [
        'activity' => '<path d="M3 12h4l3-8 4 16 3-8h4"/>',
        'bell' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
        'briefcase' => '<path d="M10 6V5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v1"/><rect x="3" y="6" width="18" height="14" rx="2"/><path d="M3 12h18"/>',
        'building' => '<path d="M4 21V5a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v16"/><path d="M9 7h1M9 11h1M9 15h1M14 7h1M14 11h1M14 15h1M2 21h20"/>',
        'chart' => '<path d="M4 19V5"/><path d="M4 19h16"/><path d="M8 16v-5"/><path d="M12 16V8"/><path d="M16 16v-9"/>',
        'dashboard' => '<path d="M4 13a8 8 0 1 1 16 0"/><path d="M12 13l4-4"/><path d="M3 21h18"/>',
        'eye' => '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>',
        'eye-off' => '<path d="M3 3l18 18"/><path d="M10.58 10.58A2 2 0 0 0 12 14a2 2 0 0 0 1.42-.58"/><path d="M9.88 5.09A10.67 10.67 0 0 1 12 5c6.5 0 10 7 10 7a18.5 18.5 0 0 1-4.1 5.1"/><path d="M6.11 6.11C3.6 7.8 2 12 2 12s3.5 7 10 7a10.8 10.8 0 0 0 4.77-1.08"/>',
        'file' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8M8 17h6"/>',
        'graduation' => '<path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 2 9 2 12 0v-5"/>',
        'log-in' => '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/>',
        'log-out' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'map' => '<path d="M9 18l-6 3V6l6-3 6 3 6-3v15l-6 3-6-3z"/><path d="M9 3v15M15 6v15"/>',
        'megaphone' => '<path d="M3 11v2a2 2 0 0 0 2 2h2l4 4v-5l8 3V7l-8 3V5l-4 4H5a2 2 0 0 0-2 2z"/>',
        'settings' => '<path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M19.4 15a1.8 1.8 0 0 0 .36 1.98l.04.04a2 2 0 1 1-2.83 2.83l-.04-.04A1.8 1.8 0 0 0 15 19.4a1.8 1.8 0 0 0-1 .6 1.8 1.8 0 0 0-.4 1.17V21a2 2 0 1 1-4 0v-.06a1.8 1.8 0 0 0-.4-1.17 1.8 1.8 0 0 0-1-.6 1.8 1.8 0 0 0-1.93.41l-.04.04a2 2 0 1 1-2.83-2.83l.04-.04A1.8 1.8 0 0 0 4.6 15a1.8 1.8 0 0 0-.6-1 1.8 1.8 0 0 0-1.17-.4H2.8a2 2 0 1 1 0-4h.06a1.8 1.8 0 0 0 1.17-.4 1.8 1.8 0 0 0 .6-1 1.8 1.8 0 0 0-.41-1.93l-.04-.04A2 2 0 1 1 7 3.4l.04.04A1.8 1.8 0 0 0 9 4.6a1.8 1.8 0 0 0 1-.6 1.8 1.8 0 0 0 .4-1.17V2.8a2 2 0 1 1 4 0v.06a1.8 1.8 0 0 0 .4 1.17 1.8 1.8 0 0 0 1 .6 1.8 1.8 0 0 0 1.93-.41l.04-.04A2 2 0 1 1 20.6 7l-.04.04A1.8 1.8 0 0 0 19.4 9c.3.2.5.6.6 1h1.2a2 2 0 1 1 0 4H20a1.8 1.8 0 0 0-.6 1z"/>',
        'spark' => '<path d="M12 2l1.8 6.2L20 10l-6.2 1.8L12 18l-1.8-6.2L4 10l6.2-1.8L12 2z"/><path d="M19 17l.8 2.2L22 20l-2.2.8L19 23l-.8-2.2L16 20l2.2-.8L19 17z"/>',
        'user-plus' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/>',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'x' => '<path d="M18 6 6 18"/><path d="M6 6l12 12"/>',
    ];
    $path = $paths[$name] ?? '<circle cx="12" cy="12" r="8"/>';
    return '<svg class="' . e($safeClass) . '" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
}

function fetch_one(string $sql, array $params = []): ?array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

function fetch_all(string $sql, array $params = []): array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function execute_sql(string $sql, array $params = []): bool
{
    $stmt = db()->prepare($sql);
    return $stmt->execute($params);
}

function log_activity(?int $userId, string $action, string $details = ''): void
{
    execute_sql(
        'INSERT INTO activity_logs (user_id, action, details, created_at) VALUES (?, ?, ?, NOW())',
        [$userId, $action, $details]
    );
}

function notify_user(int $userId, string $title, string $message): void
{
    execute_sql(
        'INSERT INTO notifications (user_id, title, message, is_read, is_seen, created_at) VALUES (?, ?, ?, 0, 0, NOW())',
        [$userId, $title, $message]
    );
}

function notify_users_by_role(array $roles, string $title, string $message, ?int $barangayId = null): void
{
    $roles = array_values(array_filter($roles));
    if (!$roles) {
        return;
    }

    $placeholders = implode(',', array_fill(0, count($roles), '?'));
    $users = fetch_all("SELECT id, role, barangay_id FROM users WHERE status <> 'suspended' AND role IN ($placeholders)", $roles);
    foreach ($users as $target) {
        if ($barangayId !== null && $target['role'] === 'barangay_admin' && (int) $target['barangay_id'] !== $barangayId) {
            continue;
        }
        notify_user((int) $target['id'], $title, $message);
    }
}

function badge_last_viewed_at(int $userId, string $badgeKey): string
{
    $row = fetch_one('SELECT viewed_at FROM badge_views WHERE user_id = ? AND badge_key = ?', [$userId, $badgeKey]);
    return $row['viewed_at'] ?? '1970-01-01 00:00:00';
}

function badge_count_new(int $userId, string $badgeKey, string $sql, array $params = []): int
{
    $params[] = badge_last_viewed_at($userId, $badgeKey);
    return (int) (fetch_one($sql, $params)['total'] ?? 0);
}

function badge_opened(int $userId, string $badgeKey): string
{
    $lastViewedAt = badge_last_viewed_at($userId, $badgeKey);
    execute_sql(
        'INSERT INTO badge_views (user_id, badge_key, viewed_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE viewed_at = VALUES(viewed_at)',
        [$userId, $badgeKey]
    );
    return $lastViewedAt;
}

function item_is_new(?string $changedAt, string $lastViewedAt): bool
{
    if (!$changedAt) {
        return false;
    }
    return strtotime($changedAt) > strtotime($lastViewedAt);
}

function item_new_dot(?string $changedAt, string $lastViewedAt): string
{
    if (!item_is_new($changedAt, $lastViewedAt)) {
        return '';
    }
    return '<span class="unread-dot item-new-dot" aria-label="New or updated item" title="New or updated since you last opened this section"></span>';
}

function save_upload(string $field, string $folder, array $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']): ?string
{
    if (empty($_FILES[$field]['name']) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        throw new RuntimeException('Invalid file type for ' . $field . '.');
    }

    $relativeDir = 'uploads/' . trim($folder, '/');
    $targetDir = public_path($relativeDir);
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0775, true);
    }

    $name = date('YmdHis') . '-' . bin2hex(random_bytes(5)) . '.' . $ext;
    $target = $targetDir . DIRECTORY_SEPARATOR . $name;
    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $target)) {
        throw new RuntimeException('Unable to upload file.');
    }

    return $relativeDir . '/' . $name;
}

function status_badge(?string $status): string
{
    $status = trim((string) $status) ?: 'pending';
    $class = match ($status) {
        'verified', 'approved', 'active', 'hired', 'accepted', 'open' => 'success',
        'pending', 'screening', 'shortlisted', 'interview', 'draft', 'unread' => 'warning',
        'rejected', 'suspended', 'closed', 'archived' => 'danger',
        'read' => 'neutral',
        default => 'neutral',
    };
    return '<span class="badge ' . $class . '">' . e(ucwords(str_replace('_', ' ', $status))) . '</span>';
}

function calculate_match_score(array $jobseeker, array $job): int
{
    $score = 0;
    $jobSkills = array_filter(array_map('trim', explode(',', strtolower((string) ($job['required_skills'] ?? '')))));
    $seekerSkills = array_filter(array_map('trim', explode(',', strtolower((string) ($jobseeker['skills'] ?? '')))));
    $skillMatches = count(array_intersect($jobSkills, $seekerSkills));
    if ($jobSkills) {
        $score += (int) round(($skillMatches / count($jobSkills)) * 45);
    }
    if (!empty($job['education_requirement']) && stripos((string) $jobseeker['education'], (string) $job['education_requirement']) !== false) {
        $score += 20;
    }
    if ((int) ($jobseeker['years_experience'] ?? 0) >= (int) ($job['experience_years'] ?? 0)) {
        $score += 15;
    }
    if ((int) ($jobseeker['barangay_id'] ?? 0) === (int) ($job['barangay_id'] ?? 0)) {
        $score += 10;
    }
    if (!empty($jobseeker['employment_status']) && !empty($job['employment_type'])) {
        $score += 10;
    }
    return min(100, $score);
}

function ensure_schema_loaded_message(): void
{
    try {
        db()->query('SELECT 1 FROM users LIMIT 1');
    } catch (Throwable $exception) {
        die('Database is not ready. Import database/labormatch_db.sql into XAMPP MySQL first.');
    }
}
