<?php
namespace App\Core;

final class Router
{
    private array $routes = ['GET'=>[], 'POST'=>[], 'PUT'=>[], 'DELETE'=>[]];

    public function get(string $path, callable $handler): void { $this->routes['GET'][$path] = $handler; }
    public function post(string $path, callable $handler): void { $this->routes['POST'][$path] = $handler; }
    public function put(string $path, callable $handler): void { $this->routes['PUT'][$path] = $handler; }
    public function delete(string $path, callable $handler): void { $this->routes['DELETE'][$path] = $handler; }

    public function dispatch(string $method, string $uri): void
    {
        $path = rtrim(parse_url($uri, PHP_URL_PATH) ?: '/', '/') ?: '/';
        $handler = $this->routes[$method][$path] ?? null;
        if (!$handler) {
            http_response_code(404);
            App::view('errors/404', ['title'=>'Page not found']);
            return;
        }
        $handler();
    }
}
