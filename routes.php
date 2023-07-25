<?php

$router->get('', '/index.php');
$router->get('home', '/index.php');
$router->get('about', 'PageController@about');

$router->get('login', '/Session/create.php');
$router->get('signup', '/Registration/create.php');


