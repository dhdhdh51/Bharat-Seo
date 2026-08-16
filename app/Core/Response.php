<?php
namespace App\Core;
final class Response {
    public static function json(bool $success, string $message, array $data = [], int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode(['success'=>$success,'message'=>$message,'data'=>$data], JSON_UNESCAPED_SLASHES);
    }
}
