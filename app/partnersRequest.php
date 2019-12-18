<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class partnersRequest extends Model
{
    //
    public function user($id)
    {
    	return DB::table('users')->where('id', $id)->first();
    }
}
