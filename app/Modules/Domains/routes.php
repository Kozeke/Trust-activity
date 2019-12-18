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
	Route::get('admin/domains/test', 'App\Console\Commands\UpdateIsInstalled@handle');
 
Route::group(['namespace' => 'App\Modules\Domains\Controllers', 'middleware' => ['web']], function () {

	Route::post('/api/domains/notification/presets', 'Api\HotStreakController@addPresets');
	Route::get('admin/domains/test', function(){

		/*$string = file_get_contents("results.json");
		$json   = json_decode($string, true);
 
		foreach ($json['posts'] as $key => $value) {
			//print_r($value);
            $item = new App\LanguageValues();
            $item->name  = $value['name'];    
            $item->slug  = $value['slug'];    
            $item->value = $value['value'];    
            $item->language_id = $value['language_id'];
            $item->save();  
		}*/

		/*$json_a = json_decode($string, true);

		$jsonIterator = new RecursiveIteratorIterator(
		    new RecursiveArrayIterator(json_decode($json_a, TRUE)),
		    RecursiveIteratorIterator::SELF_FIRST);

		foreach ($jsonIterator as $key => $val) {
		    if(is_array($val)) {
		        echo "$key:\n";
		    } else {
		        echo "$key => $val\n";
		    }
		}*/

		/*$spisok = DB::table('language_values')->get();


		$response = array();
		$posts = array();
 
		foreach ($spisok as $key => $value) {

			$arr = [
				'id'   => $value->id,
				'name' => $value->name,
				'slug' => $value->slug,
				'language_id' => $value->language_id,				
				'created_at'  => $value->created_at,
				'updated_at'  => $value->updated_at,			
			];

		  $posts[] = $arr;
		} 

		$response['posts'] = $posts;

		$fp = fopen('results.json', 'w');
		fwrite($fp, json_encode($response));
		fclose($fp);*/


		/*foreach ($spisok as $key => $value) {

			$arr = [
				'id'   => $value->id,
				'name' => $value->name,
				'slug' => $value->slug,
				'language_id' => $value->language_id,				
				'created_at'  => $value->created_at,
				'updated_at'  => $value->updated_at,			
			];

			print_r($arr);
		}*/


	});


	Route::get('admin/domains/sendmail', 'DomainMailEventsController@init');
	Route::get('admin/domains/{id}', 'DomainsController@getItem');

	Route::get('admin/domains/{id}/new', 'DomainsController@getItemNew');
	
	Route::get('admin/domains/{id}/notification/add', 'HotStreakController@getAdd');
	Route::get('admin/domains/{id}/notification/settings', 'HotStreakController@showSettings');
	Route::get('admin/domains/{domain_id}/notification/{module_id}', 'HotStreakController@getEdit');

	Route::post('api/domains/notification/add', 'HotStreakController@postAdd');
	Route::post('api/domains/notification/update', 'HotStreakController@postEdit');

	Route::post('api/domains/notification/rename', 'Api\HotStreakController@changeName');
	Route::post('api/domains/notification/post-status', 'Api\HotStreakController@postStatus');
	Route::post('api/domains/notification/post-delete', 'Api\HotStreakController@postDelete');
	Route::post('api/domains/notification/get-list', 'Api\HotStreakController@getList');
	Route::post('api/domains/add', 'Api\DomainsController@postAdd');
	Route::post('api/domains/delete', 'Api\DomainsController@postDelete');
	Route::post('api/domains/validate', 'Api\DomainsController@validateDomain');
	Route::post('api/domains/notification/settings/update', 'Api\HotStreakController@updateSettings');
	Route::post('api/domains/get-instruction', 'Api\DomainsController@getInstruction');
	Route::post('api/domains/isInstalled', 'Api\DomainsController@getInstallStatus');

	Route::post('api/domains/notification/put-settings', 'Api\HotStreakController@putSettings');	

	Route::resources([
	    'admin/domains' => 'DomainsController'
	]);
});
 