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
        $router = new static();
        require base_path($routesFile);
        return $router;
    }
    public function resolve($uri, $method)
    {
        $controllerAction = self::$routes[strtoupper($method)][$uri] ?? false;
        if (! $controllerAction) {
            return $this->abort();
        }

        $controller = new ('App\\Controllers\\' . explode('@', $controllerAction)[0]);
        $action =  explode('@', $controllerAction)[1];
        return call_user_func([$controller, $action]);
    }
    protected function abort($code = Response::NOT_FOUND)
    {
        http_response_code($code);
        return view("Errors/{$code}");
    }
}