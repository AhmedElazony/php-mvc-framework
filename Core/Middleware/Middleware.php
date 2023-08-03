<?php

namespace Core\Middleware;

class Middleware
{
    protected const MIDDLEWARES = [
        'auth' => Auth::class,
        'guest' => Guest::Class
    ];
    public static function handle($middleware): void
    {
        if (! array_key_exists($middleware, self::MIDDLEWARES)) {
            return;
        }

        $middlewareClass = self::MIDDLEWARES[$middleware];

        (new $middlewareClass)->handle();
    }
}