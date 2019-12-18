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

 
Route::post('api/basedata', '\App\Modules\Panel\Controllers\Api\BaseController@getBaseData');
Route::post('api/hot-streak/activity', '\App\Modules\Panel\Controllers\Api\BaseController@postAcitvity');

Route::group(['namespace' => 'App\Modules\Panel\Controllers', 'middleware' => ['web']], function () {
 

	Route::get('auth/facebook', 'SocialFacebookController@redirectToProvider');
	Route::get('auth/facebook/callback', 'SocialFacebookController@handleProviderCallback');
	Route::get('auth/google', 'SocialGoogleController@redirectToProvider');
	Route::get('auth/google/callback', 'SocialGoogleController@handleProviderCallback');
	Route::get('auth/twitter', 'SocialTwitterController@redirectToProvider');
	Route::get('auth/twitter/callback', 'SocialTwitterController@handleProviderCallback');

	Route::get('/admin/change-lang/{slug}', 'PanelController@changeLang');

	Route::get('auth/reset/success', '\App\Modules\Panel\Controllers\ResetController@getSuccess');
	Route::get('auth/reset/{token}', '\App\Modules\Panel\Controllers\ResetController@getRestorePassword');
	Route::post('auth/reset/save', '\App\Modules\Panel\Controllers\ResetController@postRestorePasswordSave');

	Route::get('/admin/guide-step-1', 'PanelController@guide_1');
	Route::get('/admin/guide-step-2', 'PanelController@guide_2');
	Route::get('/admin/settings', 'PanelController@settings');
	Route::get('/admin/top-up', 'PanelController@topUp');
	Route::get('/admin/resolution-center', 'PanelController@resolutionCenter');
	Route::get('/admin/faq', 'PanelController@faq');
	Route::get('/admin', 'PanelController@index');
	Route::get('/admin/video-instruction', 'PanelController@video');
	Route::get('/admin/guide', 'PanelController@showGuide');

	Route::resources([
		'auth/reset'    => 'ResetController',
		'auth/logout'   => 'LogoutController',
	    'auth/login'     => 'AuthController',
	    'auth/register'  => 'RegisterController',
	]);
});
 