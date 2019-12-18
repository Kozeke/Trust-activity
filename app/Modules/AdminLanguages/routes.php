<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::group(['namespace' => 'App\Modules\AdminLanguages\Controllers', 'middleware' => ['web']], function () {
 
	Route::post('admin/languages/accept', 'LanguagesController@accept');
	Route::post('admin/languages/decline', 'LanguagesController@decline');

	Route::post('api/languages/add', 'Api\LanguagesController@add');
	Route::post('api/languages/list', 'Api\LanguagesController@list');
	Route::post('api/languages/value', 'Api\LanguagesController@value');
	Route::post('api/languages/value/update', 'Api\LanguagesController@valueUpdate');
	
	Route::resources([
	    'admin/languages' => 'LanguagesController'
	]);
});
 