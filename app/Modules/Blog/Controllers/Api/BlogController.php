<?php namespace App\Modules\Blog\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;

use Validator, Auth, Hash;

class BlogController extends \App\Modules\Panel\Controllers\AbstractController
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

    public function postBalance(Request $request)
    {
        if (Auth::user()->role === 1) {

            $user = User::find($request->get('user_id'));
            $user->balance = $request->get('balance');
            $user->save();

            return 'true';

        } else {
            return 'false';
        }
    }

}
