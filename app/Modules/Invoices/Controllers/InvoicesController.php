<?php namespace App\Modules\Invoices\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\Billing\Models\ModulePurchase;
use App\Modules\Billing\Models\ModulePlan;
use App\Payments;
use Auth;

class InvoicesController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $invoices, $purchases;

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
 
        $this->invoices  =  Payments::where('user_id', Auth::user()->id)->whereIn('status', ['success', 'failed'])->get();
        $this->purchases =  ModulePurchase::byUserId(Auth::user()->id);

        $list = $this->MergePaymentPurchase();


        $shows        = [];
        $current_page = (isset($_GET['page']) ? $_GET['page'] : 1);
        $end          = $current_page * 10;
        $start        = $end - 10;
        $i            = 0;
        $data         = [];

        foreach ($list as $key => $value) {
            if ($i >= $start && $i < $end) {
                array_push($data, $list[$key]);                 
            } else if($i >= $end) {
                break;
            }
            $i++;
        }

        return view('Invoices::index')->with(['domains' => $this->domains, 'list' => $data, 'total' => count($list)]);  
    }

    protected function MergePaymentPurchase() 
    {
        foreach($this->purchases as $purchase) {

            $from  = \Carbon\Carbon::createFromTimeStamp(strtotime($purchase->purchases_at));
            $to    = \Carbon\Carbon::createFromTimeStamp(strtotime($purchase->purchases_till));
            $diff  = $from->diffInSeconds($to);
            $days  = (($diff / 60) / 60) / 24;
            if ($days < 30) {
                continue;
            }

            $this->invoices->add($purchase);
        }

        $this->invoices = $this->invoices->sortByDesc('created_at');

        foreach($this->invoices as $invoice) {

            $invoice->date = $this->updateDate($invoice->created_at);//\Carbon\Carbon::createFromTimeStamp(strtotime($invoice->created_at))->format('M d, Y');
        }

        return $this->invoices;
    }
}

 