<?php namespace App\Modules\AdminDiscount\Controllers;

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

    public function index()
    {
        if (Auth::user()->role === 1) {
            $discounts = Discount::where('user_id', 0)->get();
            return view('AdminDiscount::index')->with(['domains' => $this->domains, 'discounts' => $discounts]);
        } else {
            return redirect('/admin');
        }
    }

    public function create(Request $request)
    {
        if (Auth::user()->role === 1) {
            return view('AdminDiscount::add')->with(['domains' => $this->domains]);
        } else {
            return redirect('/admin');
        }
    }

    public function store(Request $request)
    {
        $all = $request->all();
        if (Auth::user()->role === 1 && $request->get('bonus_code') != '' && $request->get('discount') != '') {
            $discount = new Discount();
            $discount->user_id    = 0;           
            $discount->bonus_code = $request->get('bonus_code');          
            $discount->discount   = $request->get('discount');     
            $discount->type       = '$';     
            $discount->limit      = '-1';        
            $discount->status     = 1;                              
            $discount->save();
            return redirect('/admin/promo-codes');    
        } else {
            return redirect('/admin/promo-codes/create')
            ->withErrors([])
            ->withInput();
        }
    }

    public function show($id)
    {   
        if (Auth::user()->role === 1) {
            $item = Discount::find($id);
            return view('AdminDiscount::edit')->with(['domains' => $this->domains, 'item' => $item]);            
        } else {
            return redirect('/admin');
        }
    }

    public function update(Request $request,  $id)
    {
        $all = $request->all();
        if (Auth::user()->role === 1 && $request->get('bonus_code') != '' && $request->get('discount') != '') {
            $discount = Discount::find($id); 
            $discount->bonus_code = $request->get('bonus_code');          
            $discount->discount   = $request->get('discount');                           
            $discount->update();
            return redirect('/admin/promo-codes');    
        } else {
            return redirect('/admin/promo-codes/update/'.$id)
            ->withErrors([])
            ->withInput();
        }
    }

 
}
