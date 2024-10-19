<?php

namespace Core\Facades;

use Core\Support\Facade;

class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Core\Http\Router::class;
    }
}