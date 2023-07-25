<?php

function dump_die($var): void
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';

    die();
}

function base_path($path): string
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);
    return require base_path("Views/{$path}");
}