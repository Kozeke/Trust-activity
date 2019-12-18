<?php

namespace App\Http\Controllers;

 use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Modules\Domains\Models\Domains;
use App\Modules\Billing\Models\ModulePlan;
use App\Modules\Billing\Models\ModulePurchase;
use App\Modules\Panel\Controllers\MailController;
use App\Events;
use App\User;
use Auth, DB;

class testController extends Controller
{
    protected $user, $currentValue;
    protected $updated_ids = [];
    protected $purchases;

	public function test() 
	{
        $this->purchases = DB::table('module_purchases')
        ->whereIN('status', [1,2])
        ->where('domain_id', 261)
        ->select('*')
        ->orderBy('created_at', 'DESC')
        ->get();

       foreach ($this->purchases as $key => $value) {
 			// работаем только с последней активной записью (остальные деактивируеме - защита от дублей и багов)
			if(!$this->uniqueUpdate($value->domain_id)) {
				//$update = ModulePurchase::where('id', $value->id)->update(['status' => 0]);
            }

            if (Domains::find($value->domain_id)) {
                $this->user = User::find(Domains::find($value->domain_id)->user_id);

                if ($this->user) {
                    $this->user->setAttribute('url', Domains::find($value->domain_id)->url);                    
                } else {
                	// пользователя нет
                	$update = ModulePurchase::where('id', $value->id)->update(['status' => 4]);
                    continue;
                }

            } else {
                // домена нет
                $update = ModulePurchase::where('id', $value->id)->update(['status' => 3]);
                continue;
            }

            $this->currentValue = $value;
            $dom   = new Domains(); // new domain class

            $visit = $dom->purchaseVisitors($value->domain_id); // call domain visitors counter
            $limit = $dom->purchaseLimit($value->domain_id, false); // call domain limit counter
 
            $limit_close   = $limit * 1.1; // overlimit number
            $limit_warning = $limit * 0.7; // prelimit number

            $user_money    = $this->user->balance;// current user balance
            $next_purchase = $this->getNextPruchasePlan(); // next plan to purchase

            if ($visit >= $limit_close && $value->purchases_till > \Carbon\Carbon::now()) {

            	echo 'limit';
            }


        }

	}

    protected function getNextPruchasePlan()
    {   
        $current_plan = ModulePlan::find($this->currentValue->module_plan_id);
        $next_plan    = ModulePlan::where('price_mo', '>', $current_plan->price_mo)->orderBy('price_mo', 'ASC')->first();
        return $next_plan;
    }

    protected function uniqueUpdate($domain_id)
    {
    	if(array_search($domain_id, $this->updated_ids)) {
    		return false;
    	} else {
    		array_push($this->updated_ids, $domain_id);
    		return true;
    	}
    }

}
