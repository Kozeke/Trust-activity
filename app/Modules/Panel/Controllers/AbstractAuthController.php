<?php namespace App\Modules\Panel\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\Domains\Models\Domains;
use App\Modules\AdminSettings\Models\AdminSettings;
use Auth, DB, Session, Location;
use App\DomainStatus;
use App\DomainStatusUpdate;
 
class AbstractAuthController extends Controller
{
        public $translate, $language;        

	public function __construct() {
        
        //$this->setLanguage();
        //$this->translate = self::getTranslations($this->language);
        $this->translate = self::getTranslations();
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

    static public function getTranslations($lang = null) {

        if (Session::has('translate') && $lang == null) {
            $session = Session::get('translate');
            if (isset($session['lang'])) {
                return Session::get('translate');               
            }
        }

        if ($lang != null) { 
            $position = new \stdClass;
            $position->countryCode = strtoupper($lang);
        } else {
            $ip       = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR'));
            $position = Location::get($ip);
        }
 
        if ($position !== false && ($position->countryCode == 'RU')) {
            
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

        return $sorted_list;
    }

 
}