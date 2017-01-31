<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => ['unauth.user']], function(){
    Route::get('/login', 'User\LoginController@showLoginPage');
    Route::post('/login', 'User\LoginController@handleLoginRequest');
});

Route::group(['middleware' => ['auth.user']], function(){
    Route::get('/', 'User\UIController@showIndexPage');

    Route::get('/logout', 'User\LoginController@showLogoutPage');
    Route::post('/logout', 'User\LoginController@handleLogout');

    Route::get('/author', 'User\AuthorController@showAuthorPage');
    Route::post('/author', 'User\AuthorController@handleAuthorization');
});
