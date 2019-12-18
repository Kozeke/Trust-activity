<?php namespace App\Modules\Discount\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use App\Modules\AdminWithdraw\Models\WithdrawLogs;
use DB;
use Validator, Auth, Hash;
use Illuminate\Support\Facades\Mail;

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

    public function emails(Request $request)
    {
        $emails = $request->get('emails');
        if (strlen($emails) < 1) { return 'false'; } 
        $pieces = explode(',', $emails);
        if (count($pieces) > 10 || count($pieces) < 1) { return 'false'; } 

        $fails = 0;
    
        foreach ($pieces as $key => $value) {

            $user     = User::find(Auth::user()->id);
            $promo    = DB::table('discounts')->where('user_id', $user->id)->first();
            $email_to = trim($value);

            $result = filter_var( $email_to, FILTER_VALIDATE_EMAIL );

            if ($result) {
                Mail::send('mails.invite', ['email' => $user->email, 'promo' => $promo->bonus_code, 'email_to' => $email_to], function ($m) use ($user, $email_to) {
                    $m->from('noreply@trustactivity.com', 'Trustactivity');
                    $m->to($email_to, $email_to)->subject('You has been intived to Trustactivity.com!');
                });                
            } else {
                $fails++;
            }
        }
 
        return ($fails < count($pieces) ? 'true' : 'false');
    }

    public function transfer(Request $request)
    {
        $withdraw = 0;
        $withdraw_logs = DB::table('withdraw_logs')->where('user_id', Auth::user()->id)->where('status', 0)->get();

        foreach ($withdraw_logs as $key => $value) {
            $withdraw = $withdraw + $value->summ;
        }

        $summ    = $request->get('summ');
        $isNumber = (intval($summ) ? true : false);

        if ($isNumber != 1) { return 'false'; }
        if ($summ > (Auth::user()->referral_balance - $withdraw)) { return 'false'; }

        $withdraw          = new WithdrawLogs();
        $withdraw->summ    = $summ;
        $withdraw->user_id = Auth::user()->id;
        $withdraw->status  = 1;      
        $withdraw->type    = 1;
        $withdraw->save();     

        $update_user = User::find(Auth::user()->id);
        $update_user->balance = $update_user->balance + $summ;
        $update_user->referral_balance = $update_user->referral_balance - $summ;
        $update_user->save();            

        return 'true';      
    }  

    public function withdraw(Request $request)
    {  
        //$ifExist = WithdrawLogs::where('user_id', Auth::user()->id)->where('status', 0)->first();

        //if (!$ifExist) {
            $withdraw = 0;
            $withdraw_logs = DB::table('withdraw_logs')->where('user_id', Auth::user()->id)->where('status', 0)->get();

            foreach ($withdraw_logs as $key => $value) {
                $withdraw = $withdraw + $value->summ;
            }

            $summ    = $request->get('summ');
            $isNumber = (intval($summ) ? true : false);

            if ($isNumber != 1) { return 'false'; }
            if ($summ > (Auth::user()->referral_balance - $withdraw)) { return 'false'; }

            $withdraw          = new WithdrawLogs();
            $withdraw->summ    = $summ;
            $withdraw->user_id = Auth::user()->id;
            $withdraw->status  = 0;      
            $withdraw->type    = 0;
            $withdraw->save();     

            return 'true'; 
        //} else {
        //    return 'false';   
        //}
    }

}
