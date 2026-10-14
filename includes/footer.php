</main>

<footer class="site-footer">
  <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span>© <?= date('Y') ?> <?= e(config('app_name')) ?>. جميع الحقوق محفوظة.</span>
    <span class="d-flex gap-3">
      <a href="#">المساعدة</a>
      <a href="#">سياسة الخصوصية</a>
      <a href="#">اتصل بنا</a>
    </span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(url('assets/js/app.js')) ?>"></script>
</body>
</html>
