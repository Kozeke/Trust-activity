<?php namespace App\Modules\Panel\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\Domains\Models\Domains;
use App\Modules\AdminSettings\Models\AdminSettings;
use Auth, DB, Session, Location;
use App\DomainStatus;
use App\DomainStatusUpdate;
use App\User;
 
class AbstractController extends Controller
{
    public $domains, $translate, $language;  

    public $timezone_offset = 0;
    public $timezone_offset_type = 'plus';
    public $date_format = 'M d, Y g:i A';

	public function __construct() {

	    $this->middleware(function ($request, $next) {

	    	//$this->setLanguage();
	    	//$this->translate = self::getTranslations($this->language);
	    	$this->translate = self::getTranslations();
        	$this->setTimezoneOffset();
	    	if (Auth::check()) {
				$this->updateDomains();
		        $this->domains = Domains::where('user_id', Auth::user()->id)->orderBy('id', 'ASC')->get();
	        	foreach ($this->domains as $key => $value) { 
	            	$value->isActive = $value->acitivityFor24h($value->id);
	        	}
				$settings      = AdminSettings::where('name', 'underConstruction')->first();
				if ($settings->value == 1 && Auth::user()->role !== 1) {
					return redirect('/');
				}	    		
	    	}

	        return $next($request);
	    });
	}

	private function setLanguage() 
	{
		$domain = $_SERVER['SERVER_NAME'];
		$pieces = explode('.', $domain);
		//$last_e = $pieces[count($pieces) - 1];
		$last_e = $pieces[0];
		if ($last_e == 'dev1') {
			$this->language = 'RU';
		} else {
			$this->language = 'EN';
		}
		//return $last_e;
	}

	private function updateDomains() {

		$list = DomainStatus::where('user_id', Auth::user()->id)->get();
		if (count($list) > 0) {
			foreach ($list as $key => $value) {
				if ($value->updated_at < \Carbon\Carbon::now()->subMinutes(10)->toDateTimeString()) {
					$item = DomainStatusUpdate::where('domain_id', $value->domain_id)->first();
					if (!$item) {
						$add            = new DomainStatusUpdate();
						$add->domain_id = $value->domain_id;
						$add->save();	
					}			
				}
			}
		} else {
			$this->addDomains();
		}	
	}
 
	private function addDomains() {

		$list = DB::table('domains')->where('user_id', Auth::user()->id)->select('id')->get();
		foreach ($list as $key => $value) {
			$add            = new DomainStatus();
			$add->user_id   = Auth::user()->id;
			$add->domain_id = $value->id;
			$add->save();
		}
	}

	public static function getTranslations($lang = null) {

		//$mutable = \Carbon\Carbon::now();
		//print_r($mutable);
		//die;
 		if (Auth::user() && Auth::user()->force_update == 0) {

 		} else {
			if (Session::has('translate') && $lang == null) {
				$session = Session::get('translate');
				if (isset($session['lang'])) {
					return Session::get('translate');				
				}
			}
 		}
 
        if ($lang != null) { 
        	$position = new \stdClass;
        	$position->countryCode = strtoupper($lang);
        } else {
	        $ip       = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR'));
	        $position = Location::get($ip);
        }
 
		if ($position !== false && ($position->countryCode == 'RU')) {// || $position->countryCode == 'KZ')) {
			
			$lang = strtolower($position->countryCode);
        	$list = DB::table('languages as l')->where('l.name', strtolower($position->countryCode))
        	->join('language_values as lv', 'lv.language_id', '=', 'l.id')
        	->select('lv.slug', 'lv.value')
        	->get();

        } else {

			$lang = 'en';
        	$list = DB::table('languages as l')->where('l.name', 'en')
        	->join('language_values as lv', 'lv.language_id', '=', 'l.id')
        	->select('lv.slug', 'lv.value')
        	->get();
        }

        $sorted_list         = [];
        $sorted_list['lang'] = $lang;

        foreach ($list as $key => $value) {
        	$sorted_list[$value->slug] = $value->value; 
        }
 
        Session::put('translate', $sorted_list);
 
        if (Auth::user()->force_update == 0) {
	        $user = User::find(Auth::user()->id);
	        $user->force_update = 1;
	        $user->save();
	    }

        return $sorted_list;
	}

    public function updateDate($date)
    {
        if ($this->timezone_offset_type == 'plus') {
            return \Carbon\Carbon::createFromTimeStamp(strtotime($date))->addMinutes($this->timezone_offset)->format($this->date_format); 
        } else if ($this->timezone_offset_type == 'minus') {
            return \Carbon\Carbon::createFromTimeStamp(strtotime($date))->subMinutes($this->timezone_offset)->format($this->date_format); 
        } else {
            return \Carbon\Carbon::createFromTimeStamp(strtotime($date))->format($this->date_format); 
        }
    }

    public function setTimezoneOffset()
    {
        $zone     = Auth::user()->timezone;
        $findme    = '-';

        $pos = strpos($zone, $findme);
        if ($pos === false) {
            $this->timezone_offset_type = 'plus';
            $clear_zone = $zone;
        } else {
            $this->timezone_offset_type = 'minus';
            $clear_zone = str_replace('-', '', $zone);

        }
        $minutes = intval($clear_zone) * 60;
        $this->timezone_offset = $minutes;
    }

}