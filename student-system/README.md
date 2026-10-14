# نظام شؤون الطلاب — قالب PHP 8.2 + Bootstrap 5 RTL

## التشغيل السريع
    cd student-system
    php -S localhost:8000
ثم افتح http://localhost:8000/login.php

## البنية
    config/config.php   الإعدادات (اسم النظام، base_url، الأدوار، قاعدة البيانات)
    config/menu.php     ⭐ ملف القوائم — الوحيد الذي تعدّله لإضافة قائمة جديدة
    includes/           auth.php (الجلسة والصلاحيات) / header.php / footer.php / users.php
    assets/css/style_2.css   ملف الاستايل الخاص بك (بدون تعديل)
    assets/css/app.css       إضافات صغيرة للقالب

## إضافة صفحة جديدة (3 خطوات)
1. أنشئ الملف، مثال reports/index.php:

        <?php
        declare(strict_types=1);
        require __DIR__ . '/../includes/bootstrap.php';
        guard();
        $pageTitle = 'التقارير';
        require __DIR__ . '/../includes/header.php';
        ?>
        ... المحتوى ...
        <?php require __DIR__ . '/../includes/footer.php'; ?>

2. أضف سطرًا في config/menu.php:

        ['label' => 'التقارير', 'icon' => 'bi-bar-chart', 'url' => 'reports/index.php', 'roles' => ['admin', 'registrar']],

3. انتهى — تظهر القائمة في كل الصفحات، وتُحمى الصفحة بنفس الصلاحيات تلقائيًا.

## قبل الإنتاج
- استبدل find_user_by_username() في includes/users.php بالاستعلام من قاعدة البيانات (PDO).
- احذف جدول "الحسابات التجريبية" من login.php.
- فعّل HTTPS، وضع config/ و includes/ خارج جذر الويب إن أمكن.
