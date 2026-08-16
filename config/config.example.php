<?php
return [
    'app' => [
        'name' => getenv('APP_NAME') ?: 'CareerForge AI',
        'url' => getenv('APP_URL') ?: 'https://example.com',
        'env' => getenv('APP_ENV') ?: 'production',
        'debug' => false,
        'key' => getenv('APP_KEY') ?: 'change-me-32-char-random-secret',
        'timezone' => 'UTC',
    ],
    'database' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'name' => getenv('DB_DATABASE') ?: 'careerforge',
        'user' => getenv('DB_USERNAME') ?: 'careerforge_user',
        'pass' => getenv('DB_PASSWORD') ?: '',
        'charset' => 'utf8mb4',
    ],
    'security' => [
        'session_name' => 'careerforge_session',
        'csrf_key' => 'csrf_token',
        'remember_cookie' => 'careerforge_remember',
        'login_rate_limit' => 5,
        'password_min_length' => 10,
    ],
    'uploads' => ['max_photo_mb'=>2, 'allowed_mimes'=>['image/jpeg','image/png','image/webp']],
    'features' => ['google_oauth'=>false, 'public_cv'=>true, 'docx_export'=>false],
];
