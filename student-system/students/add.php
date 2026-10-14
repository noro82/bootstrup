<?php
declare(strict_types=1);
require __DIR__ . '/../includes/bootstrap.php';
guard();

$errors = [];
$saved  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) {
        $errors[] = 'انتهت صلاحية الصفحة، أعد المحاولة.';
    } else {
        $name = trim((string) ($_POST['name'] ?? ''));
        $no   = trim((string) ($_POST['student_no'] ?? ''));
        if ($name === '') { $errors[] = 'الاسم مطلوب.'; }
        if (!preg_match('/^\d{6,12}$/', $no)) { $errors[] = 'الرقم الجامعي يجب أن يكون أرقامًا (6 - 12).'; }

        if (!$errors) {
            // TODO: INSERT INTO students ... باستخدام PDO prepared statements
            $saved = true;
        }
    }
}

$pageTitle = 'إضافة طالب';
require __DIR__ . '/../includes/header.php';
?>
<?php if ($saved): ?><div class="alert alert-success">تم حفظ الطالب (عرض تجريبي — لم يُربط بقاعدة بيانات بعد).</div><?php endif; ?>
<?php foreach ($errors as $err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endforeach; ?>

<div class="card"><div class="card-body">
  <form method="post" novalidate>
    <?= csrf_field() ?>
    <div class="row">
      <div class="col-md-6 mb-3"><label class="form-label" for="name">الاسم الكامل</label><input class="form-control" id="name" name="name" value="<?= e($_POST['name'] ?? '') ?>" required></div>
      <div class="col-md-6 mb-3"><label class="form-label" for="student_no">الرقم الجامعي</label><input class="form-control" id="student_no" name="student_no" value="<?= e($_POST['student_no'] ?? '') ?>" required></div>
      <div class="col-md-6 mb-3"><label class="form-label" for="level">المستوى</label>
        <select class="form-select" id="level" name="level"><option>الصف الأول</option><option>الصف الثاني</option><option>الصف الثالث</option></select></div>
      <div class="col-md-6 mb-3"><label class="form-label" for="phone">رقم الهاتف</label><input type="tel" class="form-control" id="phone" name="phone"></div>
    </div>
    <button class="btn btn-success" type="submit">حفظ</button>
    <a href="<?= e(url('students/index.php')) ?>" class="btn btn-light">رجوع</a>
  </form>
</div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
