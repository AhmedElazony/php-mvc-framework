<?php

use Core\Http\Router;
use Core\Http\Request;

const BASE_PATH = __Dir__ . '/../';

require BASE_PATH . 'vendor/autoload.php';

require BASE_PATH . 'Core/functions.php';

require base_path('bootstrap.php');

Router::load('routes.php')
    ->route(Request::uri(), Request::method());
