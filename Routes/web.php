<?php

use Core\Http\Router as Route;

Route::get('', 'HomeController@index');
Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');

Route::get('/login', 'HomeController@loginUser', 'guest');
Route::post('/login', 'AuthController@loginUser', 'guest');

Route::get('/register', 'HomeController@registerUser', 'guest');
Route::post('/register', 'AuthController@registerUser', 'guest');

Route::get('/notes', 'AppController@index', 'auth');
Route::get('/notes/create', 'AppController@create', 'auth');
Route::post('/notes/create', 'AppController@saveNote', 'auth');
Route::get('/notes/edit', 'AppController@edit', 'auth');
Route::put('/notes/edit', 'AppController@editNote', 'auth');
Route::get('/note', 'AppController@show', 'auth');
Route::post('/note', 'AppController@addComment', 'auth');
Route::delete('/note', 'AppController@deleteNote', 'auth');
Route::delete('/note/deleteComment', 'AppController@deleteComment', 'auth');

Route::get('/password/update', 'HomeController@editPassword', 'guest');
Route::put('/password/update', 'AuthController@updatepassword', 'guest');

Route::delete('/logout', 'AuthController@logout', 'auth');