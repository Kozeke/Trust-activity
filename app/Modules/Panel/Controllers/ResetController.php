<?php 

namespace App\Modules\Panel\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Auth, Session, DB, Validator, Mail, Request;
use \App\User;

class ResetController extends AbstractAuthController
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
        return view('Panel::auth.reset')->with('translate', $this->translate);    
    }

    public function store(Request $request)
    {
        $email   = Input::get('email');
        $ifExist = $this->checkEmail($request);

        if ($ifExist) {

            $today  = date("Y-m-d H:i:s");
            $remove = DB::table('password_resets')->where('email', $email)->delete();
            $token  = hash('sha256', $email.'_'.$today);

            DB::table('password_resets')->insert(
                ['email' => $email, 'token' => $token, 'created_at' => $today]
            );

            $user = User::where('email', $email)->first();

            $data = [
                'token' => $token,
                'email' => $email
            ];

            Mail::send('mails.password', ['data' => $data], function ($m) use ($user) {
                $m->from('noreply@trustactivity.com', 'Trustactivity');
                $m->to($user->email, $user->email)->subject('Password reset on Trustactivity.com');
            });
 

            return redirect('/auth/reset/success');
        }

        return redirect('/auth/reset')->withInput()->with('message', 'Wrong email.');
    }

    public function getSuccess()
    {
        return view('Panel::auth.resetSuccess');    
    }

    public function getRestorePassword(Request $request, $token)
    {
        $ifExist = DB::table('password_resets')->where('token', $token)->get();
        if ($ifExist) {
            return View("Panel::auth.resetChange")->with('token', $token);
        } else {
            return redirect('/');
        }
    }

    public function postRestorePasswordSave(Request $request)
    {
        $email    = Input::get('email');
        $hash     = Input::get('hash');
        $password = Input::get('password');
        $password_confirmation = Input::get('password_confirmation');
        $errors    = [];

        $ifExist = DB::table('password_resets')->where(['token' => $hash, 'email' => $email])->first();

        if (strlen($password) < 5) {
                $errors['password'] = 'Password must be at least 5 chars';
        }

        if (strlen($password_confirmation) < 5) {
                $errors['password_confirmation'] = 'Paassword must be at least 5 chars';
        }

        if(strlen($password) > 5 && strlen($password_confirmation) > 5 && $password != $password_confirmation) {
                //$errors['password'] = 'The password must be at least 5 chars.';
                $errors['password_confirmation'] = 'Password confirmation does not match';
        }

        if (!$ifExist) {
            $errors['email'] = 'Email does not exist.';
        }

        if(count($errors) == 0) {

            $user = User::where('email', $email)->first();
            $user->password = bcrypt($password);
            $user->save();

            DB::table('password_resets')->where(['token' => $hash, 'email' => $email])->delete();
            return redirect('/auth/login')->withInput()->with('changed', 'Password was successfully changed.');
            //echo 'success';
        }

        return redirect('/auth/reset/'.$hash)->withInput()->withErrors($errors);
    }

    public function checkEmail(Request $request)
    {
        $email   = Input::get('email');
        $ifExist = DB::table('users')->where('email', $email)->first();

        if ($ifExist) {
            return true;
        } else {
            return false;
        }
    }

}
