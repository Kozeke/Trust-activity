<?php namespace App\Modules\Billing\Controllers\lib\Twocheckout;

use App\Modules\Billing\Controllers\lib\Twocheckout\TwocheckoutMessage;
use App\Modules\Billing\Controllers\lib\Twocheckout\Api\TwocheckoutUtil;

class Twocheckout_Notification extends \App\Modules\Billing\Controllers\lib\Twocheckout
{

    public static function check($insMessage=array(), $secretWord)
    {
        $hashSid = $insMessage['vendor_id'];
        $hashOrder = $insMessage['sale_id'];
        $hashInvoice = $insMessage['invoice_id'];
        $StringToHash = strtoupper(md5($hashOrder . $hashSid . $hashInvoice . $secretWord));
        if ($StringToHash != $insMessage['md5_hash']) {
            $result = Twocheckout_Message::message('Fail', 'Hash Mismatch');
        } else {
            $result = Twocheckout_Message::message('Success', 'Hash Matched');
        }
        return Twocheckout_Util::returnResponse($result);
    }

}
