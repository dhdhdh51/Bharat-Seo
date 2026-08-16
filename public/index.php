<?php
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) return;
    $file = __DIR__ . '/../app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) require $file;
});
$config = file_exists(__DIR__.'/../config/config.php') ? require __DIR__.'/../config/config.php' : require __DIR__.'/../config/config.example.php';
\App\Core\App::boot($config);
$router = new \App\Core\Router();
$router->get('/', fn() => \App\Core\App::view('public/landing', ['title'=>'CareerForge AI - AI Resume Builder']));
$router->get('/dashboard', fn() => \App\Core\App::view('dashboard/index', ['title'=>'Dashboard']));
$router->get('/builder', fn() => \App\Core\App::view('builder/index', ['title'=>'CV Builder']));
$router->get('/admin', fn() => \App\Core\App::view('admin/index', ['title'=>'Admin Dashboard']));
$router->get('/login', fn() => \App\Core\App::view('auth/login', ['title'=>'Login']));
$router->get('/register', fn() => \App\Core\App::view('auth/register', ['title'=>'Create Account']));
if (str_starts_with(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/', '/api/')) {
    require __DIR__.'/../routes/api.php';
    exit;
}
$method = $_SERVER['REQUEST_METHOD'] === 'HEAD' ? 'GET' : $_SERVER['REQUEST_METHOD'];
$router->dispatch($method, $_SERVER['REQUEST_URI']);
