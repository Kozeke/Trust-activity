<?php namespace App\Modules\Panel\Controllers;

use App\Modules\Panel\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Modules\Domains\Models\Domains;
use Auth, DB, Session;
use App\Modules\Faq\Models\FaqValues;
use Illuminate\Http\Request;

class PanelController extends AbstractController
{
    use StatisticTrait;
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

            return view('Panel::admin_index')->with([
                'domains' => $this->domains,
                'activeNotif' => $this->activeNotifiactionUsers(),
                'trialUsersCount' => User::whereTrial(1)->count(),
                'allUsersCount' => User::count()
            ]);
        } else {

            if (count($this->domains) > 0) {
                $first = $this->domains->first();
                return redirect('/admin/domains/'.$first->id);
            }

            return (count($this->domains) == 0 ? view('Panel::welcome')->with('domains', $this->domains) : redirect('admin/domains'));                
        }
    }

    public function video()
    { 
        if (Auth::user()->role === 1) {
            return view('Panel::admin_index')->with(['domains' => $this->domains]);
        } else {
            return view('Panel::video')->with(['domains' => $this->domains]);
        }
    }

    public function guide_1()
    {   
        if (Auth::user()->role === 1) {
            return view('Panel::admin_index')->with(['domains' => $this->domains]);
        } else {
            return view('Panel::guide1')->with(['domains' => $this->domains]);
        }
    }

    public function dashboard()
    {   
        if (Auth::user()->role === 1) {
            return view('Panel::admin_index')->with(['domains' => $this->domains]);
        } else {
            return view('Panel::dashboard')->with(['domains' => $this->domains]);
        }
    }

    public function guide_2()
    { 
        if (Auth::user()->role === 1) {
            return view('Panel::admin_index')->with(['domains' => $this->domains]);
        } else {
            return view('Panel::guide2')->with(['domains' => $this->domains]);
        }
    }

    public function settings()
    { 
        return view('Panel::settings')->with(['domains' => $this->domains]);
    }
 
    public function topUp()
    { 
        return view('Panel::topup')->with(['domains' => $this->domains]);
    }

    public function resolutionCenter()
    { 
        return view('Panel::resolutioncenter')->with(['domains' => $this->domains]);
    }

    public function faq()
    { 
        return view('Panel::faq')->with(['domains' => $this->domains]);
    }
 
    public function showVideoPage()
    {
        return view('Panel::video')->with(['domains' => $this->domains]);
    }

    public function showGuide()
    {
        return view('Panel::index')->with(['domains' => $this->domains]);
    }

    public static function getTranslateArray()
    {
        return parent::getTranslations();
    }

    public function changeLang($slug)
    {
        $this->translate = self::getTranslations($slug);
        /*switch ($slug) {
            case 'ru':
                $lang = 'ru';
                $list = DB::table('languages as l')->where('l.name', 'ru')
                ->join('language_values as lv', 'lv.language_id', '=', 'l.id')
                ->select('lv.slug', 'lv.value')
                ->get();
                break;
            case 'en':
                $lang = 'en';
                $list = DB::table('languages as l')->where('l.name', 'en')
                ->join('language_values as lv', 'lv.language_id', '=', 'l.id')
                ->select('lv.slug', 'lv.value')
                ->get();
                break;
            default:
                $lang = 'en';
                $list = DB::table('languages as l')->where('l.name', 'en')
                ->join('language_values as lv', 'lv.language_id', '=', 'l.id')
                ->select('lv.slug', 'lv.value')
                ->get();
                break;
        }

        $sorted_list = [];
        $sorted_list['lang'] = $lang;

        foreach ($list as $key => $value) {
            $sorted_list[$value->slug] = $value->value; 
        }

        Session::put('translate', $sorted_list);*/

        return back();
    }

    public function checkout()
    {
        return view('Panel::checkout')->with(['domains' => $this->domains]);
    }

    public function checkout2(Request $request)
    {
        $Input = Input::all();

        print_r($Input);

        /*
            "sellerId"        => "901404501", 
            "privateKey"      => "99648B11-18B2-4FBC-A4FB-2061EF22782C",
            "merchantOrderId" => "1",
            "token"           => $Input['token'],
        */
        $url = 'https://sandbox.2checkout.com/checkout/api/1/901404501/rs/authService';
        $fields = array(
            "sellerId"        => "901404501",
            "privateKey"      => "99648B11-18B2-4FBC-A4FB-2061EF22782C",
            "merchantOrderId" => "123",
            "token"    => $Input['token'],
            "currency" => "USD",
            "total"    => "9.99",
            "billingAddr" => [
                "name"        => $Input['name'],
                "addrLine1"   => $Input['addrLine1'],
                "city"        => $Input['city'],
                "state"       => $Input['state'],
                "zipCode"     => $Input['zipCode'],
                "country"     => $Input['country'],
                "phoneNumber" => $Input['phoneNumber'],
                "email" => Auth::user()->email,
            ]
        );


        $data_string = json_encode($fields);                                                                                   
                                                                                                                             
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
                                                                                                                             
        $result = curl_exec($ch);
        $data_arr = json_decode($result); 
        print_r($data_arr);
        //close connection
        curl_close($ch);

       //print_r($Input);
/*

curl -X POST https://sandbox.2checkout.com/checkout/api/1/901404501/rs/authService \
    -d '{"sellerId": "901404501", "privateKey": "99648B11-18B2-4FBC-A4FB-2061EF22782C", "merchantOrderId": "123", "token": "OGVlZjdmOWUtNWEwZS00ODAxLWEyY2MtZjRjODUwNTA3ZjA4", "currency": "USD", "lineItems": [{"name": "Demo Item", "price": "4.99", "type": "product", "quantity": "1", "recurrence": "4 Year", "startupFee": "9.99"}  ], "billingAddr": {"name": "testing tester", "addrLine1": "123 test blvd", "city": "columbus", "state": "Ohio", "zipCode": "43123", "country": "USA", "email": "example@2co.com", "phoneNumber": "123456789"} }' \
    -H 'Accept: application/json' -H 'Content-Type: application/json'

*/



        //print_r($Input);
    }

    public function test() 
    {
        /*$categories = DB::table('faqs')->get();
        $languages  = DB::table('languages')->get();

        foreach ($categories as $key => $category) {
 
            $attrs = [
                'title' => $category->title,
                'h1'    => $category->h1,      
                'description' => $category->description,
                'url'         => $category->url,
                'content'     => $category->content, 
                'externalurl' => $category->external_url,                          
            ];

            $element = new FaqValues;
            $element->item_id = $category->id;
            $element->type    = 'article';
            $element->lang    = ''; 
            $element->name    = 'categoryid';
            $element->value   = $category->category_id;
            $element->save();

            foreach ($attrs as $key => $attr) {

                foreach ($languages as $key2 => $language) {
                    $element = new FaqValues;
                    $element->item_id = $category->id;
                    $element->type    = 'article';
                    $element->lang    = $language->name; 
                    $element->name    = $key;
                    $element->value   = $attr;
                    $element->save();
                }
            }*
        }*/
    }
}
