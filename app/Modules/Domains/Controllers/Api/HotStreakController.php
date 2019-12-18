<?php namespace App\Modules\Domains\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use App\Modules\Domains\Models\Domains;
use App\Modules\Domains\Models\DomainSettings;
use App\Modules\Domains\Models\HotStreaks;
use App\Modules\Domains\Models\HotStreakCapture;
use App\Modules\Domains\Models\HotStreakDisplay;
use App\Modules\Domains\Models\HotStreaksActivity;

use Validator, Auth, DB, Location;

class HotStreakController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //parent::__construct();
    }
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function getList(Request $request)
    {
        ini_set('max_execution_time', 900);
        ini_set("memory_limit", "8096M");  
 
        $ifDomainExist = DB::table('domains')->where(['id' => $request->get('domain-id'), 'user_id' => Auth::user()->id])->first();
        
        if ($ifDomainExist) {

            $ifDomainExist->d_created_at = $this->updateDate($ifDomainExist->created_at);//\Carbon\Carbon::createFromTimeStamp(strtotime($ifDomainExist->created_at))->format('M d, Y g:i A'); 

            $settings = DB::table('domain_settings')->where('domain_id', $request->get('domain-id'))->first();
 
            DB::enableQueryLog();
            $compaigns = DB::table('domains as d')
            ->where('d.id', $request->get('domain-id'))
            ->where('d.user_id', Auth::user()->id)
            ->join('hot_streaks as hs', 'hs.domain_id', '=', 'd.id')
            ->select(
                'hs.id',
                'hs.name',
                'hs.message',
                'hs.status',
                'hs.updated_at as hs_updated_at',
                'hs.image',
                'd.id as domain_id',
                'hs.deleted_at',
                DB::raw("(
                SELECT  COUNT(id)
                FROM    hot_streak_shows 
                WHERE   hot_streak_shows.module_id = hs.id
                ) as shows")
            )
            ->orderBy('id', 'DESC')
            ->get();
 
            $activity = DB::table('domains as d')
            ->where('d.id', $request->get('domain-id'))
            ->where('d.user_id', Auth::user()->id)
            ->join('hot_streaks as hs', 'hs.domain_id', '=', 'd.id')
            ->join('hot_streak_activities as hsa', 'hsa.hot_streak_id', '=', 'hs.id')
            ->select('hsa.id as item_id', 'hsa.hot_streak_id', 'hsa.email', 'hsa.city', 'hsa.city_code', 'hsa.gravatar_data', 'hsa.updated_at', 'hs.id', 'hsa.created_at')
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->limit(100)
            ->get();

            foreach ($compaigns as $key => $value) {
                $value->modified_at = $this->updateDate($value->hs_updated_at);
                if ($value->deleted_at !== null) { 
                    $value->deleted = true; 
                    $startTime      = \Carbon\Carbon::createFromTimeStamp(strtotime($value->deleted_at))->addHour(24);
                    $finishTime     = \Carbon\Carbon::now();
                    $totalDuration  = $finishTime->diffInSeconds($startTime);
                    $value->deleted_left = gmdate('H:i', $totalDuration);
                }
            }

            foreach ($activity as $key => $value) {
                $value->image         = $this->getImage($value);   
                $value->gravatar_data = unserialize($value->gravatar_data);
                $value->created_at   = $this->updateDate($value->created_at);
            }

            $purchased = DB::table('module_purchases')
            ->where('domain_id', $request->get('domain-id'))
            ->where('purchases_at', '<', \Carbon\Carbon::now())
            ->where('purchases_till', '>', \Carbon\Carbon::now())
            ->first();

            $visitors = DB::table('domains as d')
            ->where('d.id', $request->get('domain-id'))
            ->where('d.user_id', Auth::user()->id)
            ->join('hot_streaks as hs', 'hs.domain_id', '=', 'd.id')
            ->join('hot_streak_visitors as hsv', 'hsv.module_id', '=', 'hs.id')
            ->where('hsv.created_at', '<', \Carbon\Carbon::now())
            ->where('hsv.created_at', '>', \Carbon\Carbon::now()->subMonth())
            ->select('hsv.created_at as created_at', 'hsv.id', 'hsv.created_at', 'hs.shows','hs.id as hs_id', 'hsv.ip')
            ->orderBy('created_at', 'DESC')
            ->get();

            $traffic = []; 

            foreach ($visitors as $v_key => $v_value) {

                if (!isset($traffic[$v_value->hs_id])) {
                    $traffic[$v_value->hs_id] = [
                        'month' => ['visitors' => 0, 'shows' => 0],
                        'week'  => ['visitors' => 0, 'shows' => 0],
                        'day'   => ['visitors' => 0, 'shows' => 0],
                        'id'    => null
                    ];
                }

                if ($v_value->created_at > \Carbon\Carbon::now()->subMonth()) {
                    $traffic[$v_value->hs_id]['month']['visitors'] = $traffic[$v_value->hs_id]['month']['visitors'] + 1;     
                }
                if ($v_value->created_at > \Carbon\Carbon::now()->subWeek()) {
                    $traffic[$v_value->hs_id]['week']['visitors'] = $traffic[$v_value->hs_id]['week']['visitors'] + 1;      
                } 
                if ($v_value->created_at > \Carbon\Carbon::now()->subMinutes(1440)) {
                    $traffic[$v_value->hs_id]['day']['visitors'] = $traffic[$v_value->hs_id]['day']['visitors'] + 1;   
                } 
            }

            $shows = DB::table('domains as d')
            ->where('d.id', $request->get('domain-id'))
            ->where('d.user_id', Auth::user()->id)
            ->join('hot_streaks as hs', 'hs.domain_id', '=', 'd.id')
            ->join('hot_streak_shows as hss', 'hss.module_id', '=', 'hs.id')
            ->where('hss.created_at', '<', \Carbon\Carbon::now())
            ->where('hss.created_at', '>', \Carbon\Carbon::now()->subWeek())
            ->select('hss.created_at as created_at', 'hss.id', 'hss.created_at', 'hs.shows','hs.id as hs_id', 'hss.ip')
            ->orderBy('created_at', 'DESC')
            ->get();
            
            foreach ($shows as $s_key => $s_value) {

                if (!isset($traffic[$s_value->hs_id])) {
                    $traffic[$s_value->hs_id] = [
                        'month' => ['visitors' => 0, 'shows' => 0],
                        'week'  => ['visitors' => 0, 'shows' => 0],
                        'day'   => ['visitors' => 0, 'shows' => 0],
                        'id'    => null
                    ];
                }

                if ($s_value->created_at > \Carbon\Carbon::now()->subMonth()) {
                    $traffic[$s_value->hs_id]['month']['shows'] = $traffic[$s_value->hs_id]['month']['shows'] + 1;
                }
                if ($s_value->created_at > \Carbon\Carbon::now()->subWeek()) {
                    $traffic[$s_value->hs_id]['week']['shows'] = $traffic[$s_value->hs_id]['week']['shows'] + 1;     
                } 
                if ($s_value->created_at > \Carbon\Carbon::now()->subMinutes(1440)) {
                    $traffic[$s_value->hs_id]['day']['shows'] = $traffic[$s_value->hs_id]['day']['shows'] + 1;
                } 
            }

            if ($purchased) {
                $purchase = [
                    'days' => $this->getDaysLeft($purchased),
                    'status' => $purchased->status,
                    'purchases_till' => $this->updateDate($purchased->purchases_till),
                ];
            } else {
                $purchase = false;
            }

            //print_r(DB::getQueryLog());

            return response()->json([
                'domain' => $ifDomainExist->d_created_at,
                'domain_settings' => $settings,
                'compaigns' => $compaigns,
                'activity' => $activity,
                'purchase' => $purchase,
                'traffic' => $traffic]);     
        }
    }
 
    public function getImage($obj)
    {
        $ifExist = DB::table('city_images')->where('cityName', $obj->city)->where('status', 1)->first();
        if ($ifExist) {
            return 'img/map/'.str_slug($ifExist->cityName).'-'.$ifExist->id.'.png';
        } else {
            return 'cdn/img/map.svg';
        }

    }

    public function filterForMonth($item)
    {
        echo gettype($item), "\n";
        //print_r($item);
        return $item;
        //print_r($item['shows']);
        //die;
        /*if ($item['created_at'] > \Carbon\Carbon::now()->subMinutes(1440)) {
            return false;
        } else {
            return true;
        }*/
    }

    private function getDaysLeft($object)
    {
        $end = \Carbon\Carbon::parse($object->purchases_till);
        $now = \Carbon\Carbon::now();
        $length = $end->diffInDays($now);
        return $length;
    }

    public function postStatus(Request $request)
    {
        $ifModuleExist = DB::table('hot_streaks')->where(['id' => $request->get('module-id'), 'user_id' => Auth::user()->id])->first();

        if ($ifModuleExist)
        {
            $current_status = ($ifModuleExist->status == 1 ? 0 : 1);

            HotStreaks::where('id', $request->get('module-id'))
            ->update(['status' => $current_status]);
        }
    }

    public function postDelete(Request $request)
    {
        $ifModuleExist = DB::table('hot_streaks')->where(['id' => $request->get('module-id'), 'user_id' => Auth::user()->id])->first();

        if ($ifModuleExist)
        {
            if ($ifModuleExist->deleted_at === null) {
                $now = \Carbon\Carbon::now();
                HotStreaks::where('id', $request->get('module-id'))
                ->update(['deleted_at' => $now, 'status' => 0]);
            }  else {
                HotStreaks::where('id', $request->get('module-id'))
                ->update(['deleted_at' => null, 'status' => 1]);
            }
        }

    }

    public function changeName(Request $request)
    {
        $all       = $request->all();       
        $url_piece = explode('/', $request->header()['referer'][0]);
        $id        = (is_int(intval($url_piece[count($url_piece) - 1])) ? intval($url_piece[count($url_piece) - 1]) : 0 );
        $domain    = Domains::where(['user_id' => Auth::user()->id, 'id' => $id])->exists();

        if ($domain) {
            Domains::where(['user_id' => Auth::user()->id, 'id' => $id])
            ->update(['name' => $all['name']]);

            return response()->json(['true']);     
        } else {
            return response()->json(['false']);       
        }
 
    }

    public function addPresets(Request $request)
    {
        $domain = Domains::find($request->get('domain_id'));

        if ($domain && $domain->user_id == Auth::user()->id) {
            $campaign = HotStreaks::where('domain_id', $domain->id)->count();
            if ($campaign > 0) {
                return 'false';
            }
        } else {
            return 'false';
        }
 
        $ip       = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR'));
        $position = Location::get($ip);
        $cities   = 'Paris;Dubai;New York;Singapore;Cape Town;Boston;Atlanta;Dallas;Orlando;Chennai;Edinburgh;Santiago;Moscow;';
 
        if ($position !== false) {
            //$position->countryCode
            switch ($position->countryCode) {
                case 'US';
                    $cities = 'New York;Los Angeles;Chicago;Houston;Phoenix;Philadelphia;San Antonio;San Diego;Dallas;San Jose;';
                    break;
                case 'CA':
                    $cities = 'Toronto;Montreal;Vancouver;Calgary;Edmonton;Ottawa;Quebec;Winnipeg;Hamilton;';
                    break;
                case 'IN':
                    $cities = 'Mumbai;New Delhi;Kolkata;Chennai;Bangalore;Hyderabad;Jaipur;Ahmedabad;Pune;Surat;';
                    break;      
                case 'TR':
                    $cities = 'Istanbul;Ankara;İzmir;Bursa;Adana;Gaziantep;Konya;Antalya;Kayseri;Mersin;';
                    break;    
            }      
        } else {
 
        }   

        $data = Array (
            'campaign_name' => 'Recently signed up',
            'message'       => 'Recently signed up',
            'conversions'   => '30',
            'days'          => '7',
            'show_conversions' => 'no',
            'capture'     => $domain->url.'/;',
            'display'     => '',
            'send_to_url' => '',
            'open_new'  => 'off',
            'domain_id' => $request->get('domain_id'),
            'translate_someone' => null,
            'translate_from'    => null,
            'locale'      => 'en',
            'fake'        => 'yes',
            'fake_city'   => $cities,
            'fake_locale' => '40;m;70;m',
            'show_main'   => 'no',
            'show_all'    => 'yes',
        );

        $data2                  = $data;
        $data2['campaign_name'] = 'Recently sent callback request';
        $data2['message']       = 'Recently sent callback request';

        $comp_1 = new \App\Modules\Domains\Controllers\HotStreakController;
        $comp_1->postAdd($request, $data);
        $comp_1->postAdd($request, $data2);       
        
        return 'true';

    }
    public function putSettings(Request $request)
    {
        $all     = $request->all();  
        $user_id = Auth::user()->id;
        $domain  = Domains::where(['user_id' => $user_id, 'id' => $all['domain-id']])->exists();   
        //field == 'hide_notifications' || field == 'show_on_top' || field == 'position'
        if ($domain && ($all['field'] == 'overall-notification' || 
                        $all['field'] == 'hide_notifications' || 
                        $all['field'] == 'show_on_top' || 
                        $all['field'] == 'spacing_between' || 
                        $all['field'] == 'locale' || 
                        $all['field'] == 'position')) {

            switch ($all['field']) {
                case 'overall-notification':
                    $field = 'viewing_this_page';
                    break;
                case 'hide_notifications':
                    $field = 'hide_notifications';
                    break;
                 case 'show_on_top':
                    $field = 'show_on_top';
                    break;
                case 'position':
                    $field = 'position';
                    break;               
                case 'spacing_between':
                    $field = 'spacing_between';
                    break;
                case 'locale':
                    $field = 'locale';
                    break;        
                default:
                    return 'false';
                    break;
            }


            DomainSettings::where('domain_id', $all['domain-id'])
            ->update([
                $field => $all['value'],                     
            ]);

            echo $field . ' - ' . $all['value'];
            return 'success';
        }   
    }


    public function updateSettings(Request $request)
    {
        $all     = $request->all();  
        $user_id = Auth::user()->id;
        $domain  = Domains::where(['user_id' => $user_id, 'id' => $all['domain_id']])->exists();
        
        if ($domain) {

            $validator = Validator::make($request->all(), [
                'hide_notifications' => 'required',
                'show_on_top'        => 'required',
                'position'           => 'required',
                'spacing_between'    => 'required',
                'viewing_this_page'  => 'required',     
                'locale'             => 'required',                       
            ]);

            if ($validator->fails()) {
                print_r($validator->errors());
                echo 'fail';
            } else {
                DomainSettings::where('domain_id', $all['domain_id'])
                ->update([
                    'hide_notifications'  => $all['hide_notifications'],
                    'show_on_top'         => $all['show_on_top'],
                    'position'            => $all['position'],
                    'locale'              => $all['locale'],          
                    'spacing_between'     => $all['spacing_between'],  
                    'viewing_this_page'   => $all['viewing_this_page'],                     
                ]);
            }

        }

    }

}
