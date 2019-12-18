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



Route::group(['namespace' => 'App\Modules\AdminMail\Controllers', 'middleware' => ['web']], function () {
 
	Route::post('/admin/api/mail/change-status', 'Api\MailController@changeStatus');

	Route::resources([
	    'admin/mail-settings' => 'MailController'
	]);
});
 