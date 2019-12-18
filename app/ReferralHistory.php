<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class ReferralHistory extends Model
{
    //
    public function userEmail($id)
    {
    	$user = DB::table('users')->where('id', $id)->first();
    	return (isset($user) ? $user->email : '0');
    }
}
