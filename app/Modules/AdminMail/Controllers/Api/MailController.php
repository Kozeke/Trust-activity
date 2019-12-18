<?php namespace App\Modules\AdminMail\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\AdminSettings\Models\AdminSettings;

use Validator, Auth, Hash, Session;

class MailController extends \App\Modules\Panel\Controllers\AbstractController
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

    public function changeStatus(Request $request)
    {
        if (Auth::user()->role === 1) {
            $name = $request->get('name');
            $value = ($request->get('value') == 'yes') ? 1 : 0;
            
            AdminSettings::where('name', $name)->update(['value' => $value]);

            return 'true';
        }

        return 'false';
    }
 
}
