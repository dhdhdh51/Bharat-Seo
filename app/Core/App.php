<?php
namespace App\Core;

use PDO;

final class App
{
    private static array $config = [];
    private static ?PDO $db = null;

    public static function boot(array $config): void
    {
        self::$config = $config;
        date_default_timezone_set($config['app']['timezone'] ?? 'UTC');
        ini_set('session.cookie_httponly', '1');
        ini_set('session.use_strict_mode', '1');
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            ini_set('session.cookie_secure', '1');
        }
        session_name($config['security']['session_name'] ?? 'careerforge_session');
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function config(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) return self::$config;
        $value = self::$config;
        foreach (explode('.', $key) as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) return $default;
            $value = $value[$segment];
        }
        return $value;
    }

    public static function db(): PDO
    {
        if (!self::$db) self::$db = Database::connect(self::$config);
        return self::$db;
    }

    public static function view(string $file, array $data = []): void
    {
        extract($data);
        require dirname(__DIR__, 2) . '/resources/views/' . $file . '.php';
    }
}
