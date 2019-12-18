<?php

namespace App\Http\Controllers;

use App\Modules\AdminSettings\Models\AdminSettings;
use Location;
use DB;
use App\CityImage;

class MainController extends Controller
{
	public function detectDomain() 
	{
		$domain = $_SERVER['SERVER_NAME'];
		$pieces = explode('.', $domain);
		//$last_e = $pieces[count($pieces) - 1];
		$last_e = $pieces[0];
		return $last_e;
	}

	public function index()
	{
		$settings = AdminSettings::where('name', 'underConstruction')->first();
		if ($settings->value == 1) {
    		return view('errors.500');	
		} else {
			return view('index');	
			/*if ($this->detectDomain() == 'dev') {
    			return view('index');	
			} else if($this->detectDomain() == 'dev1') {
    			return view('index_ru');	
			}	*/	
		}
	}

	public function indexAmp()
	{
		$settings = AdminSettings::where('name', 'underConstruction')->first();
		if ($settings->value == 1) {
    		return view('errors.500');	
		} else {
    		return view('index_amp');			
		}
	}	
}
