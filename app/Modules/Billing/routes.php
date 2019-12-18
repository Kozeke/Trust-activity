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
 
Route::group(['namespace' => 'App\Modules\Billing\Controllers', 'middleware' => ['web']], function () {
 
	Route::get('/admin/dashboard', 'BillingController@dashboard');
	Route::post('/api/billing/list', 'Api\BillingController@getList');
	Route::post('/api/billing/buy', 'Api\BillingController@postList');
	Route::post('/api/billing/status', 'Api\BillingController@changeStatus');

	/*Route::get('/api/checkout/test', 'CheckOutController@test');
	Route::post('/api/checkout/test2', 'CheckOutController@test2');*/

	Route::post('/api/checkout/pay', 'CheckOutController@pay');
	//Route::post('/topup/pay', 'TopupController@pay');


});
 