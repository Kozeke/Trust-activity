<?php

namespace App\Modules\Domains\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class hotStreakActivity extends Model
{
    //
    public function getImage($obj)
    {
    	$ifExist = DB::table('city_images')->where('cityName', $obj->city)->where('status', 1)->first();
    	if ($ifExist) {
    		return 'img/map/'.str_slug($ifExist->cityName).'-'.$ifExist->id.'.png';
    	} else {
    		return 'cdn/img/map.svg';
    	}

    }
}
