<?php

namespace App\Modules\AdminSettings\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSettings extends Model
{
    //
    public static function allSorted() 
    {
	    $settings = AdminSettings::all();
	    $settings_sort = [];

	    foreach ($settings as $key => $value) {
	        $settings_sort[$value->name] = $value;
	    }

    	return $settings_sort;
    }
}
