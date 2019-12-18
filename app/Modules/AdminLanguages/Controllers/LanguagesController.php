<?php namespace App\Modules\AdminLanguages\Controllers;

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

    public function index()
    {
        if (Auth::user()->role === 1) {
            $languageValues = LanguagesController::sort(LanguageValues::all());
            $languages      = Languages::all();
            return view('AdminLanguages::index')->with(['domains' => $this->domains, 'languageValues' => $languageValues, 'languages' => $languages]);
        } else {
            return redirect('/admin');
        }
    }

    protected function sort($languageValues)
    {
        $sorted = [];

        foreach ($languageValues as $key => $value) {
            if(!isset($sorted[$value->slug])) {
                $sorted[$value->slug] = $value;
            }
        }

        return $sorted;
    }
}
