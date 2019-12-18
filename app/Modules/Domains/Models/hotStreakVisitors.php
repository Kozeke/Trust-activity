<?php

namespace App\Modules\Domains\Models;

use Illuminate\Database\Eloquent\Model;

class hotStreakVisitors extends Model
{
    public static function updateShow($referer, $request, $module_id)
    {
    	$ip       = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR'));
        $last     = hotStreakVisitors::where(['module_id' => $module_id, 'ip' => $ip])->orderBy('created_at', 'DESC')->first();
        $postFrom = str_replace(array('http://', 'https://', 'www.'), '', $referer);

    	if ($last) {
	    	if (strtotime($last['created_at']) < strtotime('-1 days')) {
	            $activity            = new hotStreakVisitors(); 
	            $activity->module_id = $module_id;
	            $activity->ip        = $ip;
                $activity->url       = $postFrom;
	            $activity->save(); 
	    	}
    	} else {
            $activity            = new hotStreakVisitors(); 
            $activity->module_id = $module_id;
            $activity->ip        = $ip;
            $activity->url       = $postFrom;
            $activity->save(); 	
    	}

    }
    //
}
