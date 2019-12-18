<?php 

namespace App\Modules\Panel\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Auth, Session;
 
class LogoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    { 
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        Auth::logout();
        Session::flush();
        return redirect('/admin');
    }
}
