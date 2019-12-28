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
            return view('AdminPaymentHistory::index');
        } else {
            return redirect('/admin');
        }
    }
        protected function getHistory(Request $request)
    {
        if (Auth::user()->role === 1) {
            //$this->invoices  =  Payments::whereIn('status', ['success', 'failed'])->get();
            //$this->purchases =  ModulePurchase::byUserId(Auth::user()->id);
            $data = [];

            $search = $request['search'];
            $start = $request['start'];
            $end = $request['end'];
            $method = $request['method'];
            $status = $request['status'];


            $users = User::whereIN('role', [0, 2])->with(['payments', 'domains.module_purchases.module_plan.module'])->whereHas('payments', function ($query) {
                $query->whereIn('status', ['success', 'failed']);
            })->filter(Input::all())->orderBy('id', 'DESC')->paginate(15);

            $current_page=$users->currentPage();
            $last_page=$users->lastPage();
            $previous_page_url=$users->previousPageUrl();
            $next_page_url=$users->nextPageUrl();


            foreach ($users as $key => $value) {
                $history = $value->SortingUsers($value);
                foreach ($history as $key2 => $value2) {

                    $isStatus = false;
                    $inDate   = false;
                    $isMethod = false;
                    // если пустота то проходит
                    // если не пустота и ровняется статусу то проходит
                    if ($status == '') {
                        $isStatus = true;
                    } else if ($status == $value2->status) {
                        $isStatus = true;      
                    }
                    if ($method == '') {
                        $isMethod  = true;
                    } else if ($method == $value2->method) {
                        $isMethod  = true;
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
 
                    if ($isStatus && $inDate &&$isMethod) {

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

            return ['data'=>$data,'current_page'=>$current_page,'last_page'=>$last_page,'next_page_url'=>$next_page_url,'previous_page_url'=>$previous_page_url];


        } else {
            return redirect('/admin');
        }

 
    }
 
}
