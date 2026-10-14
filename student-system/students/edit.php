<?php
declare(strict_types=1);
require __DIR__ . '/../includes/bootstrap.php';
guard();   // محمية بحسب سطر 'تعديل طالب' (show => false) في config/menu.php

$id = (string) ($_GET['id'] ?? '');
$pageTitle = 'تعديل طالب';
require __DIR__ . '/../includes/header.php';
?>
<div class="alert alert-info">صفحة تعديل الطالب رقم <strong><?= e($id) ?></strong> — قيد البناء.</div>
<a href="<?= e(url('students/index.php')) ?>" class="btn btn-light">رجوع</a>
<?php require __DIR__ . '/../includes/footer.php'; ?>
