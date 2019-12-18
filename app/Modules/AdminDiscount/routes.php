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



Route::group(['namespace' => 'App\Modules\AdminDiscount\Controllers', 'middleware' => ['web']], function () {
 
	//Route::post('admin/withdraw/accept', 'WithdrawController@accept');
	Route::post('admin/promo-codes/update/{id}', 'DiscountController@update');
	Route::post('admin/promo-codes/get-code', 'Api\DiscountController@getCode');
	Route::post('admin/promo-codes/delete', 'Api\DiscountController@delete');

	Route::resources([
	    'admin/promo-codes' => 'DiscountController'
	]);
});
 