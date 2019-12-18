<?php 

namespace App\Modules\Panel\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Validator, Auth;

use App\Modules\Panel\Middleware\PanelAuth as PanelAuth;
use App\Modules\Panel\Models\User as User;
use App\Modules\Discount\Models\Discount as Discount;
use Illuminate\Http\Request as Request;
use App\Modules\Panel\Controllers\MailController;
use App\Payments;

class RegisterController extends AbstractAuthController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    { 
        $this->middleware('guest');
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('Panel::auth.register')->with('translate', $this->translate);
    }

    public function store(Request $request)
    {
  
        return $this->validation($request);//(User::isUserExist() > 0 ? redirect('/admin') : $this->validation($request));
    }
 
    protected function validation($request)
    {
        $user_number = count(User::all());
        $role = ($user_number > 0 ? 0 : 1);
 
        $validator = Validator::make($request->all(), [
            'email'                 => 'required|unique:users|max:255',
            'password'              => 'required|confirmed|min:6|max:255',
            'agrement'              => 'required',
            //'password_confirmation' => ''
        ]);

        if (trim($request->get('bonus_code')) != '' && $request->get('bonus_open') === 'on') {
            $ifBonusCodeExist = Discount::where('bonus_code', $request->get('bonus_code'))->first();   
            if ($ifBonusCodeExist === null) {
               // user doesn't exist
                $validator->errors()->add('bonus_code', 'Bonus code not valid!');
                return redirect('/auth/register')
                ->withErrors($validator)
                ->withInput();
            } else {

                if ($ifBonusCodeExist->user_id != 0) { $balance = 10; } else 
                if ($ifBonusCodeExist->user_id == 0 && $ifBonusCodeExist->type != '%') { 
                    $balance = $ifBonusCodeExist->discount;
                    $new_payment = 1;
                }
                
                $referral_id = $ifBonusCodeExist->user_id;
            }

        } else {

            $balance = 0;
            if ($request->get('refferal_id') !== null) {
                if (User::find($request->get('refferal_id'))) {
                    $referral_id = $request->get('refferal_id');
                } else {
                    $referral_id = 0;
                }
            } else {
                $referral_id = 0;
            }
        }

        if ($validator->fails()) {

            return redirect('/auth/register')
            ->withErrors($validator)
            ->withInput();

        } else {

            $user              = new User;
            $user->email       = $request->get('email');
            $user->password    = bcrypt($request->get('password'));
            $user->balance     = $balance;
            $user->role        = $role;
            $user->referral_id = $referral_id;
            $user->trial       = 1;     
            $user->save();

            $bonus_code = Discount::generateBonusCode(8);

            $discount             = new Discount;
            $discount->user_id    = $user->id;
            $discount->bonus_code = $bonus_code;
            $discount->discount   = 20;
            $discount->save();     

            if(isset($new_payment)) {

                $payment = new Payments;
                $payment->user_id  = $user->id;
                $payment->method   = 'promo-code'; 
                $payment->amount   = $balance;
                $payment->bonus    = 0;
                $payment->type     = 'Promo code';
                $payment->currency = 'USD';     
                $payment->status   = 'success';  
                $payment->save();
            }

            Auth::login($user);
            MailController::registration($user);            

            return redirect('/admin');
        }

        return redirect('/auth/register')->withInput();
    }
}
