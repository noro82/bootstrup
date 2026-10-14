<?php
declare(strict_types=1);

return [
    'app_name'         => 'نظام شؤون الطلاب',

    // مسار اللوغو نسبةً لجذر المشروع، مثال: 'assets/img/logo.png' (PNG أو SVG أو WebP)
    // اتركه فارغًا لاستخدام الأيقونة الافتراضية
    'logo'             => 'assets/img/logo.jpg',

    // إن كان النظام داخل مجلد فرعي اكتبه هنا، مثال: '/sis'   (بدون / في النهاية)
    'base_url'         => '',

    'session_name'     => 'sis_session',
    'session_lifetime' => 1800,      // مدة الخمول بالثواني (30 دقيقة)

    'max_login_fails'  => 5,         // عدد المحاولات الفاشلة قبل الإيقاف المؤقت
    'lockout_seconds'  => 300,

    // أسماء الأدوار (المفتاح هو القيمة المخزنة في قاعدة البيانات)
    'roles' => [
        'admin'     => 'مدير النظام',
        'registrar' => 'شؤون الطلاب',
        'teacher'   => 'معلم',
        'student'   => 'طالب',
    ],
    'role_badges' => [
        'admin'     => 'badge-danger',
        'registrar' => 'badge-warning',
        'teacher'   => 'badge-success',
        'student'   => '',
    ],

    // إعدادات قاعدة البيانات (عند ربط النظام الحقيقي)
    'db' => [
        'dsn'  => 'mysql:host=localhost;dbname=sis;charset=utf8mb4',
        'user' => 'root',
        'pass' => '',
    ],
];
