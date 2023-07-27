<?php

use Core\App;
use Core\Container;
use Core\Database\Connection;
use Core\Database\QueryBuilder;

App::setContainer(new Container());

App::bind('database', function () {
    $config = require base_path('Config/config.php');

    return new QueryBuilder(Connection::make($config['database']));
});