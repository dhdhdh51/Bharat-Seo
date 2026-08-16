<?php
namespace App\Helpers;
final class Security {
    public static function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
    public static function csrfToken(): string {
        if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }
    public static function verifyCsrf(?string $token): bool { return hash_equals($_SESSION['csrf_token'] ?? '', $token ?? ''); }
    public static function encryptSecret(string $plain, string $key): string {
        $iv = random_bytes(16); $cipher = openssl_encrypt($plain, 'AES-256-CBC', substr(hash('sha256',$key,true),0,32), OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv.$cipher);
    }
    public static function decryptSecret(string $secret, string $key): string {
        $raw = base64_decode($secret, true); if (!$raw || strlen($raw) < 17) return '';
        return openssl_decrypt(substr($raw,16), 'AES-256-CBC', substr(hash('sha256',$key,true),0,32), OPENSSL_RAW_DATA, substr($raw,0,16)) ?: '';
    }
}
