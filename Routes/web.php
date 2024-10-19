<?php

use Core\Facades\Route;

Route::get('', 'HomeController@index');
Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');
Route::get('/home', 'HomeController@index');

Route::get('/login', 'HomeController@loginUser')->middleware('guest');
Route::post('/login', 'AuthController@loginUser')->middleware('guest');

Route::get('/register', 'HomeController@registerUser')->middleware('guest');
Route::post('/register', 'AuthController@registerUser')->middleware('guest');

Route::get('/notes', 'AppController@index')->middleware('auth');
Route::get('/notes/create', 'AppController@create')->middleware('auth');
Route::post('/notes/create', 'AppController@saveNote')->middleware('auth');
Route::get('/notes/edit', 'AppController@edit')->middleware('auth');
Route::put('/notes/edit', 'AppController@editNote')->middleware('auth');
Route::get('/note', 'AppController@show')->middleware('auth');
Route::post('/note', 'AppController@addComment')->middleware('auth');
Route::delete('/note', 'AppController@deleteNote')->middleware('auth');
Route::delete('/note/deleteComment', 'AppController@deleteComment')->middleware('auth');

Route::get('/password/update', 'HomeController@editPassword')->middleware('guest');
Route::put('/password/update', 'AuthController@updatepassword')->middleware('guest');

Route::delete('/logout', 'AuthController@logout')->middleware('auth');