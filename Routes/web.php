<?php

use Core\Http\Router as Route;

Route::get('', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('about', 'HomeController@about');

