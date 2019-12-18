<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use App\User;
use App\Payments;
use Auth;
use App\Modules\Domains\Models\Domains;
use App\Modules\Billing\Models\ModulePlan;
use App\Modules\Billing\Models\ModulePurchase;

class BillPaymentController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
  
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function index()
    {
        return view('paywithpaypal');
    }
    public function payWithpaypal(Request $request)
    {
    	$all          = $request->all();
        $bill         = json_decode($all['payment-bill']);
        $domain_names = [];
        $summary      = 0;
        $name         = 'Trustactivity.com purchasing modules on domains: ';
        $purchases    = [];

        foreach ($bill as $b_key => $b_value) {
            array_push($domain_names, $b_value->name);
            $bill[$b_value->name] = $b_value;
        }

        $verified_domains = [];

        $domains = Domains::whereIn('url', $domain_names)->get();
        foreach ($domains as $d_key => $d_value) {
            if ($d_value->user_id == Auth::user()->id) {
                $name = $name.' '. $d_value->url. ', module: ';
                $bill_arr = (array) $bill;
                $modules = $bill_arr[$d_value->url]->modules;
                foreach ($modules as $m_key => $m_value) {
                    $plan        = ModulePlan::find($m_value->id);
                    if ($plan) {
                        if($plan->module_id == 1) { $name = $name. 'Notification '; }
                        $name    = $name.' '.$plan->name.' for $'.$plan->price_mo. '. ';
                        $summary = $summary + $plan->price_mo;

                        $purchase = [];
                        $purchase['domain_id'] = $d_value->id;
                        $purchase['moduleid'] = $plan->id;
                        array_push($purchases, $purchase);
                    }
                }
                array_push($verified_domains, $d_value);
            }
        }

        \Session::put('bill_purchases', $purchases);


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($name) /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($summary); /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($summary);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($name);
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('bill/status')) /** Specify return URL **/
            ->setCancelUrl(URL::to('bill/status'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::to('/');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {

            $payment = new Payments;
            $payment->user_id  = Auth::user()->id;
            $payment->method   = 'paypal'; 
            $payment->amount   = $summary;
            $payment->bonus    = 0;
            $payment->type     = 'purchasing';
            $payment->currency = 'USD';     
            $payment->status   = 'processed';  
            $payment->save();
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/admin/dashboard');
    }
    public function getPaymentStatus(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

        	$payment_update = Payments::where(['user_id' => Auth::user()->id, 'status' => 'processed'])->update(['status' => 'failed']);
            \Session::put('error', 'Payment failed');
            return Redirect::to('/admin/domains');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {

        	$current_payment = Payments::where(['user_id' => Auth::user()->id, 'status' => 'processed'])->orderBY('id', 'ASC')->first();

            $payment_update = Payments::find($current_payment->id);
            $payment_update->status = 'success';
            $payment_update->save();

            $purchases = \Session::get('bill_purchases', null);

            foreach ($purchases as $key => $value)
            {
                $purchase = new ModulePurchase();
                $purchase->domain_id      = $value['domain_id'];
                $purchase->module_plan_id = $value['moduleid'];
                $purchase->purchases_at   = \Carbon\Carbon::now()->subMinutes(1);
                $purchase->purchases_till = \Carbon\Carbon::now()->addMonths(1)->subMinutes(1);
                $purchase->save();
            }

            \Session::put('success', 'Payment success');
            return Redirect::to('/admin/domains');
        }

        $payment_update = Payments::where(['user_id' => Auth::user()->id, 'status' => 'processed'])->update(['status' => 'failed']);
        \Session::put('error', 'Payment failed');
        return Redirect::to('/admin/domains');
    }
}
