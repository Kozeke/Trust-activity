<?php namespace App\Modules\Billing\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;

use App\Modules\Billing\Controllers\ServiceProvider\CheckoutService;
use App\Modules\Billing\Controllers\ServiceProvider\PaypalService;

use Illuminate\Http\Request;
use App\User;
use App\Payments;
use App\Modules\Domains\Models\Domains;
use App\Modules\Billing\Models\ModulePlan;
use App\Modules\Billing\Models\ModulePurchase;
use Auth;
use Session;

use App\Modules\Billing\Controllers\lib\Twocheckout;
use App\Modules\Billing\Controllers\lib\Twocheckout\Twocheckout_Charge;
use App\Modules\Billing\Controllers\lib\Twocheckout\Api\Twocheckout_Error;


class CheckOutController extends \App\Modules\Panel\Controllers\AbstractController
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

    public $payment_type   = 0;
    public $payment_amount = 0;
    public $summary = 0;
    public $bonus   = 0;
    public $title   = 'Title not set';
    public $purchases    = [];
    public $domain_names = [];
    public $inputs = null;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function test() {

        return view('Billing::index');
    }

    public function pay(Request $request) {

        require_once("lib/Twocheckout.php");

        $this->inputs = Input::all();
        $this->payment_type   = $this->inputs['payment_type'];
        $this->payment_amount = str_replace('$', '', $this->inputs['payment_amount']);
        $amount_data = $this->getPrice();

        if (isset($this->inputs['plan_detail'])) {
            $this->setTitle($this->inputs['plan_detail']);
        } else {
            $this->setTitle();
        }
        Twocheckout::privateKey('603C0D1B-8A33-4B34-B401-1890BC911606'); //Private Key
        Twocheckout::sellerId('203805143'); // 2Checkout Account Number
        //Twocheckout::sandbox(true); // Set to false for production accounts.
  
        try {
            $charge = Twocheckout_Charge::auth(array(
                "merchantOrderId" => $this->title,
                "token"      => $this->inputs['token'],
                "currency"   => 'USD',
                "total"      => $amount_data['summary'],
                "billingAddr" => array(
                    "name"        => $this->inputs['name'],
                    "addrLine1"   => $this->inputs['addrLine1'],
                    "city"        => $this->inputs['city'],
                    "state"       => $this->inputs['state'],
                    "zipCode"     => $this->inputs['zipCode'],
                    "country"     => $this->inputs['country'],
                    "phoneNumber" => $this->inputs['phoneNumber'],
                    "email" => Auth::user()->email,
                )
            ));

            if ($charge['response']['responseCode'] == 'APPROVED'||$charge['response']['responseCode'] =='PENDING') {
 				$this->successPayment();
            }
        } catch (Twocheckout_Error $e) {

            print_r(array(
                "merchantOrderId" => $this->title,
                "token"      => $this->inputs['token'],
                "currency"   => 'USD',
                "total"      => $amount_data['summary'],
                "billingAddr" => array(
                    "name"        => $this->inputs['name'],
                    "addrLine1"   => $this->inputs['addrLine1'],
                    "city"        => $this->inputs['city'],
                    "state"       => $this->inputs['state'],
                    "zipCode"     => $this->inputs['zipCode'],
                    "country"     => $this->inputs['country'],
                    "phoneNumber" => $this->inputs['phoneNumber'],
                    "email" => Auth::user()->email,
                )
            ));
            print_r($e->getMessage());
        }
    }

    private function successPayment()
    {	
        if ($this->payment_type == 'bonus-mini' || $this->payment_type == 'bonus-max' || $this->payment_type == 'custom') {
        //////
            echo 'success';

            return $this->changeBalance();
        }  else if ($this->payment_type == 'campaign') {
        //////
            if (isset($this->inputs['plan_detail'])) {
                return $this->prolong();
            } else {
                return 'failed';                        
            }
        }  else if ($this->payment_type == 'billing') {
        //////
            if (isset($this->inputs['plan_detail'])) {
                return $this->billing();
            } else {
                return 'failed';                        
            }         
        } else {
        	echo 'none';
        //////
        }
    }

    private function setTitle($plan_detail = null)
    {
        switch ($this->payment_type) {
            case 'bonus-mini':
                $this->title = "Top up balance";
                break;
            case 'bonus-max':
                $this->title = "Top up balance";
                break;
            case 'custom': 
                $this->title = "Top up balance";
                break;
            case 'campaign':

                $domains = Domains::where('url', $plan_detail[0]['name'])->first();
                $plan    = ModulePlan::find($plan_detail[0]['modules'][0]['id']);

                if ($domains && $plan) {
                    $this->title = 'Trustactivity.com purchasing module on '.$domains->url.', module: '.$plan->name.' for $'.$plan->price_mo. '. ';
                } else {
                    return 'false';
                }

                break;
            case 'billing' : 
 
                $bill         = $plan_detail;
                $summary      = 0;
                $this->title         = 'Trustactivity.com purchasing modules on domains: ';
 
                foreach ($bill as $b_key => $b_value) {
                    array_push($this->domain_names, $b_value['name']);
                    $bill[$b_value['name']] = $b_value;
                }

                $verified_domains = [];

                $domains = Domains::whereIn('url', $this->domain_names)->get();

                foreach ($domains as $d_key => $d_value) {
                    if ($d_value->user_id == Auth::user()->id) {
                        $this->title = $this->title.' '. $d_value->url. ', module: ';
                        $bill_arr = (array) $bill;
                        $modules = $bill_arr[$d_value->url]['modules'];
                        foreach ($modules as $m_key => $m_value) {
                            $plan        = ModulePlan::find($m_value['id']);
                            if ($plan) {
                                if($plan->module_id == 1) { $this->title = $this->title. 'Notification '; }
                                $this->title = $this->title.' '.$plan->name.' for $'.$plan->price_mo. '. ';
                                $summary     = $summary + $plan->price_mo;

                                $purchase = [];
                                $purchase['domain_id'] = $d_value['id'];
                                $purchase['moduleid'] = $plan->id;
                                array_push($this->purchases, $purchase);
                            }
                        }

                        array_push($verified_domains, $d_value);
                    }
                }
                break; 
            default:
                break;
        }    
    }

    private function getPrice() 
    {
        switch ($this->payment_type) {
            case 'bonus-mini':
                $summary = 50;
                $bonus   = 7;
                break;
            case 'bonus-max':
                $summary = 100;
                $bonus   = 20;  
                break;
            default:
                $summary = (is_float(floatval($this->payment_amount)) ? floatval($this->payment_amount) : 9.99);
                $summary = ($summary < 1 ? 1 : $summary);
                $bonus   = 0;
                break;
        }

        return ['summary' => $summary, 'bonus' => $bonus];   
    }

    private function prolong()
    {
        $domains     = Domains::where('url', $this->inputs['plan_detail'][0]['name'])->first();
        $plan        = ModulePlan::find($this->inputs['plan_detail'][0]['modules'][0]['id']);
        $amount_data = $this->getPrice();

        $purchase = new ModulePurchase();
        $purchase->domain_id      = $domains->id;
        $purchase->module_plan_id = $plan->id;
        $purchase->purchases_at   = \Carbon\Carbon::now()->subMinutes(1);
        $purchase->purchases_till = \Carbon\Carbon::now()->addMonths(1)->subMinutes(1);
        $purchase->save();

        $payment = new Payments();
        $payment->user_id  = Auth::user()->id;
        $payment->method   = '2checkout'; 
        $payment->amount   = $amount_data['summary'];
        $payment->bonus    = $amount_data['bonus'];
        $payment->type     = 'top up';
        $payment->currency = 'USD';     
        $payment->status   = 'success';  
        $payment->save(); 

        \Session::put('success', 'Payment success');
        echo 'success'; 
    }

    private function billing()
    {
        $amount_data = $this->getPrice();

        $payment = new Payments();
        $payment->user_id  = Auth::user()->id;
        $payment->method   = '2checkout'; 
        $payment->amount   = $amount_data['summary'];
        $payment->bonus    = $amount_data['bonus'];
        $payment->type     = 'top up';
        $payment->currency = 'USD';     
        $payment->status   = 'success';  
        $payment->save();  

        foreach ($this->purchases as $key => $value)
        {
            $purchase = new ModulePurchase();
            $purchase->domain_id      = $value['domain_id'];
            $purchase->module_plan_id = $value['moduleid'];
            $purchase->purchases_at   = \Carbon\Carbon::now()->subMinutes(1);
            $purchase->purchases_till = \Carbon\Carbon::now()->addMonths(1)->subMinutes(1);
            $purchase->save();
        }

        \Session::put('success', 'Payment success');
        echo 'success'; 
        
    }

    private function changeBalance()
    {
        $amount_data = $this->getPrice();
 
        $payment = new Payments();
        $payment->user_id  = Auth::user()->id;
        $payment->method   = '2checkout'; 
        $payment->amount   = $amount_data['summary'];
        $payment->bonus    = $amount_data['bonus'];
        $payment->type     = 'top up';
        $payment->currency = 'USD';     
        $payment->status   = 'success';  
        $payment->save();
 
        $user          = User::find(Auth::user()->id);
        $user->balance = $user->balance + $payment->amount + $payment->bonus;
        $user->save();

        \Session::put('success', 'Payment success');
        return 'testsuccess';
    }
 
}
