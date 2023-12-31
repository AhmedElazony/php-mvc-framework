<?php

namespace Core\Http;

use Core\Middleware\Middleware;

class Router
{
    protected static array $routes = [];

    protected static function add($method, $uri, $controller, $middleware): void
    {
        static::$routes[$method][$uri] = [
            'controller' => $controller,
            'middleware' => $middleware
        ];

//        return new static;
    }
    public static function get($uri, $controller, $only = null): void
    {
        static::add('GET', $uri, $controller, $only);
    }
    public static function post($uri, $controller, $only = null): void
    {
        static::add('POST', $uri, $controller, $only);
    }
    public static function delete($uri, $controller, $only = null): void
    {
        static::add('DELETE', $uri, $controller, $only);
    }
    public static function patch($uri, $controller, $only = null): void
    {
        static::add('PATCH', $uri, $controller, $only);
    }
    public static function put($uri, $controller, $only = null): void
    {
        static::add('PUT', $uri, $controller, $only);
    }

    public static function load($routesFile): static
    {
        require base_path($routesFile);
        return new static;
    }
    public function resolve($uri, $method)
    {
        $route = self::$routes[strtoupper($method)][$uri] ?? false;

        if ($route) {
            if (is_string($route['controller'])) {
                $parts = explode('@', $route['controller']);

                // handle The Requested Middleware.
                Middleware::handle($route['middleware']);

                $controller = 'App\\Controllers\\' . $parts[0];
                $action = $parts[1];

                return $this->callAction($controller, $action);
            }
        }
        return abort();
    }

    protected function callAction($controller, $action)
    {
        if (class_exists($controller)) {
            if (method_exists($controller, $action)) {
                return (new $controller)->$action();
            }
        }

        return "{$controller} does not respond to the {$action} action.";
    }
}