<?php
namespace App\Services;

use PDO;

final class AuthService
{
    public function __construct(private PDO $db) {}

    public function register(string $name, string $email, string $password): array
    {
        $stmt = $this->db->prepare('INSERT INTO users (name,email,password_hash,ai_credits,ats_scans,created_at) VALUES (?,?,?,?,?,NOW())');
        $stmt->execute([$name, strtolower($email), password_hash($password, PASSWORD_DEFAULT), 50, 1]);
        $userId = (int)$this->db->lastInsertId();
        $token = bin2hex(random_bytes(32));
        $this->db->prepare('INSERT INTO email_verifications (user_id, token_hash, expires_at, created_at) VALUES (?,?,DATE_ADD(NOW(), INTERVAL 24 HOUR),NOW())')->execute([$userId, hash('sha256', $token)]);
        return ['user_id'=>$userId, 'verification_token'=>$token];
    }

    public function login(string $email, string $password): bool
    {
        $stmt = $this->db->prepare('SELECT id,password_hash FROM users WHERE email=? LIMIT 1');
        $stmt->execute([strtolower($email)]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password_hash'] ?? '')) return false;
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id'];
        return true;
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }
}
