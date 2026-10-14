<?php
declare(strict_types=1);

const ROOT_DIR = __DIR__ . '/..';

/** قراءة إعداد من config/config.php  مثال: config('db.dsn') */
function config(string $key, mixed $default = null): mixed
{
    static $cfg = null;
    $cfg ??= require ROOT_DIR . '/config/config.php';

    $value = $cfg;
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

/** تهريب المخرجات (حماية XSS) */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** رابط داخل المشروع: url('students/add.php') */
function url(string $path = ''): string
{
    return rtrim((string) config('base_url', ''), '/') . '/' . ltrim($path, '/');
}

/** اللوغو: صورة من config('logo') إن وُجدت، وإلا أيقونة افتراضية */
function logo_html(string $class = 'logo'): string
{
    $file = ltrim((string) config('logo', ''), '/');
    if ($file !== '' && is_file(ROOT_DIR . '/' . $file)) {
        return '<img class="' . e($class) . '" src="' . e(url($file)) . '" alt="' . e(config('app_name')) . '">';
    }
    return '<span class="' . e($class) . '"><i class="bi bi-mortarboard-fill"></i></span>';
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

/* ---------- CSRF ---------- */
function csrf_token(): string
{
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function csrf_verify(): bool
{
    $sent = $_POST['_csrf'] ?? '';
    return is_string($sent) && hash_equals(csrf_token(), $sent);
}
