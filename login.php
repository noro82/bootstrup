<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

/** السماح بالعودة لمسار داخلي فقط (منع Open Redirect) */
function safe_next(string $next): string
{
    $base = rtrim((string) config('base_url', ''), '/');
    if ($next !== '' && preg_match('#^/(?!/)[^\\\\\r\n]*$#', $next)
        && ($base === '' || str_starts_with($next, $base . '/'))) {
        return $next;
    }
    return url('index.php');
}

if (current_user()) {
    redirect(url('index.php'));
}

$error = null;
$next  = (string) ($_GET['next'] ?? $_POST['next'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) {
        $error = 'انتهت صلاحية الصفحة، أعد المحاولة.';
    } else {
        $error = attempt_login((string) ($_POST['username'] ?? ''), (string) ($_POST['password'] ?? ''));
        if ($error === null) {
            redirect(safe_next($next));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="light" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>تسجيل الدخول | <?= e(config('app_name')) ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= e(url('assets/css/style_2.css')) ?>">
  <link rel="stylesheet" href="<?= e(url('assets/css/app.css')) ?>">
</head>
<body style="display:block">
<div class="login-page">
  <div class="login-card">
    <div class="login-header">
      <?= logo_html('login-logo') ?>
      <h3 class="system-title"><?= e(config('app_name')) ?></h3>
      <p class="system-subtitle">سجّل دخولك للمتابعة</p>
    </div>

    <?php if ($error): ?><div class="alert alert-danger" role="alert"><?= e($error) ?></div><?php endif; ?>

    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="next" value="<?= e($next) ?>">
      <div class="mb-3">
        <label class="form-label" for="username">اسم المستخدم</label>
        <input type="text" id="username" name="username" class="form-control form-control-lg" value="<?= e($_POST['username'] ?? '') ?>" autocomplete="username" required autofocus>
      </div>
      <div class="mb-4">
        <label class="form-label" for="password">كلمة المرور</label>
        <div class="password-container">
          <input type="password" id="password" name="password" class="form-control form-control-lg" style="padding-inline-end:3rem" autocomplete="current-password" required>
          <span class="password-toggle" id="pwToggle" role="button" tabindex="0" aria-label="إظهار كلمة المرور"><i class="bi bi-eye"></i></span>
        </div>
      </div>
      <button type="submit" class="btn btn-login">دخول</button>
    </form>

    <div class="login-footer">
      <details>
        <summary style="cursor:pointer">حسابات تجريبية (احذف هذا الجزء عند الإنتاج)</summary>
        <table class="table demo-accounts mt-2 mb-0">
          <thead><tr><th>المستخدم</th><th>كلمة المرور</th><th>الصلاحية</th></tr></thead>
          <tbody>
            <tr><td>admin</td><td>admin123</td><td>مدير النظام</td></tr>
            <tr><td>registrar</td><td>reg123</td><td>شؤون الطلاب</td></tr>
            <tr><td>teacher</td><td>teach123</td><td>معلم</td></tr>
            <tr><td>student</td><td>stud123</td><td>طالب</td></tr>
          </tbody>
        </table>
      </details>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(url('assets/js/app.js')) ?>"></script>
</body>
</html>
