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



Route::group(['namespace' => 'App\Modules\Users\Controllers', 'middleware' => ['web']], function () {
 
	Route::post('/api/user/timezone', 'Api\UsersController@timezone');

 	Route::get('/admin/users/promote/{id}', 'UsersController@promote');
	Route::get('/admin/users/enter/admin', 'UsersController@enterAsAdmin');
	Route::get('/admin/users/enter/{id}', 'UsersController@enterAsUser');

	Route::post('/api/users/balance', 'Api\UsersController@postBalance');
	Route::post('/api/users/list', 'Api\UsersController@getList');
	Route::post('/api/users/delete', 'Api\UsersController@postDelete');
	Route::resources([
	    'admin/users' => 'UsersController'
	]);
});
 