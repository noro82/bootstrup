<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';
guard();   // الصفحة غير موجودة في القائمة ⇒ يكفي أن يكون المستخدم مسجّلًا

$user = current_user();
$pageTitle = 'ملفي الشخصي';
require __DIR__ . '/includes/header.php';
?>
<div class="card" style="max-width:640px"><div class="card-body">
  <div class="mb-3"><label class="form-label">الاسم</label><input class="form-control" value="<?= e($user['name']) ?>" disabled></div>
  <div class="mb-3"><label class="form-label">اسم المستخدم</label><input class="form-control" value="<?= e($user['username']) ?>" disabled></div>
  <div class="mb-3"><label class="form-label">الصلاحية</label><input class="form-control" value="<?= e(config('roles.' . $user['role'])) ?>" disabled></div>
</div></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
