<?php namespace App\Modules\Discount\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use App\ReferralHistory;
use DB;
use App\Modules\AdminWithdraw\Models\WithdrawLogs;

use Validator, Auth, Hash;

class DiscountController extends \App\Modules\Panel\Controllers\AbstractController
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
        $user      = User::find(Auth::user()->id);
        $referrals = User::where('referral_id', Auth::user()->id)->get();
        $history   = WithdrawLogs::all();
        $r_history = ReferralHistory::where('user_id', Auth::user()->id)->get();

        $withdraw = 0;
        $withdraw_logs = DB::table('withdraw_logs')->where('user_id', Auth::user()->id)->where('status', 0)->get();
        foreach ($history as $key => $value) { 
           $value->created = \Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->format('F d, Y'); 
        }

        foreach ($withdraw_logs as $key => $value) {
            $withdraw = $withdraw + $value->summ;
            $value->created = \Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->format('F d, Y'); 
        }


        return view('Discount::index')->with([
            'domains'   => $this->domains ,
            'user'      => $user,
            'referrals' => $referrals,
            'withdraw'  => $withdraw,
            'history'   => $history,
            'r_history' => $r_history,
        ]);   
    }

}
