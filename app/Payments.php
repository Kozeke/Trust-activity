<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //
    public static function getDate($date)
    {
  		return \Carbon\Carbon::createFromTimeStamp(strtotime($date))->format('m/d/Y g:i A'); 
    }
}
