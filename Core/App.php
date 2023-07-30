<?php

namespace Core;

use Core\Http\Request;
use Core\Http\Router;

class App
{
    protected static array $bindings = [];

    public static function run()
    {
        return Router::load('Routes/web.php')
            ->resolve(Request::uri(), Request::method());
    }

    public static function bind(string $key, callable $value): void // add
    {
        self::$bindings[$key] = $value;
    }
    public static function resolve(string $key) // get
    {
        if (! array_key_exists($key, self::$bindings)) {
            throw new \Exception('Key Not Found!');
        }

        $resolver = self::$bindings[$key];

        return call_user_func($resolver);
    }
}