<?php 

namespace App\Modules\Panel\Controllers;

use App\Modules\Panel\Models\User as User;
use App\Modules\Discount\Models\Discount as Discount;
use App\Modules\Panel\Controllers\MailController;
use App\Payments;
use Socialite;
use Auth;

class SocialFacebookController extends AbstractAuthController
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {   
        if (isset($_GET['error'])) {
            return redirect('/auth/login');
        }
 
        $fb_user = Socialite::driver('facebook')->user();

        $user = User::where('email', $fb_user->email)->first();

        if($user) {
            Auth::login($user);
            return redirect('/admin');
        } else {

            $pass = Discount::generateBonusCode(6);

            $user              = new User;
            $user->email       = $fb_user->email;
            $user->password    = bcrypt($pass);
            $user->balance     = 0;
            $user->role        = 0;
            $user->referral_id = 0;
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
            MailController::registrationSocial($user, $pass);            

            return redirect('/admin');
        }
    }
}
