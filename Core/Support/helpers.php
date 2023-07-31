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

function view($file, $params = []): mixed
{
    extract($params);
    return require base_path("Views/{$file}.view.php");
}

function urlIs($url): bool
{
    if ($url === \Core\Http\Request::uri()) {
        return true;
    }
    return false;
}