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



Route::group(['namespace' => 'App\Modules\Blog\Controllers', 'middleware' => ['web']], function () {
 
	Route::get('admin/blog/{category_id}/create-article', 'BlogController@createArticle'); 
 	Route::post('admin/blog/create-article', 'BlogController@storeArticle'); 
	Route::get('admin/blog/edit/{category_id}', 'BlogController@editCategory'); 

	Route::get('admin/blog/{category_id}/edit/{article_id}', 'BlogController@editArticle'); 
	Route::put('admin/blog/article/{article_id}', 'BlogController@updateArticle'); 
	Route::delete('admin/blog/article/{article_id}', 'BlogController@destroyArticle'); 


	Route::resources([
	    'admin/blog' => 'BlogController'
	]);
});
 