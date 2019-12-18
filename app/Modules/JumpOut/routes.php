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
 
Route::post('api/jumpout/activity', '\App\Modules\JumpOut\Controllers\Api\PublicController@storeActivity');
 
Route::group(['namespace' => 'App\Modules\JumpOut\Controllers', 'middleware' => ['web']], function () {
 
	Route::get('admin/domains/{id}/jumpout/', 'JumpOutController@getList');
	Route::get('admin/domains/{id}/jumpout/add', 'JumpOutController@getAdd');
	Route::get('admin/domains/{id}/jumpout/redactor', 'JumpOutController@getRedactor');
	Route::get('admin/domains/{domain_id}/jumpout/{module_id}', 'JumpOutController@getEdit');
	Route::get('admin/domains/{domain_id}/jumpout/{module_id}/redactor', 'JumpOutController@getRedactorEdit');
  
 	Route::post('api/jumpout/save-temp', 'Api\JumpOutController@saveTemp');
 	Route::post('api/jumpout/store-redactor', 'Api\JumpOutController@storeRedactor');
 	Route::post('api/jumpout/store-template', 'Api\JumpOutController@storeTemplate');
 	
 	Route::post('api/jumpout/get-gallery', 'Api\JumpOutController@getUserGallery');
 	Route::post('api/jumpout/store', 'Api\JumpOutController@storeCompany');

 	Route::post('api/jumpout/get-list', 'Api\JumpOutController@getList');	
 	Route::post('api/jumpout/load-template', 'Api\JumpOutController@loadTemplate');	
 
 	Route::post('api/domains/jumpout/post-delete', 'Api\JumpOutController@delete');	
  	Route::post('api/domains/jumpout/post-status', 'Api\JumpOutController@postStatus');		
 
	/*Route::resources([
	    'admin/domains' => 'DomainsController'
	]);*/
});
 