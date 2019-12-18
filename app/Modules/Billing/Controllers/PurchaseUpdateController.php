<?php namespace App\Modules\Billing\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Modules\Domains\Models\Domains;
use App\Modules\Billing\Models\ModulePlan;
use App\Modules\Billing\Models\ModulePurchase;
use App\Modules\Panel\Controllers\MailController;
use App\Events;
use App\User;
use Auth, DB;

class PurchaseUpdateController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $user, $currentValue;
    protected $updated_ids = [];
    protected $purchases;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    // status
    // 0 - undescribed
    // 1 - active
    // 2 - suspend
    // 3 - no domain
    // 4 - no user


    public function init()
    {
        echo 'init... ';
        $this->purchases = DB::table('module_purchases')
        ->whereIN('status', [1,2])
        ->select('*')
        ->orderBy('created_at', 'DESC')
        ->get();

        foreach ($this->purchases as $key => $value) {
 			// работаем только с последней активной записью (остальные деактивируеме - защита от дублей и багов)
			if(!$this->uniqueUpdate($value->domain_id)) {
				$update = ModulePurchase::where('id', $value->id)->update(['status' => 0]);
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
            // если лимит превышен и время не вышло - меняем статус на заморожен
                $update = ModulePurchase::where('id', $value->id)->update(['status' => 2]);
                //$this->sendMessage('close_message');

            }  else if ($visit >= $limit && $value->purchases_till > \Carbon\Carbon::now()) {
            // если лимит достигнут 100% пытаемся продлить следующий тариф
                $this->autoPurchase($value->domain_id, $next_purchase, $value->id, 1);

            } else if ($visit > $limit_warning && $value->purchases_till > \Carbon\Carbon::now()) {
            // если лимит привысел 70% шлем письмо с предупреждением
                //$this->sendMessage('warning_message');

            }  else if ($value->purchases_till < \Carbon\Carbon::now()) {
	        // если время истекло - пытаемся продлить
                $this->autoPurchase($value->domain_id, ModulePlan::find($this->currentValue->module_plan_id), $value->id, 0);
                //$update = ModulePurchase::where('id', $value->id)->update(['status' => 2]);
            }
        }
    }

    // если лимит больше 110% и время не вышло = отключаем
    // если лимит больше 100% и время не вышло = продлеваем / или отключаем
    // если лимит 70% и время не вышло = письмо с предупреждением
    // если время вышло = меняем статус и пробуем продлить

    protected function uniqueUpdate($domain_id)
    {
    	if(array_search($domain_id, $this->updated_ids)) {
    		return false;
    	} else {
    		array_push($this->updated_ids, $domain_id);
    		return true;
    	}
    }
    // testing function
    protected function preventDouble() 
    {
    	//echo 'preventDouble'.count($this->purchases).PHP_EOL;
    	foreach ($this->purchases as $key => $value)
    	{
    		if ($this->uniqueUpdate($value->domain_id)) {
    			echo 'update '.$value->domain_id.'('.$value->created_at.')'.PHP_EOL;
    		} else {
    			echo 'skip '.$value->domain_id.'('.$value->created_at.')'.PHP_EOL;
    		}
    	}
    }

    protected function sendMessage($message)
    {
        /*$exist = $this->eventExist($message);
        if (!$exist) { 
 
            switch ($message) {
                case 'warning_message':
                    MailController::expireSoon($this->user); 
                    break;
                case 'close_message':
                    MailController::hasExpired($this->user); 
                    break;        
                case 'autopurchase':
                    MailController::Autopurchase($this->user);           
                    break;        
            }

            $this->createEvent($message);   
        }*/
    }

    protected function autoPurchase($domain_id, $next_plan, $value_id, $status)
    {
        if ($this->user->balance > $next_plan->price_mo) {
 
            $purchase = new ModulePurchase();
            $purchase->domain_id      = $domain_id;
            $purchase->module_plan_id = $next_plan->id;
            $purchase->purchases_at   = \Carbon\Carbon::now()->subMinutes(1);
            $purchase->purchases_till = \Carbon\Carbon::now()->addDays(30)->subMinutes(1);
            $purchase->save();
            
            $user = User::find($this->user->id);
            $user->balance = $user->balance - $next_plan->price_mo;
            $user->save();

            $update = ModulePurchase::where('id', $value_id)->update(['status' => 0]);
            $this->sendMessage('autopurchase');
            //\Session::put('success', 'Payment success');
        } else {
        	$update = ModulePurchase::where('id', $value_id)->update(['status' => $status]);
            $this->sendMessage('close_message');
        } 
    }

    protected function getNextPruchasePlan()
    {   
        $current_plan = ModulePlan::find($this->currentValue->module_plan_id);
        $next_plan    = ModulePlan::where('price_mo', '>', $current_plan->price_mo)->orderBy('price_mo', 'ASC')->first();
        return $next_plan;
    }

    protected function eventExist($event_name) 
    {
        return Events::where('item_id', $this->currentValue->id)
            ->where('item_type', 'module_purchases')
            ->where('event_name', $event_name)
            ->exists(); 
    }

    protected function createEvent($message) 
    {
        $event = new Events;
        $event->item_id    = $this->currentValue->id;
        $event->item_type  = 'module_purchases';
        $event->event_name = $message;
        $event->save();    
    }
 
}
