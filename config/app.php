<?php
declare(strict_types=1);

const APP_NAME = 'LaborMatch';
const APP_MUNICIPALITY = 'General MacArthur';
const APP_PROVINCE = 'Eastern Samar';
const APP_LOGO_PATH = 'assets/img/general-macarthur-logo.png';

function app_base_url(): string
{
    $script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $script = preg_replace('#/(admin|auth|employer|jobseeker|public|database)$#', '', $script);
    return rtrim($script ?: '', '/');
}

function url(string $path = ''): string
{
    $base = app_base_url();
    return $base . '/' . ltrim($path, '/');
}

function public_path(string $path = ''): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . ltrim(str_replace('/', DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
}
