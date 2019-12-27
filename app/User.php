<?php

namespace App;

use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Modules\Billing\Models\ModulePurchase;
use App\Modules\Billing\Models\ModulePlan;
use App\Payments;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userDomains($id)
    {
        $domains = DB::table('domains as d')
        ->where('user_id', $id)
        ->select(
            'd.name',
            'd.url',            
            DB::raw("(
            SELECT  COUNT(id)
            FROM    hot_streaks 
            WHERE   hot_streaks.domain_id = d.id
            ) as count")
        )->get();

        return $domains;
    }

    public function discount() 
    {
        return $this->hasOne('App\Modules\Discount\Models\Discount');
    }

    public function domains()
    {
        return $this->hasMany('App\Modules\Domains\Models\Domains');
    }
    public function scopeFilter($query,$filters)
    {
        if (isset($filters['search_text'])) {
            $search_text = $filters['search_text'];
            $query->where('email','LIKE', '%' . $search_text . '%');
        }
//        dd($filters['status']);
        if(isset($filters['status'])) {
            $status = $filters['status'];
            $query->whereHas('payments', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }
        return $query;
    }
    public function sortingUsers($user)
    {
        $purchases=[];
        foreach ($user->domains as $key => $domain) {
            if (isset($domain->module_purchases)) {
                foreach ($domain->module_purchases as $key1 => $purchase) {

                    if(isset($purchase->module_plan)){
                        $purchase->module_plan_name=$purchase->module_plan->name;
                        $purchase->module_plan_price=$purchase->module_plan->price_mo;
                        $purchase->module_name=$purchase->module_plan->module->name;
//                        dd($purchase);

                    }
                    array_push($purchases,$purchase);
                }
            }

        }
        $this->purchases = $purchases;
        $this->invoices = $user->payments;

        $result=$this->getPaymentHistory($user->id);
        return $result;
    }
    public function totalReferrals($id)
    {
        return DB::table('users')->where('referral_id', $id)->count();
    }
    public function payments()
    {
        return $this->hasMany('App\Payments');
    }
    public function getPaymentHistory($id)
    {
//        $this->invoices  =  Payments::where('user_id', $id)->whereIn('status', ['success', 'failed'])->get();
//        $this->purchases =  ModulePurchase::byUserId($id);

        $list = $this->MergePaymentPurchase();
        return $list;
    }

    protected function MergePaymentPurchase() 
    {
        foreach($this->purchases as $purchase) {

            $from  = \Carbon\Carbon::createFromTimeStamp(strtotime($purchase->purchases_at));
            $to    = \Carbon\Carbon::createFromTimeStamp(strtotime($purchase->purchases_till));
            $diff  = $from->diffInSeconds($to);
            $days  = (($diff / 60) / 60) / 24;
            if ($days < 30) {
                continue;
            }

            $this->invoices->add($purchase);
        }

        $this->invoices = $this->invoices->sortByDesc('created_at');

        foreach($this->invoices as $invoice) {

            $invoice->date = \Carbon\Carbon::createFromTimeStamp(strtotime($invoice->created_at))->format('M d, Y');
        }

        return $this->invoices;
    }
}
