<?php

namespace Core\Http;

use Core\Middleware\Middleware;

class Router
{
    protected array $routes = [];
    protected string $method;
    protected string $uri;

    protected function add($method, $uri, $controller, $middleware): void
    {
        $this->routes[$method][$uri] = [
            'controller' => $controller,
            'middleware' => $middleware
        ];
    }
    public function get($uri, $controller, $only = null): self
    {
        $this->method = 'GET';
        $this->uri = $uri;
        $this->add('GET', $uri, $controller, $only);
        return $this;
    }
    public function post($uri, $controller, $only = null): static
    {
        $this->method = 'POST';
        $this->uri = $uri;
        $this->add('POST', $uri, $controller, $only);
        return $this;
    }
    public function delete($uri, $controller, $only = null): static
    {
        $this->method = 'DELETE';
        $this->uri = $uri;
        $this->add('DELETE', $uri, $controller, $only);
        return $this;
    }
    public function patch($uri, $controller, $only = null): static
    {
        $this->method = 'PATCH';
        $this->uri = $uri;
        $this->add('PATCH', $uri, $controller, $only);
        return $this;
    }
    public function put($uri, $controller, $only = null): static
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
        if (is_array($middlewares)) {
            foreach ($middlewares as $middleware) {
                $this->routes[$this->method][$this->uri]['middleware'] = $middleware;
            }
        } else {
            $this->routes[$this->method][$this->uri]['middleware'] = $middlewares;
        }

        return $this;
    }

    public function resolve($uri, $method)
    {
        $route = $this->routes[strtoupper($method)][$uri] ?? false;

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