<?php

namespace App\Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;

class ModulePlan extends Model
{
    public function module(){
        return $this->belongsTo('App\Modules\Billing\Models\Modules');
    }
}
