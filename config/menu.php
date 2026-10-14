<?php
declare(strict_types=1);

/*
 * ملف القوائم المركزي — كل الصفحات تقرأ القائمة العلوية من هنا.
 * أضف سطرًا جديدًا هنا فتظهر القائمة في جميع الصفحات وتُحمى الصفحة تلقائيًا.
 *
 * حقول العنصر:
 *   label    : النص الظاهر
 *   icon     : أيقونة Bootstrap Icons (اختياري)
 *   url      : مسار الصفحة نسبةً لجذر المشروع (مثل 'students/add.php')
 *   roles    : الأدوار المسموح لها. إن حُذف الحقل = أي مستخدم مسجّل. ['*'] = نفس الشيء
 *   children : عناصر فرعية (قائمة منسدلة) — ترث roles من المجموعة إن لم تُحدَّد
 *   show     : false = لا تظهر في القائمة لكن تبقى محمية بالصلاحيات (مثل صفحة تعديل)
 *
 * الأدوار: admin | registrar | teacher | student
 */

return [

    ['label' => 'الرئيسية', 'icon' => 'bi-house', 'url' => 'index.php'],

    ['label' => 'الطلاب', 'icon' => 'bi-people', 'children' => [
        ['label' => 'قائمة الطلاب',   'icon' => 'bi-list-ul',        'url' => 'students/index.php',      'roles' => ['admin', 'registrar', 'teacher']],
        ['label' => 'إضافة طالب',     'icon' => 'bi-person-plus',    'url' => 'students/add.php',        'roles' => ['admin', 'registrar']],
        ['label' => 'الحضور والغياب', 'icon' => 'bi-calendar-check', 'url' => 'students/attendance.php', 'roles' => ['admin', 'teacher']],
        // صفحة محمية لا تظهر في القائمة:
        ['label' => 'تعديل طالب',     'url' => 'students/edit.php', 'roles' => ['admin', 'registrar'], 'show' => false],
    ]],

    ['label' => 'الدراسة', 'icon' => 'bi-journal-text', 'children' => [
        ['label' => 'الجدول الدراسي', 'icon' => 'bi-table',         'url' => 'study/schedule.php'],                       // لكل المسجلين
        ['label' => 'إدخال الدرجات',  'icon' => 'bi-pencil-square', 'url' => 'study/grades.php',     'roles' => ['admin', 'teacher']],
        ['label' => 'نتائجي',         'icon' => 'bi-award',         'url' => 'study/my-results.php', 'roles' => ['student']],
    ]],

    ['label' => 'الإدارة', 'icon' => 'bi-shield-lock', 'roles' => ['admin'], 'children' => [
        ['label' => 'المستخدمون',     'icon' => 'bi-person-gear', 'url' => 'admin/users.php'],      // يرث ['admin']
        ['label' => 'إعدادات النظام', 'icon' => 'bi-gear',        'url' => 'admin/settings.php'],   // يرث ['admin']
    ]],

    // مثال لإضافة قائمة جديدة مستقبلًا (أزل التعليق):
    // ['label' => 'التقارير', 'icon' => 'bi-bar-chart', 'url' => 'reports/index.php', 'roles' => ['admin', 'registrar']],
];
