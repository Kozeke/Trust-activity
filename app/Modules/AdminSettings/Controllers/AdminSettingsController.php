<?php namespace App\Modules\AdminSettings\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\AdminSettings\Models\AdminSettings;
use App\EmailsLogs;
use Validator, Auth, Hash, Session;

class AdminSettingsController extends \App\Modules\Panel\Controllers\AbstractController
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
        if (Auth::user()->role === 1) {

            $settings = AdminSettings::allSorted();

            return view('AdminSettings::index')->with(['domains' => $this->domains, 'settings' => $settings]);

        } else {
            return redirect('/admin');
        }
    }
 
}
