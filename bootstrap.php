<?php

use Core\Application as App;
use Core\Database\Database;
use Core\Database\QueryBuilder;

App::setContainer(new \Core\Container());
App::bind(Database::class, function () {
    $config = require base_path('Config/config.php');

    return new QueryBuilder(Database::connect($config['database']));
});