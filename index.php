<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';
guard();

$user = current_user();
$role = $user['role'];

$stats = match ($role) {
    'student' => [['bi-journal-bookmark', 6, 'المقررات المسجلة'], ['bi-calendar-check', '96%', 'نسبة الحضور'], ['bi-graph-up', '3.6', 'المعدل التراكمي'], ['bi-bell', 2, 'إشعارات جديدة']],
    'teacher' => [['bi-collection', 4, 'مقرراتي'], ['bi-people', 112, 'عدد الطلاب'], ['bi-clipboard-check', 3, 'تقييمات معلّقة'], ['bi-bell', 5, 'إشعارات جديدة']],
    default   => [['bi-people', 1248, 'إجمالي الطلاب'], ['bi-person-plus', 37, 'تسجيلات جديدة'], ['bi-person-badge', 64, 'أعضاء الهيئة'], ['bi-exclamation-triangle', 8, 'تنبيهات']],
};

$pageTitle    = 'الرئيسية';
$pageSubtitle = 'نظرة عامة';
require __DIR__ . '/includes/header.php';
?>
<div class="info-box">
  <strong>مرحبًا <?= e($user['name']) ?></strong> — صلاحيتك: «<?= e(config('roles.' . $role)) ?>».
</div>

<div class="row">
  <?php foreach ($stats as [$icon, $value, $label]): ?>
    <div class="col-md-3 col-6 mb-4">
      <div class="card stat-card"><div class="card-body">
        <div class="stat-icon"><i class="bi <?= e($icon) ?>"></i></div>
        <div><div class="stat-value"><?= e($value) ?></div><div class="text-muted small"><?= e($label) ?></div></div>
      </div></div>
    </div>
  <?php endforeach; ?>
</div>

<div class="card">
  <div class="card-header fw-bold">آخر الإعلانات</div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item d-flex justify-content-between"><span>بدء التسجيل للفصل الدراسي القادم</span><span class="text-muted small">اليوم</span></li>
    <li class="list-group-item d-flex justify-content-between"><span>جدول الاختبارات النصفية متاح الآن</span><span class="text-muted small">أمس</span></li>
  </ul>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
