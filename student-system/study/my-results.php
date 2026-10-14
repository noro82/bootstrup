<?php
declare(strict_types=1);
require __DIR__ . '/../includes/bootstrap.php';
guard();

$results = [['رياضيات', 88, 'جيد جدًا'], ['علوم', 93, 'ممتاز'], ['لغة عربية', 79, 'جيد']];
$pageTitle = 'نتائجي';
require __DIR__ . '/../includes/header.php';
?>
<div class="card"><div class="card-body"><div class="table-responsive">
  <table class="table">
    <thead><tr><th>المقرر</th><th>الدرجة</th><th>التقدير</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($results as $r): ?>
      <tr><td><?= e($r[0]) ?></td><td><?= e($r[1]) ?></td><td><?= e($r[2]) ?></td>
        <td style="min-width:140px"><div class="progress"><div class="progress-bar" style="width:<?= (int) $r[1] ?>%"></div></div></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
