<?php namespace App\Modules\Billing\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;

use App\Modules\Billing\Controllers\ServiceProvider\CheckoutService;
use App\Modules\Billing\Controllers\ServiceProvider\PaypalService;

use Request;

class TopupController extends \App\Modules\Panel\Controllers\AbstractController
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

    public function pay(Request $request)
    {
        $inputs = Input::all();

        switch ($inputs['payment-method']) {
            case 'paypal':
                $service = new PaypalService;
                break;
            case '2checkout':
                $service = new CheckoutService;
                break;        
            default:
                $service = new PaypalService;
                break;
        }

        return $service->init();
    }



 
}
