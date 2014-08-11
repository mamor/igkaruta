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

Route::when('*', 'csrf', ['post', 'put', 'delete']);

Route::group(['namespace' => 'My\App\Controller'], function () {
	Route::controller('auth', 'AuthController');

	Route::group(['before' => 'auth'], function () {
		Route::get('karuta', ['uses' => 'FrontController@getIndex']);
		Route::controller('api', 'ApiController');
	});

	Route::controller('/', 'IndexController');
});
