<?php
require_once __DIR__ . '/auth.php';
$pageTitle = $pageTitle ?? APP_NAME;
$user = $user ?? current_user();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> - <?= APP_NAME ?></title>
  <link rel="stylesheet" href="<?= url('assets/css/app.css?v=20260820d') ?>">
</head>
<body>
<div class="app-shell">
