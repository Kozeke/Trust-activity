<?php namespace App\Modules\AdminDiscount\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
 
use Validator, Auth, Hash, Session;
use App\User;
use App\Modules\Discount\Models\Discount;

class DiscountController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCode(Request $requst)
    {
        if (Auth::user()->role === 1) {
            $code = Discount::generateBonusCode(8);
            if (strlen($code) == 8) {
                return $code;                
            }
        } 
    }

    public function delete(Request $requst)
    {
        if (Auth::user()->role === 1) {
            $id = $requst->get('id');
            $discount = Discount::find($id);
            $discount->delete();

            return 'success';
        } else {
            return 'false';
        }
    }


}
