<?php

use Core\Http\Router as Route;

Route::get('', 'HomeController@index');
Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');