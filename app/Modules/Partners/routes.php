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

Route::group(['namespace' => 'App\Modules\Partners\Controllers', 'middleware' => ['web']], function () {
 
	Route::get('admin/partners-list', 'PartnersController@AdminList');
	
	Route::post('admin/partners-list/accept', 'PartnersController@accept');
	Route::post('admin/partners-list/decline', 'PartnersController@decline');

	Route::get('admin/partners/enter/partner', 'PartnersController@enterAsPartner');
	Route::get('admin/partners/enter/{id}', 'PartnersController@enterAsUser');
	Route::post('admin/partners/request', 'PartnersController@sendRequest');	

	Route::resources([
	    'admin/partners' => 'PartnersController'
	]);
});
 