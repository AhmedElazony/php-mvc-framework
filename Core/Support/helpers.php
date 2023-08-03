<?php

use Core\Http\Response;
use Core\Http\Router;
use Core\Session;
use JetBrains\PhpStorm\NoReturn;

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

function model($model)
{
    return require base_path("App/Models/{$model}.php");
}

function urlIs($url): bool
{
    if ($url === \Core\Http\Request::uri()) {
        return true;
    }
    return false;
}

#[NoReturn] function redirect($path): void
{
    header("location: {$path}");
    exit;
}

#[NoReturn] function previousUrl(): void
{
    header('location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

function authorize($condition, $code = Response::FORBIDDEN): void
{
    if (! $condition) {
        abort($code);
        exit;
    }
}

function login($user, $attribute = []): void
{
    Session::put($user, $attribute);
    session_regenerate_id(true);
}
function logout($user): void
{
    Session::destroy();
}
function abort($code = Response::NOT_FOUND)
{
    Response::setStatusCode($code);
    return view("Errors/{$code}", [
        'heading' => "Error {$code}!"
    ]);
}