<?php
declare(strict_types=1);

/**
 * مصدر بيانات المستخدمين.
 * ⚠ هذه بيانات تجريبية فقط — استبدل الدالة بالاستعلام من قاعدة البيانات، مثال:
 *
 *   function find_user_by_username(string $username): ?array {
 *       $pdo = new PDO(config('db.dsn'), config('db.user'), config('db.pass'),
 *                      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
 *       $st = $pdo->prepare('SELECT id, username, full_name AS name, role, password_hash
 *                            FROM users WHERE username = ? AND active = 1');
 *       $st->execute([$username]);
 *       return $st->fetch(PDO::FETCH_ASSOC) ?: null;
 *   }
 *
 * وعند إنشاء المستخدم خزّن: password_hash($password, PASSWORD_DEFAULT)
 */
function find_user_by_username(string $username): ?array
{
    $demo = [
        'admin'     => ['id' => 1, 'name' => 'أحمد المدير',  'role' => 'admin',     'pass' => 'admin123'],
        'registrar' => ['id' => 2, 'name' => 'سارة محمد',    'role' => 'registrar', 'pass' => 'reg123'],
        'teacher'   => ['id' => 3, 'name' => 'خالد إبراهيم', 'role' => 'teacher',   'pass' => 'teach123'],
        'student'   => ['id' => 4, 'name' => 'ليلى عثمان',   'role' => 'student',   'pass' => 'stud123'],
    ];

    if (!isset($demo[$username])) {
        return null;
    }
    $u = $demo[$username];
    return [
        'id'            => $u['id'],
        'username'      => $username,
        'name'          => $u['name'],
        'role'          => $u['role'],
        'password_hash' => password_hash($u['pass'], PASSWORD_DEFAULT),
    ];
}
