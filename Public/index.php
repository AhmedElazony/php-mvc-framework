<?php

use Core\Application as App;

session_start();

const BASE_PATH = __Dir__ . '/../';

require BASE_PATH . 'vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

require BASE_PATH . 'Core/Support/helpers.php';

require base_path('bootstrap.php');

App::run();