<?php

namespace App\Modules\Domains\Models;

use Illuminate\Database\Eloquent\Model;

class HotStreaks extends Model
{
    //

    public static function updateShow($id)
    {
		$element = HotStreaks::find($id);
		$element->shows = $element->shows + 1;
		$element->save();
    }

    public function capture()
    {
        return $this->hasMany('App\Modules\Domains\Models\HotStreakCapture', 'module_id');
    }

    public function display()
    {
        return $this->hasMany('App\Modules\Domains\Models\HotStreakDisplay', 'module_id');
    }
}
