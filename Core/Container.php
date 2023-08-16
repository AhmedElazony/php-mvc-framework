<?php

namespace Core;

use Core\Database\QueryBuilder;
use Exception;

class Container
{
    protected array $bindings = [];

    public function bind(string $key,  $value): void // add
    {
        $this->bindings[$key] = $value;
    }

    /**
     * @throws Exception
     */
    public function resolve(string $key): mixed // get
    {
        if (! array_key_exists($key, $this->bindings)) {
            throw new Exception("{$key} Not Found!");
        }

        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }
}