<?php
declare(strict_types=1);
require __DIR__ . '/../includes/bootstrap.php';
guard();

$rows = [
    ['الأحد', 'رياضيات', 'لغة عربية', '—'],
    ['الاثنين', 'علوم', '—', 'حاسوب'],
    ['الثلاثاء', 'لغة إنجليزية', 'رياضيات', '—'],
];
$pageTitle = 'الجدول الدراسي';
require __DIR__ . '/../includes/header.php';
?>
<div class="card"><div class="card-body"><div class="table-responsive">
  <table class="table table-hover">
    <thead><tr><th>اليوم</th><th>8:00 - 9:30</th><th>10:00 - 11:30</th><th>12:00 - 1:30</th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr><th><?= e($r[0]) ?></th><td><?= e($r[1]) ?></td><td><?= e($r[2]) ?></td><td><?= e($r[3]) ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
