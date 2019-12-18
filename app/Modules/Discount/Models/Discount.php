<?php

namespace App\Modules\Discount\Models;

use Illuminate\Database\Eloquent\Model;


class Discount extends Model
{
    //

    static function generateBonusCode($len = 8) {

		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$res = "";
		for ($i = 0; $i < 8; $i++) {
		    $res .= $chars[mt_rand(0, strlen($chars)-1)];
		}

		$discount = Discount::where('bonus_code', '=', $res)->first();
 
		if (!$discount) {
    		return $res;
		} else {
			return Discount::generateBonusCode(8);
		}
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
