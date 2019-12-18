<?php namespace App\Modules\Billing\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Modules\Domains\Models\Domains;
use App\Modules\Billing\Models\ModulePlan;
use Auth;

class BillingController extends \App\Modules\Panel\Controllers\AbstractController
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

    public function dashboard()
    {   
        if (Auth::user()->role === 1) {
            return view('Panel::admin_index')->with('domains', $this->domains);
        } else {
            $up_to = \Carbon\Carbon::now()->addMonths(1)->format('M/d/Y'); 
            $plans = ModulePlan::where('module_id', 1)->get();
            return view('Billing::dashboard')->with(['domains' => $this->domains, 'plans' => $plans, 'up_to' => $up_to, 'user' => Auth::user()]);
        }
    }
}
