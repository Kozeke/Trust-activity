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



Route::group(['namespace' => 'App\Modules\Faq\Controllers', 'middleware' => ['web']], function () {
 
	Route::get('admin/questions/{category_id}/create-article', 'FaqController@createArticle'); 
 
	Route::post('admin/questions/create-article', 'FaqController@storeArticle'); 
	Route::post('admin/questions-category', 'FaqController@storeCategory'); 
	Route::put('admin/questions/article/{article_id}', 'FaqController@updateArticle'); 
	Route::delete('admin/questions/article/{article_id}', 'FaqController@destroyArticle'); 

	Route::get('admin/questions/edit/{category_id}', 'FaqController@editCategory'); 
	Route::get('admin/questions/{category_id}/edit/{article_id}', 'FaqController@editArticle'); 

	Route::resources([
	    '/admin/questions' => 'FaqController',
	    '/admin/faq'      => 'FaqUserController',
	]);

	Route::get('admin/faq/{category_url}/{article_url}', 'FaqUserController@showArticle'); 
});
 