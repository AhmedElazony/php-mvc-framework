<?php

namespace Core;

use Core\Database\QueryBuilder;
use Core\Http\Request;
use Core\Http\Router;
use Exception;

class Application
{
    protected static Container $container;

    public static function run()
    {
        return Router::load('Routes/web.php')
            ::resolve(Request::uri(), Request::method());
    }

    public static function setContainer(Container $container = new Container()): void
    {
        self::$container = $container;
    }
    public static function container(): Container
    {
        return self::$container;
    }

    public static function bind(string $key, $value): void // add
    {
        self::container()->bind($key, $value);
    }

    public static function resolve(string $key) // get
    {
        return self::container()->resolve($key);
    }
}