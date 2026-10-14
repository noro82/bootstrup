<?php
declare(strict_types=1);
require __DIR__ . '/../includes/bootstrap.php';
guard();   // الصلاحيات من config/menu.php

$students = [   // بيانات تجريبية — استبدلها باستعلام قاعدة البيانات
    ['20240101', 'محمد عبدالله', 'الصف الأول',  'نشط'],
    ['20240102', 'فاطمة أحمد',   'الصف الأول',  'نشط'],
    ['20240215', 'عمر حسن',      'الصف الثاني', 'نشط'],
    ['20240311', 'يوسف علي',     'الصف الثالث', 'موقوف'],
];
$canAdd  = role_allowed(['admin', 'registrar'], current_user()['role']);
$canEdit = $canAdd;

$pageTitle = 'قائمة الطلاب';
require __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
  <input type="search" class="form-control" style="max-width:320px" placeholder="ابحث بالاسم أو الرقم...">
  <?php if ($canAdd): ?><a href="<?= e(url('students/add.php')) ?>" class="btn btn-success"><i class="bi bi-plus-lg"></i> إضافة طالب</a><?php endif; ?>
</div>
<div class="card"><div class="card-body"><div class="table-responsive">
  <table class="table table-hover">
    <thead><tr><th>الرقم الجامعي</th><th>اسم الطالب</th><th>المستوى</th><th>الحالة</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($students as $s): ?>
      <tr>
        <td><?= e($s[0]) ?></td><td><?= e($s[1]) ?></td><td><?= e($s[2]) ?></td>
        <td><span class="badge <?= $s[3] === 'نشط' ? 'badge-success' : 'badge-warning' ?>"><?= e($s[3]) ?></span></td>
        <td><?php if ($canEdit): ?><a class="btn btn-sm btn-outline-primary" href="<?= e(url('students/edit.php')) ?>?id=<?= e($s[0]) ?>">تعديل</a><?php endif; ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
