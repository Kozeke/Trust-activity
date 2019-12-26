<?php

namespace App\Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Domains\Models\Domains;
use DB;

class ModulePurchase extends Model
{
    //
    public function modulePlan($id)
    {
        $plan = ModulePlan::where('id', $id)->first();
        return ($plan ? $plan : 'none');
    }
    public function module_plan(){
        return $this->belongsTo('App\Modules\Billing\Models\ModulePlan');
    }
    static public function byUserId($id) 
    {
		//$rows = DB::table('domains as d')\
        $rows = Domains::where('user_id', $id)
		->join('module_purchases as mp', 'mp.domain_id', '=', 'domains.id')
        ->join('module_plans as mpl', 'mpl.id', '=', 'mp.module_plan_id')
        ->join('modules as m', 'm.id', '=', 'mpl.module_id')  
        ->select('domains.name as domain_name',
            'domains.id as domain_id',
            'mp.module_plan_id as module_plan_id',
            'mp.purchases_at as purchases_at',
            'mp.purchases_till as purchases_till', 
            'mp.created_at as created_at',
            'mpl.name as module_plan_name',
            'mpl.price_mo as module_plan_price',
            'm.name as module_name',
            'mpl.name as module_plan_name')
		->get();

		return $rows;

    }
}
