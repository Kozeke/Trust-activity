<?php namespace App\Modules\IsInstalled\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use App\Modules\Domains\Models\Domains;
use App\Modules\Domains\Models\HotStreaks;
use App\Modules\Domains\Models\hotStreakActivity;

use Validator, Auth, Hash, DB;

class IsInstalledController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $domains = DB::table('domains')->get();

        foreach ($domains as $key => $value) {
            echo IsInstalledController::isScriptInstalled($value);
            echo '('.$value->url.')';
            echo '<br>';
        }
        echo 'test';

    }
 


    static public function isScriptInstalled($domain) {
 
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 30,      // timeout on connect
            CURLOPT_TIMEOUT        => 30,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false,    // Disabled SSL Cert checks
			CURLOPT_BINARYTRANSFER => true,
        );
        $c = curl_init($domain->url);
        curl_setopt_array($c, $options);

        /*curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);*/

        $html = curl_exec($c);
        if (curl_error($c)) {
            return false;
            //die(curl_error($c));
        }

        $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c); 
        $mystring = $html;
        $findme   = $domain->hash_key;
        $pos      = strpos($mystring, $findme);

        return ($pos !== false ? true : false);
    }
}
