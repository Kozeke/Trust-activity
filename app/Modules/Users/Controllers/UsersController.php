<?php namespace App\Modules\Users\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use App\partnersRequest;

use Validator, Auth, Hash, Session;

class UsersController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $per_page = 20;
    protected $offset   = 0;
    protected $pagination = false;
    protected $total      = 0;

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

    public function index()
    {
        if (Auth::user()->role === 1) {

            $this->total = User::count();
            $this->pagenation();
     
            $users = User::whereIN('role', [0,2])->orderBy('id', 'DESC')->offset($this->offset)->limit($this->per_page)->get();

            return view('Users::index')->with(['domains' => $this->domains, 'users' => $users, 'pagination' => $this->pagination]);

        } else {
            return redirect('/admin');
        }
    }

    public function promote(Request $request, $id)
    {
        if (Auth::user()->role == 1) {

            $user = User::find($id);
            if ($user->role == 0) {
                $user->role = 2;
                $request = partnersRequest::where('user_id', $id)->where('status', 0)->first();
                if ($request) {
                    partnersRequest::where('id', $request->id)->update(['status' => 1]);
                }
            } else {
                $user->role = 0;
            }
            $user->save();
        }
 
        return redirect('/admin/users'); 
    }

    protected function pagenation()
    {
        if ($this->total > $this->per_page) {
            $pages      = $this->total / $this->per_page;
            $current = (isset($_GET['page']) ? $_GET['page'] : 1);
            $this->pagination = ['total' => $pages, 'current' => $current];
        } 

        if(isset($_GET['page']) && intval($_GET['page']) && isset($pages)) { $this->offset = ($_GET['page'] - 1) * $this->per_page; } else { $this->offset = 0; }
    }

    public function enterAsUser($id)
    {
        if (Auth::user()->role === 1) {

            $user = User::find($id);
            Session::put('admin_id', Auth::user()->id);
            Auth::login($user);
            return redirect('/admin');

        } else {
            return redirect('/admin');
        } 
    }

    public function enterAsAdmin()
    {   
        if (Session::has('admin_id')) {
            $user = User::find(Session::get('admin_id'));
            Auth::login($user);
        }

        return redirect('/admin/users');   
    }
}
