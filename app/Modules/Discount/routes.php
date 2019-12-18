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

Route::group(['namespace' => 'App\Modules\Discount\Controllers', 'middleware' => ['web']], function () {

 	Route::post('admin/discount/emails', 'Api\DiscountController@emails'); 
 	Route::post('admin/discount/transfer', 'Api\DiscountController@transfer'); 
 	Route::post('admin/discount/withdraw', 'Api\DiscountController@withdraw'); 
 	
	Route::resources([
	    'admin/discount' => 'DiscountController'
	]);
});
 