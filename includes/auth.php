<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/functions.php';

function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    return fetch_one('SELECT u.*, b.name AS barangay_name FROM users u LEFT JOIN barangays b ON b.id = u.barangay_id WHERE u.id = ?', [(int) $_SESSION['user_id']]);
}

function login_user(array $user): void
{
    $_SESSION['user_id'] = (int) $user['id'];
    log_activity((int) $user['id'], 'login', 'User logged in.');
}

function logout_user(): void
{
    if (!empty($_SESSION['user_id'])) {
        log_activity((int) $_SESSION['user_id'], 'logout', 'User logged out.');
    }
    session_destroy();
}

function require_login(array $roles = []): array
{
    ensure_schema_loaded_message();
    $user = current_user();
    if (!$user) {
        redirect('auth/login.php');
    }
    if ($roles && !in_array($user['role'], $roles, true)) {
        flash('error', 'You are not allowed to access that page.');
        redirect(role_home($user['role']));
    }
    if ($user['status'] === 'suspended') {
        logout_user();
        session_start();
        flash('error', 'Your account is suspended.');
        redirect('auth/login.php');
    }
    return $user;
}

function role_home(string $role): string
{
    return match ($role) {
        'municipal_admin', 'barangay_admin' => 'admin/dashboard.php',
        'employer' => 'employer/dashboard.php',
        'jobseeker' => 'jobseeker/dashboard.php',
        default => 'index.php',
    };
}

function admin_roles(): array
{
    return ['municipal_admin', 'barangay_admin'];
}

function is_admin_role(string $role): bool
{
    return in_array($role, admin_roles(), true);
}

