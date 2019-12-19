<?php namespace App\Modules\Users\Controllers\Api;

use App\Modules\Domains\Models\Domains;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use App\Payments;

use Validator, Auth, Hash;

class UsersController extends \App\Modules\Panel\Controllers\AbstractController
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

    public $domain_ids = [];
    public $hot_streaks_ids = [];

    public function getIds($value)
    {
        return $value->id;
    }

    public function postDelete(Request $request)
    {
        if (Auth::user()->role === 1) {
            $user = User::find($request->get('user_id'));
            if ($user) {
                $domains = DB::table('domains')->where('user_id', $user->id)->get()->toArray();
                $this->domain_ids = array_map(array($this, 'getIds'), $domains);

                $hot_streaks = DB::table('hot_streaks')->whereIn('domain_id', $this->domain_ids)->get()->toArray();
                $this->hot_streaks_ids = array_map(array($this, 'getIds'), $hot_streaks);

                try {

                    DB::transaction(function () use ($user) {
                        ///////////////////////////////////////////////////////////////////////////////
                        DB::table('domain_settings')->whereIn('domain_id', $this->domain_ids)->delete();
                        DB::table('domain_statuses')->whereIn('domain_id', $this->domain_ids)->delete();
                        ///////////////////////////////////////////////////////////////////////////////
                        DB::table('hot_streak_activities')->whereIn('hot_streak_id', $this->hot_streaks_ids)->delete();
                        DB::table('hot_streak_captures')->whereIn('module_id', $this->hot_streaks_ids)->delete();
                        DB::table('hot_streak_displays')->whereIn('module_id', $this->hot_streaks_ids)->delete();
                        DB::table('hot_streak_fakes')->whereIn('hot_streak_id', $this->hot_streaks_ids)->delete();
                        DB::table('hot_streak_shows')->whereIn('module_id', $this->hot_streaks_ids)->delete();
                        DB::table('hot_streak_visitors')->whereIn('module_id', $this->hot_streaks_ids)->delete();
                        ///////////////////////////////////////////////////////////////////////////////
                        DB::table('domains')->whereIn('id', $this->domain_ids)->delete();
                        DB::table('hot_streaks')->whereIn('id', $this->hot_streaks_ids)->delete();
                        ///////////////////////////////////////////////////////////////////////////////
                        DB::table('module_purchases')->whereIn('domain_id', $this->domain_ids)->delete();
                        DB::table('partners_requests')->where('user_id', $user->id)->delete();
                        DB::table('withdraw_logs')->where('user_id', $user->id)->delete();
                        DB::table('password_resets')->where('email', $user->email)->delete();
                        DB::table('payments')->where('user_id', $user->id)->delete();
                        ///////////////////////////////////////////////////////////////////////////////
                        DB::table('users')->where('id', $user->id)->delete();
                    });

                } catch (Exception $e) {
                    echo 'false';
                }

                echo 'true';
            }

            //domain_settings
            //domain_statuses
            //domains
            //hot_hot_streak_activities
            //hot_streak_captures
            //hot_streak_displays
            //hot_streak_fakes
            //hot_streak_shows
            //hot_streak_visitors
            //hot_streak
            //module_purchases
            //partners_requests
            //users
            //withdraw_logs
            //payments
            //password_resets
        }

    }

    public function postBalance(Request $request)
    {
        if (Auth::user()->role === 1) {

            $user = User::find($request->get('user_id'));
            $old_balance = $user->balance;
            $new_balance = str_replace('$', '', $request->get('balance'));
            $summary = null;

            if ($new_balance < 0) {
                $new_balance = 0;
            }

            if ($old_balance > $new_balance) {
                $summary = $old_balance - $new_balance;
                $method = 'admin-remove';
            } else if ($new_balance > $old_balance) {
                $summary = $new_balance - $old_balance;
                $method = 'admin-add';
            }

            if ($summary) {

                $user->balance = $new_balance;
                $user->save();

                $payment = new Payments;
                $payment->user_id = $request->get('user_id');
                $payment->method = $method;
                $payment->amount = $summary;
                $payment->bonus = 0;
                $payment->type = 'top up';
                $payment->currency = 'USD';
                $payment->status = 'success';
                $payment->save();

            }

            return 'true';

        } else {
            return 'false';
        }
    }

    public function timezone(Request $request)
    {
        $inputs = $request->all();

        if (Auth::user()) {

            $selected = str_replace('UTC ', '', $inputs['selected']);
            $user = User::find(Auth::user()->id);
            $user->timezone = $selected;
            $user->save();
        }

        print_r($inputs['selected']);
    }

    public function getList(Request $request)
    {
        if (Auth::user()->role === 1) {
//            DB::enableQueryLog();
            $users = User::whereIN('role', [0, 2])
                ->orderBy('id', 'DESC')
                ->with(['domains' => function ($q) {
                    $q->withCount('hotStreaks');
                }])
                ->get();

//            $users = User::whereIN('role', [0,2])->orderBy('id', 'DESC')->get();
//
//            foreach ($users as $key => $value) {
//                $value->domains = $value->userDomains($value->id);
//            }
//            dd(DB::getQueryLog());

            return response()->json(['list' => $users]);

        } else {
            return 'false';
        }
    }

}
