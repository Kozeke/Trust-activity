<?php namespace App\Modules\Domains\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use App\Modules\Domains\Models\Domains;
use App\Modules\Domains\Models\HotStreaks;
use App\Modules\Domains\Models\hotStreakActivity;

use Validator, Auth, Hash, DB;

class DomainsController extends \App\Modules\Panel\Controllers\AbstractController
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
        $all_domains = Domains::where('user_id', Auth::user()->id)->orderBy('id')->get();
        if (count($all_domains) == 0) { return redirect('admin'); }

        foreach ($all_domains as $key => $value) { 

            $value->created     = \Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->format('F d, Y'); 
            //$value->modified_at = \Carbon\Carbon::createFromTimeStamp(strtotime($value->hs_updated_at))->format('m/d/Y g:i A'); 
            $value->modified_at = \Carbon\Carbon::createFromTimeStamp(strtotime($value->hs_updated_at))->format('M d, Y g:i A'); 
            $value->isActive    = $value->acitivityFor24h($value->id);

            if ($value->deleted_at !== null) { 

                $value->deleted = true; 
                $startTime      = \Carbon\Carbon::createFromTimeStamp(strtotime($value->deleted_at))->addHour(24);
                $finishTime     = \Carbon\Carbon::now();
                $totalDuration  = $finishTime->diffInSeconds($startTime);
                $value->deleted_left = gmdate('H:i', $totalDuration);
            }
        }
 
        return view('Domains::index')->with(['domains' => $this->domains, 'list' => $all_domains, 'translate' => $this->translate]);   
    }
 
    public function postAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:domains|min:3|max:255',
            'url' => 'required|unique:domains|min:3|max:255|regex:/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/',
        ]);

        // get domain favicon
        //http://www.google.com/s2/favicons?domain=www.01tour.ru

        if ($validator->fails()) {
            return redirect('admin/domains/add')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $domain          = new Domains();
            $domain->name    = $request->get('name');
            $domain->url     = $request->get('url');
            $domain->user_id = Auth::user()->id;
            $domain->hash_key = Hash::make($request->get('name').''.$request->get('url'));
            $domain->save();

            return redirect('admin');
        }
    }

    public function getItem($id)
    {
 
        $domain = Domains::where(['user_id' => Auth::user()->id, 'id' => $id])->first();

        if(!$domain) { return redirect('admin'); }
        if ($domain->installedOnce != 1) { return view('Domains::item_uninstalled')->with(['domains' => $this->domains, 'domain' => $domain ]); }

        $this->deleteModules($id);
        $hotStreaks  = HotStreaks::where(['user_id' => Auth::user()->id, 'domain_id' => $id])->get();
        //$isInstalled = DomainsController::isScriptInstalled($domain);
        //if ($isInstalled == false) {
            if ($domain->acitivityFor24h($domain->id)) {
                $isInstalled = true;
            }  else {
                $isInstalled = DomainsController::isScriptInstalled($domain);
            }
        //}
        $domain->isInstalled = $isInstalled;
        //$domain->isInstalled = $domain->acitivityFor24h($domain->id);

        if ($domain->deleted_at !== null) { 
            $domain->deleted = true; 
            $startTime      = \Carbon\Carbon::createFromTimeStamp(strtotime($domain->deleted_at))->addHour(24);
            $finishTime     = \Carbon\Carbon::now();
            $totalDuration  = $finishTime->diffInSeconds($startTime);
            /*                    $hours = intval($totalMinutes/60);
            $minutes = $totalMinutes - ($hours * 60);*/
            $domain->deleted_left = gmdate('H:i', $totalDuration);
        }

        return view('Domains::item_new')->with(['domains' => $this->domains, 'domain' => $domain, 'hotStreaks' => $hotStreaks, 'timezones' => $this->timezones()]);    
    }

    public function timezones() {

        $data = [
                 ['val' => '-12', 'text' => 'UTC -12:00', 'city' => ' (Baker Island, Howland Island)'],
                 ['val' => '-11', 'text' => 'UTC -11:00', 'city' => ' (Jarvis Island, Kingman Reef, Midway Atoll, Palmyra Atoll)'],
                 ['val' => '-10', 'text' => 'UTC -10:00', 'city' => ' (Honolulu, Papeete)'],
                 ['val' => '-9,30', 'text' => 'UTC -9:30', 'city' => ' (Marquesas Islands)'],
                 ['val' => '-9', 'text' => 'UTC -9:00', 'city' => ' (Anchorage)'],
                 ['val' => '-8', 'text' => 'UTC -8:00', 'city' => ' (Los Angeles, Vancouver, Tijuana)'],
                 ['val' => '-7', 'text' => 'UTC -7:00', 'city' => ' (Phoenix, Calgary, Ciudad Juárez)'],
                 ['val' => '-6', 'text' => 'UTC -6:00', 'city' => ' (Chicago, Mexico City, Guatemala City, Tegucigalpa, Managua, Winnipeg, San José, San Salvador)'],
                 ['val' => '-5', 'text' => 'UTC -5:00', 'city' => ' (New York, Toronto, Havana, Lima, Bogotá, Kingston)'],
                 ['val' => '-4', 'text' => 'UTC -4:00', 'city' => ' (Santiago, Santo Domingo, Manaus, Caracas, La Paz, Asunción, Halifax)'],
                 ['val' => '-3,30', 'text' => 'UTC -3:30', 'city' => ' (Canada)'],
                 ['val' => '-3', 'text' => 'UTC -3:00', 'city' => ' (São Paulo, Buenos Aires, Montevideo)'],
                 ['val' => '-2', 'text' => 'UTC -2:00', 'city' => ' (Brazil, South Georgia and the South Sandwich Islands)'],
                 ['val' => '-1', 'text' => 'UTC -1:00', 'city' => ' (Cape Verde, Denmark, Portugal)'],
                 ['val' => '0', 'text' => 'UTC 0:00', 'city' => ' (London, Dublin, Lisbon, Accra, Dakar)'],
                 ['val' => '1', 'text' => 'UTC +1:00', 'city' => ' (Berlin, Rome, Paris, Madrid, Vienna, Warsaw, Lagos, Kinshasa, Luanda, Algiers, Casablanca)'],
                 ['val' => '2', 'text' => 'UTC +2:00', 'city' => ' (Cairo, Khartoum, Johannesburg, Kiev, Bucharest, Jerusalem, Athens, Kaliningrad)'],
                 ['val' => '3', 'text' => 'UTC +3:00', 'city' => ' (Moscow, Istanbul, Riyadh, Baghdad, Nairobi, Minsk, Doha)'],
                 ['val' => '3,30', 'text' => 'UTC +3:30', 'city' => ' (Tehran)'],
                 ['val' => '4', 'text' => 'UTC +4:00', 'city' => ' (Dubai, Baku, Samara)'],
                 ['val' => '4,30', 'text' => 'UTC +4:30', 'city' => ' (Kabul)'],
                 ['val' => '5', 'text' => 'UTC +5:00', 'city' => ' (Karachi, Tashkent, Yekaterinburg)'],
                 ['val' => '5,30', 'text' => 'UTC +5:30', 'city' => ' (Mumbai, Colombo)'],
                 ['val' => '5,45', 'text' => 'UTC +5:45', 'city' => ' (Kathmandu)'],
                 ['val' => '6', 'text' => 'UTC +6:00', 'city' => ' (Dhaka, Almaty, Omsk)'],
                 ['val' => '6,30', 'text' => 'UTC +6:30', 'city' => ' (Yangon)'],
                 ['val' => '7', 'text' => 'UTC +7:00', 'city' => ' (Jakarta, Bangkok, Ho Chi Minh City, Krasnoyarsk)'],
                 ['val' => '8', 'text' => 'UTC +8:00', 'city' => ' (Shanghai, Hong Kong, Kuala Lumpur, Singapore, Taipei, Perth, Manila, Makassar, Irkutsk)'],
                 ['val' => '8,45', 'text' => 'UTC +8:45', 'city' => ' (Eucla)'],
                 ['val' => '9', 'text' => 'UTC +9:00', 'city' => ' (Tokyo, Seoul, Pyongyang, Ambon, Yakutsk)'],
                 ['val' => '9,30', 'text' => 'UTC +9:30', 'city' => ' (Adelaide)'],
                 ['val' => '10', 'text' => 'UTC +10:00', 'city' => ' (Sydney, Port Moresby, Vladivostok)'],
                 ['val' => '10,30', 'text' => 'UTC +10:30', 'city' => ' (Lord Howe Island)'],
                 ['val' => '11', 'text' => 'UTC +11:00', 'city' => ' (Nouméa, Magadan)'],
                 ['val' => '12', 'text' => 'UTC +12:00', 'city' => ' (Auckland, Suva, Petropavlovsk-Kamchatsky)'],
                 ['val' => '12,45', 'text' => 'UTC +12:45', 'city' => ' (Chatham Islands)'],
                 ['val' => '13', 'text' => 'UTC +13:00', 'city' => ' (Phoenix Islands, Tokelau, Samoa, Tonga) '],
                 ['val' => '14', 'text' => 'UTC +14:00', 'city' => ' (Line Islands)']
                ];
  
        return $data;
    }

    public function deleteModules($id) {

        $ifDomainExist = DB::table('domains')->where(['id' => $id, 'user_id' => Auth::user()->id])->exists();

        if ($ifDomainExist) {

            $compaigns = DB::table('domains as d')
            ->where('d.id', $id)
            ->where('d.user_id', Auth::user()->id)
            ->join('hot_streaks as hs', 'hs.domain_id', '=', 'd.id')
            ->where('hs.deleted_at', '!=', null)   
            ->select('hs.*')
            ->get();

            foreach ($compaigns as $key => $value) {
                if ($value->deleted_at !== null) { 
                    $startTime = \Carbon\Carbon::createFromTimeStamp(strtotime($value->deleted_at))->addHour(24);
                    $days_left = \Carbon\Carbon::now()->diff(\Carbon\Carbon::parse($startTime))->format('%d');
                    if($days_left > 0) {
                        HotStreaks::find($value->id)->delete();
                    }
                }
            }
        }
    }

    static public function isScriptInstalled($domain) {
 
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 30,      // timeout on connect
            CURLOPT_TIMEOUT        => 30,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false,    // Disabled SSL Cert checks
			CURLOPT_BINARYTRANSFER => true,
        );
        $c = curl_init($domain->url);
        curl_setopt_array($c, $options);

        /*curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);*/

        $html = curl_exec($c);
        if (curl_error($c)) {
            return false;
            //die(curl_error($c));
        }

        $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c); 
        $mystring = $html;
        $findme   = $domain->hash_key;
        $pos      = strpos($mystring, $findme);

        return ($pos !== false ? true : false);
    }

    public function getItemNew($id)
    {
 
        $domain = Domains::where(['user_id' => Auth::user()->id, 'id' => $id])->first();

        if(!$domain) { return redirect('admin'); }
        if ($domain->installedOnce != 1) { return view('Domains::item_uninstalled')->with(['domains' => $this->domains, 'domain' => $domain ]); }

        $this->deleteModules($id);
        $hotStreaks  = HotStreaks::where(['user_id' => Auth::user()->id, 'domain_id' => $id])->get();
        //$isInstalled = DomainsController::isScriptInstalled($domain);
        //if ($isInstalled == false) {
            if ($domain->acitivityFor24h($domain->id)) {
                $isInstalled = true;
            }  else {
                $isInstalled = DomainsController::isScriptInstalled($domain);
            }
        //}
        $domain->isInstalled = $isInstalled;
        //$domain->isInstalled = $domain->acitivityFor24h($domain->id);

        if ($domain->deleted_at !== null) { 
            $domain->deleted = true; 
            $startTime      = \Carbon\Carbon::createFromTimeStamp(strtotime($domain->deleted_at))->addHour(24);
            $finishTime     = \Carbon\Carbon::now();
            $totalDuration  = $finishTime->diffInSeconds($startTime);
            /*                    $hours = intval($totalMinutes/60);
            $minutes = $totalMinutes - ($hours * 60);*/
            $domain->deleted_left = gmdate('H:i', $totalDuration);
        }

        return view('Domains::item_new')->with(['domains' => $this->domains, 'domain' => $domain, 'hotStreaks' => $hotStreaks]);    
    }

}
