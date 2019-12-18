<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| hey
*/
// seo redirect
//Route::get('test', 'testController@test');

Route::get('applying-social-proof-to-your-business', function(){
	return redirect('/blog/conversion/applying-social-proof-to-your-business');
});
// seo redirect
Route::get('4-website-markers-that-screams-trust-to-users', function(){
	return redirect('/blog/conversion/4-website-markers-that-screams-trust-to-users');
});

 
/*Route::get('test', function(){
	$users  = DB::table('users')->get();
	$file   = '/var/www/html/public/email.txt';
	$person = '';
	// Новый человек, которого нужно добавить в файл
	foreach ($users as $key => $value) {
		$person .= $value->email."\n";
	}
	// Пишем содержимое в файл,
	// используя флаг FILE_APPEND для дописывания содержимого в конец файла
	// и флаг LOCK_EX для предотвращения записи данного файла кем-нибудь другим в данное время
	file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
	print_r(count($users));
});*/

/*Route::get('generate', function(){

	$item = new \App\Modules\Services\Controllers\FakeServiceController();
	$item->ParseNameFromApi();
 
}); */
 

Route::get('api/get-script', function(){
	if (isset($_GET['acc']) && strlen($_GET['acc']) > 0) {
		//echo '<script type="text/javascript" src="https://www.trustactivity.com/cdn/truster.js?acc='.$_GET['acc'].'"></script>';
 		return response()->json(['html' => '<script type="text/javascript" src="https://www.trustactivity.com/cdn/truster.js?acc='.$_GET['acc'].'"></script>']);
	} else {
 		return response()->json(['error' => 'wrong GET data']);
	}
});

//Route::get('/check-domains', '\App\Modules\IsInstalled\Controllers\IsInstalledController@index');

Route::get('/', 'MainController@index');
Route::get('/amp', 'MainController@indexAmp');

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/affiliate', function () {
    return view('affiliate');
});

Route::get('/faq', 'FaqController@index');
Route::get('/faq/{category}', 'FaqController@category');
Route::get('/faq/{category}/{article}', 'FaqController@showArticle');

Route::get('/blog', 'BlogController@index');
Route::get('/blog/amp', 'BlogAmpController@index');
Route::get('/blog/{category}', 'BlogController@category');
Route::get('/blog/{category}/amp', 'BlogAmpController@category');
Route::get('/blog/{category}/{url}', 'BlogController@show');
Route::get('/blog/{category}/{url}/amp', 'BlogAmpController@show');
// route for processing payment
//Route::post('paypal', 'PaymentController@payWithpaypal');
Route::post('/bill/paypal', 'BillPaymentController@payWithpaypal');

Route::post('/topup/pay', 'PaymentController@payWithpaypal');

// route for check status of the payment
Route::get('status', 'PaymentController@getPaymentStatus');
Route::get('/bill/status', 'BillPaymentController@getPaymentStatus');

//Route::get('/test', '\App\Modules\Services\Controllers\SubscriptionController@checkSubscriptions');
//Route::get('/mail', '\App\Console\Commands\UpdatePurchases@handle');
 




