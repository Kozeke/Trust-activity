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



Route::group(['namespace' => 'App\Modules\AdminPaymentHistory\Controllers', 'middleware' => ['web']], function () {
    Route::get('/api/payment_history', 'AdminPaymentHistoryController@getHistory');

    Route::resources([
	    'admin/payment-history' => 'AdminPaymentHistoryController'
	]);
});
 