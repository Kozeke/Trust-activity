<?php namespace App\Modules\Billing\Controllers\lib\Twocheckout\Api;

use App\Modules\Billing\Controllers\lib\Twocheckout\Api\Twocheckout_Api_Requester;
use App\Modules\Billing\Controllers\lib\Twocheckout\Api\Twocheckout_Util;

class Twocheckout_Option extends \App\Modules\Billing\Controllers\lib\Twocheckout
{

    public static function create($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/create_option';
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

    public static function retrieve($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        if(array_key_exists("option_id",$params)) {
            $urlSuffix = '/api/products/detail_option';
        } else {
            $urlSuffix = '/api/products/list_options';
        }
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

    public static function update($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/update_option';
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

    public static function delete($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/delete_option';
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

}