<?php namespace App\Modules\Domains\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\AdminSettings\Models\AdminSettings;
use App\Modules\Mail\Controllers\tenDaysActiveController;
use App\Modules\Mail\Controllers\threeDaysLeftController;
use App\Modules\Mail\Controllers\threeDaysUnActiveController;
use App\Modules\Mail\Controllers\twelveHoursNoScriptController;
 
use App\User;
use Auth, DB;

class DomainMailEventsController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $user, $currentValue, $purchases;

    public function __construct()
    {
        //$this->middleware('auth');
        //parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function init()
    {
        echo 'init... '.PHP_EOL;

        $settings = AdminSettings::allSorted();

        if (isset($settings['tenDaysActive']) && $settings['tenDaysActive']['value'] == 1) { 
            $obj = new tenDaysActiveController();
            $obj->index();
        }
        if (isset($settings['threeDaysLeft']) && $settings['threeDaysLeft']['value'] == 1) {
            $obj = new threeDaysLeftController();
            $obj->index();
        }
        if (isset($settings['threeDaysUnActive']) && $settings['threeDaysUnActive']['value'] == 1) {
            $obj = new threeDaysUnActiveController();
            $obj->index();
        }   
 
        if (isset($settings['twelveHoursNoScript']) && $settings['twelveHoursNoScript']['value'] == 1) {
            $obj = new twelveHoursNoScriptController();
            $obj->index();
        }   
    }
 
 
}
