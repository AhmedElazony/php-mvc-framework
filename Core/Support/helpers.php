<?php

use Core\ErrorBag;
use Core\Http\Response;
use Core\Application as App;
use Core\Database\Database;
use Core\Session;
use Core\Validator as Validate;
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
//    if (! class_exists($model)) {
//        exit;
//    }
    return (new $model(App::resolve(Database::class)));
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
// TODO: Refactor
function login($user, $attribute = []): void
{
    Session::put($user, $attribute);
    session_regenerate_id(true);
}
// TODO: Refactor
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

/* TODO: Refactor */
function showErrors($viewFile, $params = []): void
{
    if (! empty(ErrorBag::errors())) {
        view("Notes/{$viewFile}", $params);
        exit;
    }
}

/* TODO: Refactor */
function getNoteInputs(): array
{
    $title = $_POST['title'] ?? '';
    $body = $_POST['body'] ?? '';

    if (! Validate::string($title, 7, 25)) {
        ErrorBag::setError('title', 'A Title between 7 and 55 Chars is Required!');
    }
    if (! Validate::string($body, 7, 255)) {
        ErrorBag::setError('body', 'A Note Body between 7 and 255 Chars is Required!');
    }

    return ['title' => $title, 'body' => $body, 'errors' => ErrorBag::errors()];
}

function getInputs(array $data): array
{
    $inputs = [];
    foreach ($data as $key)
    {
        $inputs[$key] = $_POST[$key] ?? '';
    }

    return $inputs;
}