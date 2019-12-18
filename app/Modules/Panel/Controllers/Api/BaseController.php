<?php 

    namespace App\Modules\Panel\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request as Request;
use DB, Location, DateTime;

use App\Modules\Domains\Models\Domains;
use App\Modules\Domains\Models\DomainSettings;
use App\Modules\Domains\Models\HotStreaks;
use App\Modules\Domains\Models\hotStreakActivity;
use App\Modules\Domains\Models\HotStreakFake;
use App\Modules\Domains\Models\hotStreakVisitors;
use App\Modules\Domains\Models\HotStreakShows;
use App\Modules\Billing\Models\ModulePurchase;
use App\CityImage;
use App\JumpOutCompany;


class BaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $totalFakeBy24 = 0;

    public function __construct()
    { 
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // show users list
    private static function sortFunction( $a, $b ) {
        return $b - $a;
    }

    public function getBaseData(Request $request) 
    {
        $token     = $request->get('token');

        if(null !== request()->headers->get('origin')) {
            $host = $this->removeUrlPrefix(request()->headers->get('origin'));
        } else {
            $pieces = explode('/', $this->removeUrlPrefix($request->get('url')));
            $host = $pieces[0];
        }

        $referer   = $request->get('url');
        $postFrom  = $this->removeUrlPrefix($referer);  

        $campaigns = Domains::getNotificationCampaigns($token);
        $correct_host = false;

        if ($campaigns !== false && count($campaigns) > 0) {
            //массив компаний для поиска активности
            $campaign_object = [];
            //проходим все модули
            foreach ($campaigns as $key => $campaign) {
                // если на всех добавляем в массив по которому искать
                if ($host == $campaign->url) {
                    if ($campaign->show_all == 'yes') {
                        array_push($campaign_object, $campaign);
                        $correct_host = true;
                        // если на главной сравниваем главная ли - если да то добавляем
                    } else if ($campaign->show_main == 'yes' && $host.'/' == $postFrom) {
                        array_push($campaign_object, $campaign);
                        $correct_host = true;
                    } else {
                        $ifExist = Domains::DisplayUrlExist($token, $postFrom);
                        if ($ifExist) {
                            array_push($campaign_object, $campaign);
                            $correct_host = true;
                        }  
                        // надо проверять на совпадения уникальные урлов выбранные клиентов
                    } 
                    HotStreakShows::updateShow($referer, $request, $campaign->id, $campaign->domain_id);          
                    hotStreakVisitors::updateShow($referer, $request, $campaign->id);  
                }
            }
            // вытаскиваем модули и их активность?
            if ($correct_host == true) {
                $data             = $this->getActivity($campaign_object);
                $data['settings'] = DomainSettings::where('domain_id', $campaigns[0]->domain_id)->select('spacing_between', 'position', 'show_on_top', 'viewing_this_page', 'locale')->first();
                if($data['settings']['viewing_this_page'] == 'on') {
                    //$shows = HotStreakShows::where('url', $postFrom)->where('created_at', '>', \Carbon\Carbon::now()->subMinutes(1440)->toDateTimeString())->groupBy('module_id')->count();
                    $test = HotStreakShows::where('url', '=', $postFrom)->where('created_at', '>', \Carbon\Carbon::now()->subMinutes(1440)->toDateTimeString())->get();
                    $modules = [];

                    foreach ($test as $key => $value)  {
                        if(isset($modules[$value->module_id])) {  
                            $modules[$value->module_id] = $modules[$value->module_id] + 1;
                        } else {
                            $modules[$value->module_id] = 1;
                        }
                    }

                    usort($modules, array('App\Modules\Panel\Controllers\Api\BaseController','sortFunction'));
                    $first = array_shift($modules);
                    $first = $this->totalFakeBy24 + $first;

                    array_unshift($data['activity'], ["id" => 0, "type" => "per_page", "total" => $first, "fake" => $this->totalFakeBy24]);        
                }

                $jumpout = $this->getJumpOut($host,$postFrom, $token);
                $data['jumpout'] = $jumpout;

                return response()->json($data);  
            } else {
                return response()->json([]);  
            }

        } else {

            HotStreakShows::notInstalledShow($referer, $request, $token);    
            return response()->json([]);  
        }
    }

    private function updateTotalByFake($value)
    {
        if ($value->minutes_ago < 1440) {
            $this->totalFakeBy24++;            
        }
    }

    private function getActivity($campaign_object)
    {
        $over_all_activity = [];

        foreach ($campaign_object as $co_key => $campaign) {
 
            $activity = hotStreakActivity::where('hot_streak_id', $campaign->id)
                ->where('created_at', '>', \Carbon\Carbon::now()->subDays($campaign->days))
                ->orderBy('created_at', 'DESC')
                ->limit($campaign->conversions)
                ->select('id', 'email', 'gravatar_data' ,'created_at', 'city', 'city_code')  
                ->get();

            $activity = ($campaign->fake == 'yes' ? $this->fakeActivity($activity, $campaign) : $activity);

            foreach ($activity as $a_key => $value) {

                $value->image = $value->getImage($value);

                if($value->gravatar_data == '') {
                    $value->gravatar_data = $this->parseGravatar($value);
                    $val = hotStreakActivity::find($value->id);
                    $val->gravatar_data = serialize($this->parseGravatar($value));
                    $val->save();         
                } else {
                    $value->gravatar_data = unserialize($value->gravatar_data);
                } 

                \Carbon\Carbon::setLocale($campaign->locale);
                if ($value->email == "fake@fake.com" ) {
                    $value->created = \Carbon\Carbon::now()->subMinutes($value->minutes_ago)->diffForHumans();       
                } else { 
                    $value->created = \Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->diffForHumans();
                }

                //$value->email = 'hidden@hidden.com';
                $value->module_id  = $campaign->id;
                $value->module_key = $co_key;       

                array_push($over_all_activity, $value);
            } 

        }

        usort($over_all_activity, function($a, $b) {

            $ad = ($a['minutes_ago'] ? \Carbon\Carbon::now()->subMinutes($a['minutes_ago']) : $a['created_at']);
            $bd = ($b['minutes_ago'] ? \Carbon\Carbon::now()->subMinutes($b['minutes_ago']) : $b['created_at']);

            if ($ad == $bd) {
                return 0;
            }

            return $ad > $bd ? -1 : 1;
        });

        return ['activity' => $over_all_activity, 'data' => $campaign_object];
    }

    private function fakeActivity($activity, $object)
    {
        if ($object->conversions > count($activity)) {

            $fake_num      = $object->conversions - count($activity);
            $fake_activity = HotStreakFake::where('hot_streak_id', $object->id)
                ->limit($fake_num)
                ->orderBy('created_at', 'DESC')
                ->select()
                ->get();

            foreach ($fake_activity as $key => $value) {
                $this->updateTotalByFake($value);
                $activity->push($value);
            }
        }

        return $activity;
    }

    private function parseGravatar($object)
    {
        $hash = md5($object->email);
        //$hash = '548f565c357dfcdb271cfaa540b2f100';
        $str = @file_get_contents( 'https://www.gravatar.com/'.$hash.'.php' );
        $profile = unserialize( $str );
        if (is_array($profile) && isset($profile['entry'])) {
            $name = (isset($profile['entry'][0]['name']) ? $profile['entry'][0]['name'] : $profile['entry'][0]['preferredUsername']);
            $data = [
                'name' => $name,
                'thumbnailUrl' => $profile['entry'][0]['thumbnailUrl'],
            ];

            return $data;
        }

        return 'none';
    }

    function removeUrlPrefix($url)
    {
        return str_replace(array('http://', 'https://', 'www.'), '', $url);
    }

    public function postAcitvity(Request $request)
    {
        $all      = $request->all();

        if(null !== request()->headers->get('origin')) {
            $host = $this->removeUrlPrefix(request()->headers->get('origin'));
        } else {
            $pieces = explode('/', $this->removeUrlPrefix($request->get('url')));
            $host = $pieces[0];
        }

        $referer  = $request->get('url');
        $postFrom = $this->removeUrlPrefix($referer);  
        $msg      = 'failed';
 
        $isExist = DB::table('domains')
        ->where('hash_key', $all['token']) 
        ->join('hot_streaks', 'hot_streaks.domain_id', '=', 'domains.id')
        ->join('hot_streak_captures', 'hot_streak_captures.module_id', '=', 'hot_streaks.id')
        ->where('hot_streak_captures.url', $postFrom) 
        ->select('domains.*')
        ->first();

        if ($isExist) {

            $modules = DB::table('hot_streaks')
                ->where('hot_streaks.domain_id', $isExist->id)
                ->join('hot_streak_captures', 'hot_streak_captures.module_id', '=', 'hot_streaks.id')
                ->where('hot_streak_captures.url', $postFrom)
                ->get();

            $isPurchase = ModulePurchase::where('domain_id', $isExist->id)
                ->where('purchases_at', '<', \Carbon\Carbon::now())
                ->where('purchases_till', '>', \Carbon\Carbon::now())
                ->where('status', 1)
                ->first();    

            if (count($modules) > 0 && $isPurchase) {
 
                foreach ($modules as $key => $value) {

                    $ip = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR'));
                    $position        = Location::get($ip);
                    $ifActivityExist = hotStreakActivity::where(['email' => $all['value'],'hot_streak_id' => $value->module_id])->orderBy('id', 'DESC')->first(); 
                     
                    if ($ifActivityExist && isset($position->cityName) && isset($position->countryCode)) {

                        if (strtotime($ifActivityExist['created_at']) < strtotime('-1 days')) {
                            // add
                            $this->addCityImage($position);
                            
                            $activity        = new hotStreakActivity(); 
                            $activity->email = $all['value'];
                            $activity->ip    = $ip;
                            $activity->gravatar_data = '';
                            $activity->hot_streak_id = $value->module_id; 
                            $activity->city          = $position->cityName;
                            $activity->city_code     = $position->countryCode;
                            $activity->save();  

                            $msg = 'success';
                        } else {
                            //not older
                        }

                    } else if ($all['value'] && isset($position->cityName) && isset($position->countryCode)) {
                        // add
                        if (!isset($position->cityName) || (isset($position->cityName) && $position->cityName == '')) { $position = $this->getLocationFromOtherApi($value->ip); } 
                        $this->addCityImage($position);
                        
                        $activity        = new hotStreakActivity(); 
                        $activity->email = $all['value'];
                        $activity->ip    = $ip;
                        $activity->gravatar_data = '';
                        $activity->hot_streak_id = $value->module_id; 
                        $activity->city          = $position->cityName;
                        $activity->city_code     = $position->countryCode;
                        $activity->save();  

                        $msg = 'success';
                    } else {
                        $msg = 'empty email';
                    }

                }

                return response()->json([$msg]);   
            }

            return response()->json(['failed']);   

        }

        return response()->json(['failed']);   
    }

    public function addCityImage($position)
    {
        $ifExist = CityImage::where('cityName', $position->cityName)->first();
        if (!$ifExist)  {
            $city_image            = new CityImage();
            $city_image->cityName  = $position->cityName;
            $city_image->latitude  = $position->latitude;
            $city_image->longitude = $position->longitude;
            $city_image->status    = 0;             
            $city_image->save();              
        }
    }

    public function getLocationFromOtherApi($ip)
    {
        $json = file_get_contents('http://ip-api.com/json/'.$ip);
        $data = json_decode($json);

        return (object) [
            'countryName' => $data->country,
            'countryCode' => $data->countryCode,
            'regionName'  => $data->regionName,
            'cityName'    => $data->city,
            'latitude'    => $data->lat,          
            'longitude'   => $data->lon,                
        ];
    } 

    private function getJumpOut($host,$postFrom, $token)
    {
        $getJumpoutOnPage = JumpOutCompany::getCompany($host,$postFrom, $token);

        return $getJumpoutOnPage->original;
    }
}