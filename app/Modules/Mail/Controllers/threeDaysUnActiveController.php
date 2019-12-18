<?php namespace App\Modules\Mail\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\Domains\Models\Domains;
use App\Modules\Billing\Models\ModulePurchase;
use App\Modules\Mail\Handlers\HandlerController;

use App\User;
use Auth, DB;

class threeDaysUnActiveController extends \App\Modules\Panel\Controllers\AbstractController
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
        $users = User::where('role', 0)->get();

        foreach ($users as $key => $value) {

            $this->user     = $value;
            $ifHasDomains   = Domains::where('user_id', $value->id)->count();
            $purchases_till = \Carbon\Carbon::createFromTimeString($value->created_at);
            $diff           = $purchases_till->diffInDays(\Carbon\Carbon::now());   

            if ($ifHasDomains == 0 && $diff >= 1) {
                $this->currentValue    = $value;
                $handler               = new HandlerController();
                $handler->user         = $this->user;
                $handler->currentValue = $this->currentValue;
                $handler->sendMessage('3_days_unactive');
            } else {
                $this->currentValue = $value;
            }
        }

        $this->user = null;
    }

 
}
