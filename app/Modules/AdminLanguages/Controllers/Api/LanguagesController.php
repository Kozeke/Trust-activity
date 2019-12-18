<?php namespace App\Modules\AdminLanguages\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\AdminLanguages\Models\LanguageValues;
use App\Modules\AdminLanguages\Models\Languages;
use Validator, Auth, Hash, Session;
use App\User;

class LanguagesController extends \App\Modules\Panel\Controllers\AbstractController
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

    public function add(Request $request)
    {
        if (Auth::user()->role === 1) {
            
            $item       = new Languages();
            $item->name = $request->get('name');
            $item->save();

            return 'true';
        } else {
            return 'false';
        }
    }

    public function list(Request $request)
    {
        if (Auth::user()->role === 1) {
            $list = Languages::all();
            return response()->json($list);
        } else {
            return 'false';
        }
    }

    public function value(Request $request)
    {
        if (Auth::user()->role === 1) {
            ////
            $inputs = $request->all();
            ///
            if (strlen($inputs['name']) == 0) { return 'false'; }
            ///
            $exist = LanguageValues::where('slug', str_slug($inputs['name']))->first();
            ///
            if (!$exist) {

                foreach ($inputs['trans'] as $key => $value) {
                    //str_slug
                    $pieces = explode('-', $key);
                    $item = new LanguageValues();
                    $item->name  = $inputs['name'];    
                    $item->slug  = str_slug($inputs['name']);    
                    $item->value = $value;    
                    $item->language_id = $pieces[1];
                    $item->save();       
                }

                return 'true';
            }
            //print_r($inputs);
        } else {
            return 'false';
        } 
    }

    public function valueUpdate(Request $request) 
    {
        if (Auth::user()->role === 1) {
            ////
            $inputs = $request->all();
            ///
            if (strlen($inputs['name']) == 0) { return 'false'; }
                ///
                $items = LanguageValues::where('slug', $inputs['slug'])->get();
                foreach ($items as $key => $value) {
                    foreach ($inputs['trans'] as $key2 => $value2) {
                        $pieces = explode('-', $key2);
                        if ($value->language_id == $pieces[1]) {
                            $value->value = $value2;
                            $value->save();
                        }
                    }
                }
            return 'true';

        } else {
            return 'false';
        }    
    }

}
