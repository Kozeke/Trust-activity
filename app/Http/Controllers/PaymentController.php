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
use App\ReferralHistory;
use Auth;
use DB;


class PaymentController extends Controller
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
    	switch ($request->get('payment-type')) {
    		case 'bonus-mini':
				$summary = 50;
				$bonus   = 7;
    			break;
    		case 'bonus-max':
				$summary = 100;
				$bonus   = 20;	
    			break;
    		default:
	    		$summary = (is_float(floatval($request->get('payment-amount'))) ? floatval($request->get('payment-amount')) : 9.99);
                $summary = ($summary < 9.99 ? 9.99 : $summary);
	    		$bonus   = 0;
    			break;
    	}
 
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Trustactivity.com balance top up') /** item name **/
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
            ->setDescription('Trustactivity.com balance top up');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('status')) /** Specify return URL **/
            ->setCancelUrl(URL::to('status'));
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
            $payment->bonus    = $bonus;
            $payment->type     = 'top up';
            $payment->currency = 'USD';     
            $payment->status   = 'processed';  
            $payment->save();
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/admin/top-up');
    }
    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

        	$payment_update = Payments::where(['user_id' => Auth::user()->id, 'status' => 'processed'])->orderBy('created_at', 'desc')->limit(1)->update(['status' => 'failed']);
            \Session::put('error', 'Payment failed');
            return Redirect::to('/admin/top-up');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {

        	$payments = Payments::where(['user_id' => Auth::user()->id, 'status' => 'processed'])->orderBY('created_at', 'desc')->first();

        	$user = User::find(Auth::user()->id);
        	$user->balance = $user->balance + $payments->amount + $payments->bonus;
        	$user->save();
            
            $payment_update = Payments::find($payments->id);
            $payment_update->status = 'success';
            $payment_update->save();

            /* update ref balance */
            $user = User::find(Auth::user()->id);
            if ($user->referral_id != 0) {
                $discount = DB::table('discounts')->where('user_id', $user->referral_id)->first();
                if ($discount->type == '%') {
                    $ref = User::find($user->referral_id);
                    $new_balance       = intval($ref->referral_balance) + (intval($discount->discount)* 0.2);
                    $new_balance_total = intval($ref->referral_balance_total) + (intval($discount->discount)* 0.2);                
                    User::where('id', $user->referral_id)->update(['referral_balance' => $new_balance, 'referral_balance_total' => $new_balance_total]);

                    $stats = new ReferralHistory();
                    $stats->referral_id = $user->id;               
                    $stats->user_id     = $user->referral_id;
                    $stats->total       = $payments->amount;            
                    $stats->commission  = (intval($discount->discount)* 0.2);
                    $stats->save();
                }
            }

            \Session::put('success', 'Payment success');
            return Redirect::to('/admin/top-up');
        }

        $payment_update = Payments::where(['user_id' => Auth::user()->id, 'status' => 'processed'])->orderBy('created_at', 'desc')->limit(1)->update(['status' => 'failed']);
        \Session::put('error', 'Payment failed');
        return Redirect::to('/admin/top-up');
    }
}
