<?php

namespace Core;

class App
{
    protected static Container $container;

    public static function setContainer(Container $container): void
    {
        static::$container = $container;
    }

    public static function container(): Container
    {
        return static::$container;
    }

    public static function bind($key, $value): void // add
    {
        static::container()->bind($key, $value);
    }
    public static function resolve($key) // get
    {
       return static::container()->resolve($key);
    }


}