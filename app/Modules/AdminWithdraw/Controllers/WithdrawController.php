<?php namespace App\Modules\AdminWithdraw\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\AdminWithdraw\Models\WithdrawLogs;
use App\EmailsLogs;
use Validator, Auth, Hash, Session;
use App\User;

class WithdrawController extends \App\Modules\Panel\Controllers\AbstractController
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

    public function index()
    {
        if (Auth::user()->role === 1) {
 
            $logs     = WithdrawLogs::where('type', 0)->get();

            return view('AdminWithdraw::index')->with(['domains' => $this->domains, 'logs' => $logs]);

        } else {
            return redirect('/admin');
        }
    }

    public function accept(Request $request)
    {
        if (Auth::user()->role === 1) {

            $id    = $request->get('id');
            $claim = WithdrawLogs::find($id);

            if ($claim->status == 0) {
                $user  = User::find($claim->user_id);
                $user->referral_balance = $user->referral_balance - $claim->summ;
                $user->save();
                $claim->status = 1;   
                $claim->save();                
            }
        }  

        return redirect('/admin/withdraw');
    }

    public function decline(Request $request)
    {
        if (Auth::user()->role === 1) {
            $id    = $request->get('id');
            $claim = WithdrawLogs::find($id);
            
            if ($claim->status == 0) {
                $claim->status = 2;   
                $claim->save();
            }
        }  

        return redirect('/admin/withdraw');
    }
 
}
