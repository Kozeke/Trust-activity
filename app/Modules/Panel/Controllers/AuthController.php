<?php 

namespace App\Modules\Panel\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Modules\Panel\Middleware\PanelAuth as PanelAuth;
use App\Modules\Panel\Models\User as User;
use Illuminate\Http\Request as Request;
use Auth, DB, Session;

class AuthController extends AbstractAuthController
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
        return (User::isUserExist() == 0 ? view('Panel::auth.firstUser') : view('Panel::auth.login')->with('translate', $this->translate));
    }

    public function store(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return redirect('/admin');
        } else {
            return redirect('/auth/login')->withInput()->with('message', 'Wrong email/password combination.');
        } 

    }
}
