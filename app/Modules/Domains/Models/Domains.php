<?php

namespace App\Modules\Domains\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Billing\Models\ModulePurchase;
//use Illuminate\Support\Facades\Redis;
use DB;

class Domains extends Model
{
    //
    public function purchases($id, $type = 'name')
    {
        $purchase = ModulePurchase::where('domain_id', $id)
            ->where('purchases_at', '<', \Carbon\Carbon::now())
            ->where('purchases_till', '>', \Carbon\Carbon::now())
            ->whereIn('status' , [1,2])
            ->first();
 
        switch ($type) {
            case 'name':
                return ($purchase ? $purchase->modulePlan($purchase->module_plan_id)->name : '');
                break;
            case 'till':
                return ($purchase ? \Carbon\Carbon::createFromTimeStamp(strtotime($purchase->purchases_till))->format('m/d/Y') : '');
                break;  
            default:
                return ($purchase ? $purchase->modulePlan($purchase->module_plan_id)->name : '');
                break;
        } 
    }

    public function getActivePurchaseStatus($id)
    {
        $purchased = DB::table('module_purchases')
        ->where('domain_id', $id)
        ->where('module_plan_id', 1)
        ->where('purchases_at', '<', \Carbon\Carbon::now())
        ->where('purchases_till', '>', \Carbon\Carbon::now())
        ->first();

        return ($purchased ? $purchased->status: null);

    }

    public function getActivePurchase($id)
    {
        $purchased = DB::table('module_purchases')
        ->where('domain_id', $id)
        ->where('module_plan_id', 1)
        ->where('purchases_at', '<', \Carbon\Carbon::now())
        ->where('purchases_till', '>', \Carbon\Carbon::now())
        ->first();

        return ($purchased ? $purchased: null);

    }
 
    public function purchaseVisitors($id) 
    {

        //DB::enableQueryLog();
        ini_set("memory_limit", "2048M");  
 
        /*if(Redis::get('purchaseVisitors:result-'.$id)){
            return Redis::get('purchaseVisitors:result-'.$id);
        }*/

        $isPurchased = DB::table('domains as d')
            ->where('d.id', $id)
            ->join('module_purchases as mp', 'mp.domain_id', '=', 'd.id')
            ->orderBy('mp.id', 'DESC')
            ->where('mp.status', 1)
            ->orWhere('mp.status', 2)
            ->where('mp.purchases_at', '<', \Carbon\Carbon::now())
            ->where('mp.purchases_till', '>', \Carbon\Carbon::now())
            ->select('mp.purchases_at', 'mp.purchases_till', 'd.id')
            ->first();
 
        if($isPurchased) {

            $ids = DB::table('hot_streaks as hs')
                ->where('hs.domain_id', $id)
                ->get();

            $arr_ids = [];

            foreach ($ids as $key => $value) {
                array_push($arr_ids, $value->id);
            }
            //print_r($arr_ids);
  
            $activity = DB::table('hot_streak_visitors as hsv')
                ->whereIn('hsv.module_id', $arr_ids)
                ->where('hsv.created_at', '>', $isPurchased->purchases_at)
                ->where('hsv.created_at', '<', $isPurchased->purchases_till)
                ->get();
 
            $unique_ip = [];

            foreach ($activity as $key => $value) {
                if (!isset($unique_ip[$value->ip])) {
                    $unique_ip[$value->ip] = 1;
                }
            }

            //dd(DB::getQueryLog());

            //die;
            //Redis::set('purchaseVisitors:result-'.$id, count($unique_ip), 'EX', 600);
            return count($unique_ip);

        } else {

            return 0;
        }
    }

    public function purchaseLimit($id, $active = true) 
    {   
        ini_set("memory_limit", "2048M"); 

        /*if(Redis::get('purchaseLimit:result-'.$id)){
            return Redis::get('purchaseLimit:result-'.$id);
        }*/

        if ($active) {
            $purchase = ModulePurchase::where('domain_id', $id)
                ->where('purchases_at', '<', \Carbon\Carbon::now())
                ->where('purchases_till', '>', \Carbon\Carbon::now())
                ->whereIN('status', [1,2])
                ->join('module_plans', 'module_plans.id', '=', 'module_purchases.module_plan_id')
                ->first();
        } else {
            $purchase = ModulePurchase::where('domain_id', $id)
                ->whereIN('status', [1,2])
                ->join('module_plans', 'module_plans.id', '=', 'module_purchases.module_plan_id')
                ->first();
        }
 
        if ($purchase) {
            //Redis::set('purchaseLimit:result-'.$id, $purchase->visitors_mo, 'EX', 600);
            return $purchase->visitors_mo;
        }
    }

    public function purchaseProgressStatus($id)
    {
        ini_set("memory_limit", "2048M");
        $visitors_current = $this->purchaseVisitors($id);
        $visitors_mo      = $this->purchaseLimit($id);
 
        $total = ($visitors_mo > 0 ? ($visitors_current * 100) / $visitors_mo : 0);

        return ($total > 100 ? 100 : $total);
    }

    static public function getNotificationCampaigns($token)
    {
        $isPurchased = Domains::where('hash_key', $token)
            ->where('deleted_at', null)
            ->join('module_purchases', 'module_purchases.domain_id', '=', 'domains.id')
            ->where('module_purchases.purchases_at', '<', \Carbon\Carbon::now())
            ->where('module_purchases.purchases_till', '>', \Carbon\Carbon::now())
            ->where('module_purchases.status', 1)
            //->orWhere('module_purchases.status', 2)  
            ->exists();

        if ($isPurchased) {
            return Domains::where('hash_key', $token)
            ->join('hot_streaks', 'hot_streaks.domain_id', '=', 'domains.id')
            ->where('hot_streaks.status', '1')
            ->get();
        } else {
            return false;
        }
    }

    static public function DisplayUrlExist($token, $postFrom) {
 
        $last_sym          = substr($postFrom, -1);
        $postFromWithSlash = $postFrom;

        if ($last_sym != '/') {
            $postFromWithSlash = $postFrom.'/';
        }

        return Domains::where('hash_key', $token)
            ->join('hot_streaks', 'hot_streaks.domain_id', '=', 'domains.id')
            ->join('hot_streak_displays', 'hot_streak_displays.module_id', '=', 'hot_streaks.id')
            ->where('hot_streak_displays.url', $postFrom)
            ->orWhere('hot_streak_displays.url', $postFromWithSlash)      
            ->exists();
    }

    public function acitivityFor24h($id) {

        /*return DB::table('domain_statuses')
                ->where('domain_id', $id)
                ->where('isInstalled', 1)
                ->exists();*/

        //return true;
        return DB::table('hot_streaks')
            ->where('hot_streaks.domain_id', $id)
            ->join('hot_streak_shows', 'hot_streak_shows.module_id', '=', 'hot_streaks.id')
            ->where('hot_streak_shows.created_at','>=', \Carbon\Carbon::now()->subDay()) 
            ->exists();
    }
}
