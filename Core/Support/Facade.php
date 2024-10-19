<?php

namespace Core\Support;

abstract class Facade
{
    protected static array $instances = [];

    abstract protected static function getFacadeAccessor();

    public static function __callStatic($method, $args)
    {
        $instance = static::resolveFacadeInstance(static::getFacadeAccessor());

        if (!$instance) {
            throw new \RuntimeException("A facade root has not been set.");
        }

        return $instance->$method(...$args);
    }

    protected static function resolveFacadeInstance(string $class)
    {
        if (is_object($class)) {
            return $class;
        }

        if (isset(static::$instances[$class])) {
            return static::$instances[$class];
        }

        return static::$instances[$class] = new $class();
    }
}