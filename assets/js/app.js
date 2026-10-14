(function () {
  var root = document.documentElement;
  var btn = document.getElementById('themeBtn');

  function setTheme(t) {
    root.setAttribute('data-theme', t);
    root.setAttribute('data-bs-theme', t);
    if (btn) btn.innerHTML = '<i class="bi ' + (t === 'dark' ? 'bi-sun' : 'bi-moon-stars') + '"></i>';
    try { localStorage.setItem('sis_theme', t); } catch (e) {}
  }

  setTheme(root.getAttribute('data-theme') || 'light');
  if (btn) btn.addEventListener('click', function () {
    setTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
  });

  // إظهار/إخفاء كلمة المرور في صفحة الدخول
  var tg = document.getElementById('pwToggle'), pw = document.getElementById('password');
  if (tg && pw) {
    var flip = function () {
      var show = pw.type === 'password';
      pw.type = show ? 'text' : 'password';
      tg.innerHTML = '<i class="bi ' + (show ? 'bi-eye-slash' : 'bi-eye') + '"></i>';
    };
    tg.addEventListener('click', flip);
    tg.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); flip(); } });
  }
})();
