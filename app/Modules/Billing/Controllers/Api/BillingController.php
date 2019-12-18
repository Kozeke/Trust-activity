<?php namespace App\Modules\Billing\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Modules\Domains\Models\Domains;
use App\Modules\Billing\Models\ModulePlan;
use App\Modules\Billing\Models\ModulePurchase;
use Illuminate\Http\Request as Request;
use App\Modules\Panel\Models\User as User;
use Auth, DB, Session;

class BillingController extends \App\Modules\Panel\Controllers\AbstractController
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

    public function getList(Request $request)
    {   
        if (Auth::user()->role === 1) {
            //return view('Panel::admin_index')->with('domains', $this->domains);
        } else {
 
            $plans = ModulePlan::where('module_id', 1)->orderBy('id', 'ASC')->get();
            //['domains' => $this->domains, 'plans' => $plans, 'up_to' => $up_to, 'user' => Auth::user()]
            foreach ($this->domains as $key => $value) {

                $purchased = DB::table('module_purchases as mp')
                ->where('mp.domain_id', $value->id)
                //->where('module_plan_id', 1)
                ->where('mp.purchases_at', '<', \Carbon\Carbon::now())
                ->where('mp.purchases_till', '>', \Carbon\Carbon::now())
                ->join('module_plans as mpl', 'mpl.id', '=', 'mp.module_plan_id')
                ->select('mp.id as purchase_id', 'mpl.name', 'mpl.price_mo', 'mpl.visitors_mo', 'mp.status', 'mp.purchases_till')
                ->first();
 
                if ($purchased) {
                    $this->date_format = 'm/d/Y';
                    $value->current_plan = [
                        'purchases_till' => $this->updateDate($purchased->purchases_till),//\Carbon\Carbon::createFromTimeStamp(strtotime($purchased->purchases_till))->format('m/d/Y'),
                        'name'     => $purchased->name,
                        'price'    => $purchased->price_mo,
                        'visitors' => $purchased->visitors_mo,      
                        'status'   => $purchased->status,  
                        'id'       => $purchased->purchase_id,                               
                    ];
                }
 
                $this->date_format = 'M d, Y g:i A';
                $value->created = $this->updateDate($value->created_at);//\Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->format('m/d/Y g:i A'); 
            }
 
            return response()->json(['domains' => $this->domains, 'plans' => $plans, 'user' => Auth::user()]);  
        }
    }

    public function postList(Request $request) 
    {
        $inputs = $request->all();
        $total_price = 0;
        $all          = $request->all();
        $bill         = json_decode($all['billing']);
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
 
        foreach ($domains as $d_key => $d_value)
        {
            if ($d_value->user_id == Auth::user()->id)
                {
                $name = $name.' '. $d_value->url. ', module: ';
                $bill_arr = (array) $bill;
                $modules = $bill_arr[$d_value->url]->modules;
                foreach ($modules as $m_key => $m_value)
                {
                    $plan        = ModulePlan::find($m_value->id);
                    if ($plan)
                    {
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
 
        if (Auth::user()->balance >= $summary && !empty($purchases))
        {
            foreach ($purchases as $key => $value)
            {
                $purchase = new ModulePurchase();
                $purchase->domain_id      = $value['domain_id'];
                $purchase->module_plan_id = $value['moduleid'];
                $purchase->purchases_at   = \Carbon\Carbon::now()->subMinutes(1);
                $purchase->purchases_till = \Carbon\Carbon::now()->addDays(30)->subMinutes(1);
                $purchase->save();

                $this->disableIfSuspendPurchaseExist($value['domain_id']);
            }

            $user = User::find(Auth::user()->id);

            $user->balance = $user->balance - $summary;
            $user->save();

            \Session::put('success', 'Payment success');

            return 'success';
        } else {

            \Session::put('error', 'Payment failed');

            return 'fail';
        }
    }

    private function disableIfSuspendPurchaseExist($domain_id)
    {
        $domain = new Domains();
        $purchase = $domain->getActivePurchase($domain_id);

        if ($purchase && $purchase->status == 2) {
            ModulePurchase::where('id', $purchase->id)->update(['status' => 0]);
        }
    }

    public function changeStatus(Request $request) 
    {
        $inputs = $request->all();
 
        $ifExist = DB::table('module_purchases as mp')
        ->where('mp.id', $inputs['plan_id'])
        ->join('domains as d', 'd.id', '=', 'mp.domain_id')
        ->where('d.user_id', Auth::user()->id)
        ->exists();

        if ($ifExist) {
            return ModulePurchase::where('id', $inputs['plan_id'])->update(['status' => $inputs['status']]);
        }
 
    }
}
