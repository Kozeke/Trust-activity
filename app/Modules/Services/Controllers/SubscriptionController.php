<?php

namespace App\Modules\Services\Controllers;

use DB;
use Illuminate\Http\Request;

class SubscriptionController extends \App\Modules\Panel\Controllers\AbstractController
{
    //

    public function checkSubscriptions() {

    	$subscriptions = DB::table('module_purchases')
            ->where('purchases_at', '<', \Carbon\Carbon::now())
            ->where('purchases_till', '>', \Carbon\Carbon::now())
            ->where('status', 1)
            ->get();

		echo \Carbon\Carbon::now();
		print_r(\Carbon\Carbon::now()->addMinutes(120));

        foreach ($subscriptions as $key => $value) {
        	//print_r($value->purchases_till);
        	$hours = \Carbon\Carbon::now()->diff(\Carbon\Carbon::parse($value->purchases_till))->format('%d %h:%i');
        	print_r($value->id . ' | ' . $hours);
        	echo '<br>';
        }
 

    }

    public function createSubscription() {

    }
}
