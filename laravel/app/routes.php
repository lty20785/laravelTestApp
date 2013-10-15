<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');


Route::get('login', array('as' => 'login', 'uses' => 'AuthController@showLogin'));
Route::post('login', 'AuthController@doLogin' );
Route::any('logout', 'AuthController@doLogout');
Route::get('register', array('as' => 'register', 'uses' => 'AuthController@showRegister'));
Route::post('register', 'AuthController@doRegister' );

Route::group(array('before' => 'auth'), function()
{
    Route::get('check', 'HomeController@showCheckForLogin');
});

