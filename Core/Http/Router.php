<?php

namespace Core\Http;

use Core\Middleware\Middleware;

class Router
{
    protected array $routes = [];
    protected string $method;
    protected string $uri;

    protected function add(string $method, string $uri, string|array $controller, array|string $middlewares): void
    {
        $this->routes[$method][$uri] = [
            'controller' => $controller,
            'middlewares' => $middlewares
        ];
    }
    public function get(string $uri, string|array $controller, array|string $only = []): self
    {
        $this->method = 'GET';
        $this->uri = $uri;
        $this->add('GET', $uri, $controller, $only);
        return $this;
    }
    public function post(string $uri, string|array $controller, array|string $only = []): static
    {
        $this->method = 'POST';
        $this->uri = $uri;
        $this->add('POST', $uri, $controller, $only);
        return $this;
    }
    public function delete(string $uri, string|array $controller, array|string $only = []): static
    {
        $this->method = 'DELETE';
        $this->uri = $uri;
        $this->add('DELETE', $uri, $controller, $only);
        return $this;
    }
    public function patch(string $uri, string|array $controller, array|string $only = []): static
    {
        $this->method = 'PATCH';
        $this->uri = $uri;
        $this->add('PATCH', $uri, $controller, $only);
        return $this;
    }
    public function put(string $uri, string|array $controller, array|string $only = []): static
    {
        $this->method = 'PUT';
        $this->uri = $uri;
        $this->add('PUT', $uri, $controller, $only);
        return $this;
    }

    public function load($routesFile): static
    {
        require base_path($routesFile);
        return $this;
    }

    public function middleware(string|array $middlewares): static
    {
        $this->routes[$this->method][$this->uri]['middlewares'] = (array) $middlewares;

        return $this;
    }

    public function resolve($uri, $method)
    {
        $route = $this->routes[strtoupper($method)][$uri] ?? false;

        if ($route) {
            if (is_string($route['controller'])) {
                $parts = explode('@', $route['controller']);

                // handle The Requested Middleware.
                foreach ($route['middlewares'] as $middleware) {
                    Middleware::handle($middleware);
                }

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