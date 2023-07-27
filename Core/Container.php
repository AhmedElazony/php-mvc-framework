<?php

namespace Core;

class Container
{
    protected array $bindings = [];

    public function bind($key, $value): void // add
    {
        $this->bindings[$key] = $value;
    }
    public function resolve($key) // get
    {
        if (! array_key_exists($key, $this->bindings)) {
            throw new \Exception('Key Not Found!');
        }

        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }
}