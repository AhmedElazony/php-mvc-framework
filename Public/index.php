<?php

use Core\Application as App;

const BASE_PATH = __Dir__ . '/../';

require BASE_PATH . 'vendor/autoload.php';

require BASE_PATH . 'Core/Support/helpers.php';

require base_path('bootstrap.php');

App::run();