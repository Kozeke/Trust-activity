<?php namespace App\Modules\JumpOut\Controllers;

use App\Modules\Domains\Models\Domains;
use Validator, Auth, Hash, DB, Session;
use App\JumpOutCompany;
use App\JumpOutDisplay;

class JumpOutController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $previous_page = '';
    private $current_data  = ['step' => 1];


    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function getList($id)
    {
        $domain = Domains::where(['user_id' => Auth::user()->id, 'id' => $id])->first();
 
        return view('JumpOut::item')->with(['domains' => $this->domains, 'domain' => $domain, 'timezones' => $this->timezones()]);    
    }

    public function checkFromSource()
    {
        $this->previous_page = str_replace(secure_url('/'), '', url()->previous());
    }
 
    public function getAdd($id)
    {
        if (Session::has('jumpout_create')) {
            $this->checkFromSource(); 
            if ($this->previous_page == '/admin/domains/'.$id.'/jumpout/redactor' || $this->previous_page == '/admin/domains/'.$id.'/jumpout/add') {
                $this->current_data = Session::get('jumpout_create');
            }  else {
                Session::put('jumpout_create', array());    
            }

        } else {
            Session::put('jumpout_create', array());
        }

        if (isset($this->current_data['template'])) {
            $this->current_data['template'] = $this->updateTemplateStyles($this->current_data['template']);
        }
        
        $domain = Domains::find($id);
        return view('JumpOut::add')->with(['domains' => $this->domains, 'id' => $id, 'domain' => $domain, 'data' => $this->current_data]);   
    }

    public function getRedactor($id)
    {
        if (Session::has('jumpout_create')) {
            $domain = Domains::find($id);
            return view('JumpOut::redactor')->with(['domains' => $this->domains, 'id' => $id, 'domain' => $domain]);   
        } else {
            return redirect('/admin/domains/'.$id.'/jumpout');
        }
    }

    public function getEdit($domain_id, $module_id)
    {
        $domain = Domains::find($domain_id);
        $module = JumpOutCompany::find($module_id);    

        if (!$domain || !$module) {
            return abort(404);
        }

        $this->current_data['name']     = $module->name;
        $this->current_data['template'] = $module->getTemplate($module->template_id);
 
        if (Session::has('jumpout_edit')) {
            $this->checkFromSource(); 
            if ($this->previous_page == '/admin/domains/'.$domain_id.'/jumpout/'.$module_id.'/redactor') {
                $this->current_data = Session::get('jumpout_edit');
            }  else {
                Session::put('jumpout_edit', $this->current_data);    
            }

        } else {
            Session::put('jumpout_edit', $this->current_data);
        } 

        $this->current_data['template'] = $this->updateTemplateStyles($this->current_data['template']);
        $module->display = JumpOutDisplay::where('module_id', $module->id)->get();

        return view('JumpOut::edit')
        ->with(
            ['domains' => $this->domains,
             'id'      => $domain_id,
             'domain'  => $domain,
             'module'  => $module,
             'data'    => $this->current_data
            ]);   
    }
    // update data for CSS - append px / url and other 
    private function updateTemplateStyles($data)
    {
 
        foreach ($data['elements'] as $key => $element) {
            foreach ($element['styles'] as $key2 => $element2) {
                switch ($key2) {
                    case 'height':
                        $data['elements'][$key]['styles'][$key2] = $element2.'px';
                        break;
                    case 'background-image':
                        $data['elements'][$key]['styles'][$key2] = 'url('.$element2.')';
                        break;
                    case 'border-radius':
                        $data['elements'][$key]['styles'][$key2] = $element2.'px';
                        break;
                    case 'border-size':
                        $data['elements'][$key]['styles']['border-width'] = $element2.'px';
                        unset($data['elements'][$key]['styles'][$key2]);
                        break;
                }
            }
        }

        return $data;
    }

    public function getRedactorEdit($domain_id, $module_id)
    {
        if (Session::has('jumpout_edit')) {
            $domain = Domains::find($domain_id);
            return view('JumpOut::redactor')->with(['domains' => $this->domains, 'id' => $domain_id, 'domain' => $domain, 'module_id' => $module_id]);   
        } else {
            return redirect('/admin/domains/'.$id.'/jumpout');
        }
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
 
}
