<?php namespace App\Modules\Mail\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\Domains\Models\Domains;
use App\Modules\Billing\Models\ModulePurchase;
use App\Modules\Mail\Handlers\HandlerController;

use App\User;
use Auth, DB;

class threeDaysLeftController extends \App\Modules\Panel\Controllers\AbstractController
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
 
    public function index() 
    { 
        $this->purchases = DB::table('module_purchases')
        ->where('status', 1)
        ->select('*')
        ->get();
        
        foreach ($this->purchases as $key => $value) {

            $this->currentValue = $value;

            if (Domains::find($value->domain_id)) {
                $this->user      = User::find(Domains::find($value->domain_id)->user_id);

                if ($this->user) {
                    $this->user->setAttribute('url', Domains::find($value->domain_id)->url);                    
                } else {
                    continue;
                }

            } else {
                // domain not found
                $update = ModulePurchase::where('id', $value->id)->update(['status' => 3]);
                continue;
            }

            if (\Carbon\Carbon::now() < $value->purchases_till) {

                $purchases_till = \Carbon\Carbon::createFromTimeString($value->purchases_till);
                $diff           = $purchases_till->diffInDays(\Carbon\Carbon::now());   

                if ($diff <= 3) {

                    $handler               = new HandlerController();
                    $handler->user         = $this->user;
                    $handler->currentValue = $this->currentValue;
                    $handler->sendMessage('3_days_left');
                } 
            }
        }
    }


 
}
