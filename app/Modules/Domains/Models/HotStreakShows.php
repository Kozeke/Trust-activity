<?php

namespace App\Modules\Domains\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Domains\Models\Domains;

class HotStreakShows extends Model
{
    public static function updateShow($referer, $request, $module_id, $domain_id)
    {
    	$ip       = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR'));
        $postFrom = str_replace(array('http://', 'https://', 'www.'), '', $referer);

        $activity            = new HotStreakShows(); 
        $activity->module_id = $module_id;
        $activity->domain_id = $domain_id;
        $activity->ip        = $ip;
        $activity->url       = $postFrom;
        $activity->save(); 
    }

    public static function notInstalledShow($referer, $request, $token)
    {
        $ip       = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR')); 
        $postFrom = str_replace(array('http://', 'https://', 'www.'), '', $referer);

        $ifDomainExist = Domains::where('hash_key', $token)->first();
        //$exists        = HotStreakShows::where('url', $postFrom)->first();

        if ($ifDomainExist) {
            $exists = HotStreakShows::where('domain_id', $ifDomainExist->id)->where('module_id', 0)->first();
            if(!$exists) {
                $activity            = new HotStreakShows(); 
                $activity->module_id = 0;
                $activity->domain_id = $ifDomainExist->id;
                $activity->ip        = $ip;
                $activity->url       = $postFrom;
                $activity->save();                 
            }
        }
    }
}
