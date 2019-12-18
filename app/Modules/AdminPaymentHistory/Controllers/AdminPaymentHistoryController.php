<?php namespace App\Modules\AdminPaymentHistory\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\Billing\Models\ModulePurchase;
use App\User;
use App\Payments;
use Auth;
 
class AdminPaymentHistoryController extends \App\Modules\Panel\Controllers\AbstractController
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

    public $invoices, $purchases;
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    private static function sortFunction( $a, $b ) {
        return strtotime($b["created_at"]) - strtotime($a["created_at"]);
    }

    public function index()
    {
        if (Auth::user()->role === 1) {

            //$this->invoices  =  Payments::whereIn('status', ['success', 'failed'])->get();
            //$this->purchases =  ModulePurchase::byUserId(Auth::user()->id);
            $data = [];

            $search = (isset($_GET['search']) ? $_GET['search'] : '');
            $status = (isset($_GET['status']) ? $_GET['status'] : ''); 
            $start  = (isset($_GET['start']) ? $_GET['start'] : ''); 
            $end    = (isset($_GET['end']) ? $_GET['end'] : ''); 

            $page_per  = 10;
            $page_curr = (isset($_GET['page']) ? $_GET['page'] : 1); 


            if ($search != '') {
                $users = User::where('email', 'LIKE', '%'.$search.'%')->whereIN('role', [0,2])->orderBy('id', 'DESC')->get();
            } else {
                $users = User::whereIN('role', [0,2])->orderBy('id', 'DESC')->get();;
            }

            foreach ($users as $key => $value) {
                $history = $value->getPaymentHistory($value->id);
                foreach ($history as $key2 => $value2) {

                    $isStatus = false;
                    $inDate   = false;
 
                    // если пустота то проходит
                    // если не пустота и ровняется статусу то проходит
                    if ($status == '') {
                        $isStatus = true;
                    } else if ($status == $value2->status) {
                        $isStatus = true;      
                    }

                    if ($start == '' && $end == '') {
                        $inDate = true;
                    } else if ($start != '' && $end == '') {
                        $start_c  = \Carbon\Carbon::createFromFormat('Y.m.d', $start);
                        if ($value2->created_at->gt($start_c)) {
                            $inDate = true;
                        }
                        //$end_c    = Carbon::createFromFormat('Y.m-d', $end);
                    } else if ($start == '' && $end != '') {
                        $end_c  = \Carbon\Carbon::createFromFormat('Y.m.d', $end);
                        if ($value2->created_at->lt($end_c)) {
                            $inDate = true;
                        }
                    } else if ($start != '' && $end != '') {
                        $start_c  = \Carbon\Carbon::createFromFormat('Y.m.d', $start);
                        $end_c    = \Carbon\Carbon::createFromFormat('Y.m.d', $end);

                        if ($value2->created_at->gt($start_c) && $value2->created_at->lt($end_c)) {
                            $inDate = true;
                        }
                    }
 
                    if ($isStatus && $inDate) {

                        $item = [
                            'method'      => $value2->method,
                            'domain_id'   => $value2->domain_id,
                            'email'       => $value->email,
                            'type'        => $value2->type,
                            'status'      => $value2->status,
                            'domain_name' => $value2->domain_name,
                            'module_name' => $value2->module_name,
                            'module_plan_name'  => $value2->module_plan_name,
                            'date'              => $value2->date,
                            'amount'            => $value2->amount,
                            'bonus'             => $value2->bonus,
                            'module_plan_price' => $value2->module_plan_price,
                            'created_at'        => $value2->created_at
                        ];

                        array_push($data, $item);
                    }
                }   
            }
 
            usort($data, array('App\Modules\AdminPaymentHistory\Controllers\AdminPaymentHistoryController','sortFunction'));
 
            return view('AdminPaymentHistory::index')->with([
                'list' => $data
            ]);   

        } else {
            return redirect('/admin');
        }

 
    }
 
}
