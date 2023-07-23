<?php

namespace Core\Http;

class Router
{
    protected array $routes = [];

    protected function add($method, $uri, $controller): Router
    {
        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller
        ];
        return $this;
    }
    public function get($uri, $controller): Router
    {
        return $this->add('GET', $uri, $controller);
    }
    public function post($uri, $controller): Router
    {
        return $this->add('POST', $uri, $controller);
    }
    public function delete($uri, $controller): Router
    {
        return $this->add('DELETE', $uri, $controller);
    }
    public function patch($uri, $controller): Router
    {
        return $this->add('PATCH', $uri, $controller);
    }
    public function put($uri, $controller): Router
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                return require(BASE_PATH . "App/Controllers" . $route['controller']);
            }
        }
        return $this->abort();
    }
    protected function abort($code = Response::NOT_FOUND)
    {
        http_response_code($code);
        return view("{$code}.php");
    }
}