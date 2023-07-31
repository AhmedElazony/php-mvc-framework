<?php

namespace Core\Http;

class Router
{
    protected static array $routes = [];

    protected static function add($method, $uri, $controller): Router
    {
        static::$routes[$method][$uri] = $controller;

        return new static;
    }
    public static function get($uri, $controller): Router
    {
        return static::add('GET', $uri, $controller);
    }
    public static function post($uri, $controller): Router
    {
        return static::add('POST', $uri, $controller);
    }
    public static function delete($uri, $controller): Router
    {
        return static::add('DELETE', $uri, $controller);
    }
    public static function patch($uri, $controller): Router
    {
        return static::add('PATCH', $uri, $controller);
    }
    public static function put($uri, $controller): Router
    {
        return static::add('PUT', $uri, $controller);
    }

    public static function load($routesFile): static
    {
        require base_path($routesFile);
        return new static;
    }
    public static function resolve($uri, $method)
    {
        $controllerAction = self::$routes[strtoupper($method)][$uri] ?? false;

        if ($controllerAction) {
            if (is_string($controllerAction)) {
                $parts = explode('@', $controllerAction);

                $controller = 'App\\Controllers\\' . $parts[0];
                $action = $parts[1];

                if (class_exists($controller)) {
                    if (method_exists($controller, $action)) {
                        return (new $controller)->$action();
                    }
                }
            }
        }
        return (new Router)->abort();
    }
    protected function abort($code = Response::NOT_FOUND)
    {
        Response::setStatusCode($code);
        return view("Errors/{$code}", [
            'heading' => "Error {$code}!"
        ]);
    }
}