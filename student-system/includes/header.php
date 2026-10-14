<?php
declare(strict_types=1);

$user         = current_user();
$role         = $user['role'] ?? null;
$menu         = visible_menu($role);
$path         = current_path();
$pageTitle    ??= (string) config('app_name');
$pageSubtitle ??= '';
$roleLabel    = config('roles.' . $role, '');
$roleBadge    = config('role_badges.' . $role, '');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="light" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> | <?= e(config('app_name')) ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= e(url('assets/css/style_2.css')) ?>">
  <link rel="stylesheet" href="<?= e(url('assets/css/app.css')) ?>">
  <script>/* تطبيق المظهر المحفوظ قبل الرسم لتفادي الوميض */
    try { var t = localStorage.getItem('sis_theme'); if (t) { document.documentElement.setAttribute('data-theme', t); document.documentElement.setAttribute('data-bs-theme', t); } } catch (e) {}
  </script>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="<?= e(url('index.php')) ?>">
    <?= logo_html('logo') ?>
    <span><?= e(config('app_name')) ?></span>
  </a>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="القائمة">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="mainNav">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php foreach ($menu as $item): $active = menu_is_active($item, $path); ?>
        <?php if (!empty($item['children'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?= $active ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php if (!empty($item['icon'])): ?><i class="bi <?= e($item['icon']) ?>"></i><?php endif; ?>
              <?= e($item['label']) ?>
            </a>
            <ul class="dropdown-menu">
              <?php foreach ($item['children'] as $child): ?>
                <li>
                  <a class="dropdown-item <?= ($child['url'] ?? '') === $path ? 'active' : '' ?>" href="<?= e(url($child['url'])) ?>">
                    <?php if (!empty($child['icon'])): ?><i class="bi <?= e($child['icon']) ?>"></i><?php endif; ?>
                    <?= e($child['label']) ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link <?= $active ? 'active' : '' ?>" href="<?= e(url($item['url'])) ?>">
              <?php if (!empty($item['icon'])): ?><i class="bi <?= e($item['icon']) ?>"></i><?php endif; ?>
              <?= e($item['label']) ?>
            </a>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>

    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-light btn-sm" id="themeBtn" type="button" title="تبديل المظهر" aria-label="تبديل المظهر"><i class="bi bi-moon-stars"></i></button>
      <?php if ($user): ?>
        <div class="dropdown">
          <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
            <?= e($user['name']) ?>
            <span class="badge <?= e($roleBadge) ?>"><?= e($roleLabel) ?></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= e(url('profile.php')) ?>"><i class="bi bi-person"></i>ملفي الشخصي</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="post" action="<?= e(url('logout.php')) ?>" class="m-0">
                <?= csrf_field() ?>
                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i>تسجيل الخروج</button>
              </form>
            </li>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>

<header class="site-header page-band">
  <div class="container">
    <h1><?= e($pageTitle) ?></h1>
    <?php if ($pageSubtitle !== ''): ?><p><?= e($pageSubtitle) ?></p><?php endif; ?>
  </div>
</header>

<main class="container">
