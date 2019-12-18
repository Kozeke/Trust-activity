<?php namespace App\Modules\Partners\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use App\partnersRequest;
use DB;
use Validator, Auth, Hash, Session;

class PartnersController extends \App\Modules\Panel\Controllers\AbstractController
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

    public function index()
    {
        if (Auth::user()->role === 2) {
            $users = User::where('referral_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            foreach ($users as $key => $value) { 
                $value->created = \Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->format('m/d/Y g:i A'); 
            }
            return view('Partners::index')->with(['domains' => $this->domains, 'users' => $users, 'user' => User::find(Auth::user()->id)]);
        } else {
            $status = DB::table('partners_requests')->where('user_id', Auth::user()->id)->where('status', 0)->first();
            return view('Partners::welcome')->with(['domains' => $this->domains, 'status' => $status]);
        }
    }

    public function sendRequest() 
    {
        $status = DB::table('partners_requests')->where('user_id', Auth::user()->id)->where('status', 0)->first();
        if (!$status) {
            $part = new partnersRequest();
            $part->user_id = Auth::user()->id;
            $part->save();

            return 'true';
        }

        return 'false';
    }

    public function enterAsUser($id)
    {
        if (Auth::user()->role === 2) {
            $ifExist = User::where('id', $id)->where('referral_id', Auth::user()->id)->first();
            if ($ifExist) {
                Session::put('partner_id', Auth::user()->id);
                $user = User::find($ifExist->id);
                Auth::login($user);
                return redirect('/admin');                
            } else {
                return redirect('/admin/partners');
            }
        } else {
            return redirect('/admin/partners');
        }
    }

    public function enterAsPartner()
    {   
        if (Session::has('partner_id')) {
            $user = User::find(Session::get('partner_id'));
            Session::forget('partner_id');
            Auth::login($user);
        }

        return redirect('/admin/partners');   
    }

    public function AdminList()
    {
        if (Auth::user()->role === 1) {
            $users = partnersRequest::all();
            return view('Partners::list')->with(['domains' => $this->domains, 'users' => $users]);
        } else {
            return redirect('admin/partners');
        }   
    }

    public function accept(Request $request)
    {
        if (Auth::user()->role === 1) {

            $id      = $request->get('id');
            $request = partnersRequest::find($id);

            if ($request->status == 0) {
                $user  = User::find($request->user_id);
                $user->role = 2;
                $user->save();
                $request->status = 1;   
                $request->save();                
            }
        }  

        return redirect('/admin/partners-list');
    }

    public function decline(Request $request)
    {
        if (Auth::user()->role === 1) {
            $id      = $request->get('id');
            $request = partnersRequest::find($id);
            
            if ($request->status == 0) {
                $request->status = 2;   
                $request->save();
            }
        }  

        return redirect('/admin/partners-list');
    }
 
}
