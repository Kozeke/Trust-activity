<?php namespace App\Modules\Billing\Controllers\lib\Twocheckout\Api;

use App\Modules\Billing\Controllers\lib\Twocheckout\Api\Twocheckout_Api_Requester;
use App\Modules\Billing\Controllers\lib\Twocheckout\Api\Twocheckout_Util;

class Twocheckout_Company extends \App\Modules\Billing\Controllers\lib\Twocheckout
{

    public static function retrieve()
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/acct/detail_company_info';
        $result = $request->doCall($urlSuffix);
        return Twocheckout_Util::returnResponse($result);
    }
}

class Twocheckout_Contact extends \App\Modules\Billing\Controllers\lib\Twocheckout
{

    public static function retrieve()
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/acct/detail_contact_info';
        $result = $request->doCall($urlSuffix);
        return Twocheckout_Util::returnResponse($result);
    }
}