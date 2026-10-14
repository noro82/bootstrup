<?php
declare(strict_types=1);

/* ======================= الجلسة ======================= */
function session_start_secure(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    session_name((string) config('session_name', 'sis_session'));
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function current_user(): ?array
{
    $user = $_SESSION['user'] ?? null;
    if (!is_array($user)) {
        return null;
    }
    $idle = time() - (int) ($_SESSION['last_activity'] ?? 0);
    if ($idle > (int) config('session_lifetime', 1800)) {
        logout_user();
        return null;
    }
    $_SESSION['last_activity'] = time();
    return $user;
}

function login_user(array $row): void
{
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id'       => $row['id'],
        'username' => $row['username'],
        'name'     => $row['name'],
        'role'     => $row['role'],
    ];
    $_SESSION['last_activity'] = time();
    unset($_SESSION['login_fails'], $_SESSION['login_locked_until']);
}

function logout_user(): void
{
    unset($_SESSION['user'], $_SESSION['last_activity']);
    session_regenerate_id(true);
}

/** محاولة تسجيل الدخول — تُرجع null عند النجاح أو رسالة الخطأ */
function attempt_login(string $username, string $password): ?string
{
    $lockedUntil = (int) ($_SESSION['login_locked_until'] ?? 0);
    if ($lockedUntil > time()) {
        return 'تم إيقاف المحاولات مؤقتًا. حاول بعد قليل.';
    }

    $row = find_user_by_username(strtolower(trim($username)));
    if ($row && password_verify($password, $row['password_hash'])) {
        login_user($row);
        return null;
    }

    $fails = (int) ($_SESSION['login_fails'] ?? 0) + 1;
    $_SESSION['login_fails'] = $fails;
    if ($fails >= (int) config('max_login_fails', 5)) {
        $_SESSION['login_locked_until'] = time() + (int) config('lockout_seconds', 300);
        $_SESSION['login_fails'] = 0;
    }
    return 'اسم المستخدم أو كلمة المرور غير صحيحة.';
}

/* ======================= القوائم والصلاحيات ======================= */

/** تحميل config/menu.php وتوحيد الصلاحيات (الأبناء يرثون صلاحية المجموعة) */
function menu_items(): array
{
    static $items = null;
    if ($items !== null) {
        return $items;
    }
    $items = [];
    foreach (require ROOT_DIR . '/config/menu.php' as $item) {
        $groupRoles = $item['roles'] ?? ['*'];
        $item['roles'] = $groupRoles;
        if (!empty($item['children'])) {
            foreach ($item['children'] as $i => $child) {
                $item['children'][$i]['roles'] = $child['roles'] ?? $groupRoles;
            }
        }
        $items[] = $item;
    }
    return $items;
}

function role_allowed(array $roles, ?string $role): bool
{
    return in_array('*', $roles, true) || ($role !== null && in_array($role, $roles, true));
}

/** القائمة كما يراها هذا الدور فقط */
function visible_menu(?string $role): array
{
    $out = [];
    foreach (menu_items() as $item) {
        if (!empty($item['children'])) {
            $kids = array_values(array_filter(
                $item['children'],
                fn ($c) => ($c['show'] ?? true) !== false && role_allowed($c['roles'], $role)
            ));
            if ($kids) {                       // لا تُعرض المجموعة الفارغة
                $item['children'] = $kids;
                $out[] = $item;
            }
        } elseif (($item['show'] ?? true) !== false && role_allowed($item['roles'], $role)) {
            $out[] = $item;
        }
    }
    return $out;
}

/** مسار الصفحة الحالية نسبةً لجذر المشروع (مثل students/add.php) */
function current_path(): string
{
    $script = (string) parse_url($_SERVER['SCRIPT_NAME'] ?? '', PHP_URL_PATH);
    $base   = rtrim((string) config('base_url', ''), '/');
    if ($base !== '' && str_starts_with($script, $base)) {
        $script = substr($script, strlen($base));
    }
    return ltrim($script, '/');
}

/** البحث عن عنصر القائمة الذي يطابق مسارًا معيّنًا */
function menu_find(string $path): ?array
{
    foreach (menu_items() as $item) {
        if (($item['url'] ?? null) === $path) {
            return $item;
        }
        foreach ($item['children'] ?? [] as $child) {
            if (($child['url'] ?? null) === $path) {
                return $child;
            }
        }
    }
    return null;
}

function menu_is_active(array $item, string $path): bool
{
    if (($item['url'] ?? null) === $path) {
        return true;
    }
    foreach ($item['children'] ?? [] as $child) {
        if (($child['url'] ?? null) === $path) {
            return true;
        }
    }
    return false;
}

/**
 * حارس الصفحة — استدعِه في أول كل صفحة محمية.
 *   guard();                  // الصلاحيات تؤخذ من config/menu.php تلقائيًا
 *   guard(['admin']);         // أو حدّدها يدويًا لصفحة غير موجودة في القائمة
 */
function guard(?array $roles = null): void
{
    $user = current_user();
    if ($user === null) {
        redirect(url('login.php') . '?next=' . rawurlencode($_SERVER['REQUEST_URI'] ?? ''));
    }

    $roles ??= menu_find(current_path())['roles'] ?? ['*'];

    if (!role_allowed($roles, $user['role'])) {
        http_response_code(403);
        $pageTitle    = 'غير مصرّح';
        $pageSubtitle = '';
        require ROOT_DIR . '/includes/header.php';
        echo '<div class="alert alert-danger">ليست لديك صلاحية للوصول إلى هذه الصفحة.</div>';
        echo '<a class="btn btn-light" href="' . e(url('index.php')) . '">العودة للرئيسية</a>';
        require ROOT_DIR . '/includes/footer.php';
        exit;
    }
}
