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



Route::group(['namespace' => 'App\Modules\AdminWithdraw\Controllers', 'middleware' => ['web']], function () {
 
	Route::post('admin/withdraw/accept', 'WithdrawController@accept');
	Route::post('admin/withdraw/decline', 'WithdrawController@decline');

	Route::resources([
	    'admin/withdraw' => 'WithdrawController'
	]);
});
 