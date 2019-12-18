<?php

namespace App\Modules\AdminWithdraw\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class WithdrawLogs extends Model
{
    //
    public function user($id)
    {
    	$user = DB::table('users')->where('id', $id)->first();
    	return $user;
    }
}
