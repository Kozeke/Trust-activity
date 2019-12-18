<?php namespace App\Modules\Mail\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\Domains\Models\Domains;
use App\Modules\Billing\Models\ModulePurchase;
use App\Modules\Mail\Handlers\HandlerController;

use App\User;
use Auth, DB;

class tenDaysActiveController extends \App\Modules\Panel\Controllers\AbstractController
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
        foreach ($this->purchases as $key => $value)
        {
            if (Domains::find($value->domain_id))
            {
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
            
            if ($this->user->created_at < \Carbon\Carbon::now())
            {
                $diff = \Carbon\Carbon::now()->diffInDays($this->user->created_at);  
                if ($diff > 10)
                {
                    $this->currentValue    = $this->user;
                    $handler               = new HandlerController();
                    $handler->user         = $this->user;
                    $handler->currentValue = $this->currentValue;
                    $handler->sendMessage('10_days_active');
                }
            }
        }
    }


 
}
