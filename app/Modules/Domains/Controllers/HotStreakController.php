<?php namespace App\Modules\Domains\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use App\Modules\Domains\Models\Domains;
use App\Modules\Domains\Models\DomainSettings;
use App\Modules\Domains\Models\HotStreaks;
use App\Modules\Domains\Models\HotStreakFake;
use App\Modules\Domains\Models\HotStreakCapture;
use App\Modules\Domains\Models\HotStreakDisplay;

use Validator, Auth, DB;

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
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function showSettings($id)
    {
        $domain   = Domains::find($id);
        $settings = DomainSettings::where('domain_id', $domain->id)->first();
 
        return view('Domains::hot-streak.settings')->with(['domains' => $this->domains, 'id' => $id, 'domain' => $domain, 'settings' => $settings]); 
    }

 
    public function getAdd($id)
    {
        $domain = Domains::find($id);
        return view('Domains::hot-streak.add')->with(['domains' => $this->domains, 'id' => $id, 'domain' => $domain]);   
    }

    public function parseTime($module)
    {      
        if($module->fake_locale != '') {
            $time = explode(";", $module->fake_locale);
     
            $module->time_from      = $time[0];
            $module->time_from_type = $time[1];
            $module->time_to        = $time[2];
            $module->time_to_type   = $time[3];            
        }

        return $module;
    }

    public function getEdit($domain_id, $module_id)
    {
        //$domain = Domains::find($domain_id);
        //$module = HotStreaks::find($module_id);   
		
		$domain = Domains::where(['id' => $domain_id])->first();

        if(!$domain) { 
			return redirect('admin'); 		
		}
		
		$module = HotStreaks::where(['user_id' => Auth::user()->id, 'domain_id' => $domain_id, 'id' => $module_id])->first();
		
		if($module == null) {
			return redirect('admin'); 
		}
		
		$purchased_notification = DB::table('module_purchases as mp')
			->where('mp.domain_id', $domain_id)
			->whereIN('mp.module_plan_id', [1,2,3,4])  
			->where('mp.purchases_at', '<', \Carbon\Carbon::now())
			->where('mp.purchases_till', '>', \Carbon\Carbon::now())
			->join('module_plans as mpl', 'mpl.id', '=', 'mp.module_plan_id')
			->orderBy('mp.id', 'DESC')
			->select('mp.id as purchase_id', 'mpl.name', 'mpl.price_mo', 'mpl.visitors_mo', 'mp.status', 'mp.purchases_till')
			->first();

		if($purchased_notification == null) {
			return redirect('admin'); 
		}

        $module->fake_city = explode(';', $module->fake_city);
        $module = $this->parseTime($module);
 
        return view('Domains::hot-streak.edit')
        ->with(
            ['domains' => $this->domains,
             'id'      => $domain_id,
             'domain'  => $domain,
             'module'  => $module
            ]);   
    }

    public function postEdit(Request $request)    
    {
        if($request->get('show_all') == 'yes' || $request->get('show_main') == 'yes') {

        $rules = [
                'campaign_name'      => 'required', 
                'message'            => 'required|max:40',
                'capture'            => 'required', 
                'domain_id'          => 'required', 
                'module_id'          => 'required',
            ];
        } else {
            $rules = [
                'campaign_name'      => 'required', 
                'message'            => 'required|max:40',
                'capture'            => 'required', 
                'display'            => 'required', 
                'domain_id'          => 'required', 
                'module_id'          => 'required',
            ];            
        }


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

        } else {

            $this->addFake($request->all());
            $image = $this->addImage($request->get('photo'));

            $module                     = HotStreaks::find($request->get('module_id'));
            $module->name               = $request->get('campaign_name');        
            $module->message            = $request->get('message');
            $module->conversions        = $request->get('conversions');
            $module->days               = $request->get('days');
            $module->show_conversions   = $request->get('show_conversions');
            $module->send_to_url        = ($request->get('send_to_url') == '' ? null : $request->get('send_to_url'));                
            $module->open_new           = $request->get('open_new');    
            $module->user_id            = Auth::user()->id;
            $module->domain_id          = $request->get('domain_id');
            if ($image != 'custom' && $image != '') {
                $module->image              = $image;                   
            }
            $module->translate_from     = $request->get('translate_from');
            $module->translate_someone  = $request->get('translate_someone');
            $module->locale             = $request->get('locale');
            $module->fake               = $request->get('fake');
            $module->fake_city          = $request->get('fake_city');
            $module->fake_locale        = $request->get('fake_locale');
            $module->show_all           = $request->get('show_all');
            $module->show_main          = $request->get('show_main');
            $module->save();

            HotStreakCapture::where('module_id', $request->get('module_id'))->delete();

            $capture_links = explode(';', $request->get('capture'));
            $capture_arr = [];

            foreach ($capture_links as $key => $value) {
                if ($value != '') {
                    $value = trim($value);
                    $value = str_replace(' ', '-', $value);
                    $capture = new HotStreakCapture();
                    $capture->url = $value;                   
                    $capture->module_id = $module->id;
                    $capture->save();
                }
            }

            HotStreakDisplay::where('module_id', $request->get('module_id'))->delete();

            $display_links = explode(';', $request->get('display'));
            $display_arr = [];

            foreach ($display_links as $key => $value) {
                if ($value != '') {
                    $value = trim($value);
                    $value = str_replace(' ', '-', $value);
                    $display = new HotStreakDisplay();
                    $display->url = $value;                   
                    $display->module_id = $module->id;
                    $display->save();
                }
            }

            return 'success';
        } 

    }

    public function postAdd(Request $request, $custom = null)
    {
        $data = ($custom != null ? $custom : $request->all());  

        if($data['show_all'] == 'yes' || $data['show_main'] == 'yes') {
            $rules = [
                'campaign_name'      => 'required', 
                'message'            => 'required|max:40',
                'capture'            => 'required', 
                'domain_id'          => 'required', 
            ];
        } else {
            $rules = [
                'campaign_name'      => 'required', 
                'message'            => 'required|max:40',
                'capture'            => 'required', 
                'display'            => 'required', 
                'domain_id'          => 'required', 
            ];            
        }

        if ($custom == null) {
            $validator = Validator::make($data,  $rules);            
        }

        //$validator = Validator::make($request->all(),  $rules);
 
        if (isset($validator) && $validator->fails()) {
            //return redirect('/admin/domains/'.$id.'/hot-streaks/add')
                        //->withErrors($validator)
                        //->withInput();
        } else {

            $image = (isset($data['photo']) ? $this->addImage($data['photo']) : '');

            $module                     = new HotStreaks();
            $module->name               = $data['campaign_name'];        
            $module->message            = $data['message'];
            $module->conversions        = $data['conversions'];
            $module->days               = $data['days'];
            $module->show_conversions   = $data['show_conversions'];
            $module->send_to_url        = ($data['send_to_url'] == '' ? null : $data['send_to_url']);                
            $module->open_new           = $data['open_new'];
            //$module->hide_notifications = $data['hide_notifications'];
            //$module->show_on_top        = $data['show_on_top'];
            //$module->position           = $data['position'];
            //$module->spacing_between    = ($data['spacing_between'] == '' ? 30 : $data['spacing_between']);        
            $module->user_id            = Auth::user()->id;
            $module->domain_id          = $data['domain_id'];
            $module->image              = $image;   
            $module->translate_from     = $data['translate_from'];
            $module->translate_someone  = $data['translate_someone'];
            $module->locale             = $data['locale'];
            $module->fake               = $data['fake'];
            $module->fake_city          = $data['fake_city'];
            $module->fake_locale        = $data['fake_locale'];
            $module->show_all           = $data['show_all'];
            $module->show_main          = $data['show_main'];
            $module->save();

            //$data              = $request->all();
            $data['module_id'] = $module->id;
            $data['type']      = 'new';
            $this->addFake($data);

            $capture_links = explode(';', $data['capture']);
            $capture_arr = [];

            foreach ($capture_links as $key => $value) {
                if ($value != '') {
                    $value = trim($value);
                    $value = str_replace(' ', '-', $value);
                    $capture = new HotStreakCapture();
                    $capture->url = $value;                   
                    $capture->module_id = $module->id;
                    $capture->save();
                }
            }

            $display_links = explode(';', $data['display']);
            $display_arr = [];

            foreach ($display_links as $key => $value) {
                if ($value != '') {
                    $value = trim($value);
                    $value = str_replace(' ', '-', $value);
                    $display = new HotStreakDisplay();
                    $display->url = $value;                   
                    $display->module_id = $module->id;
                    $display->save();
                }
            }

            return 'success';
        }

    }

    private function addImage($file)
    {
        switch ($file) {
            case 'map':
                return 'map';
                break;
            case 'discount':
                return 'discount';
                break;
            case 'party':
                return 'party';
                break;
            case 'custom':
                return 'custom';
                break;
            default:
 
            $pos = strpos($file, ';base64');
 
            if ($pos !== false) {
                // add file return path
                //data:image/jpeg;base64
                //data:image/png;base64

                // Get canonicalized absolute pathname
                $folder_name = md5(Auth::user()->id);
                $path = base_path().'/public/users/'.$folder_name;
                // If it exist, check if it a directory
                if(!is_dir($path)) {
                    mkdir($path, 0755);
                }

                $file_name = uniqid(md5(Auth::user()->id.''.rand()), true);
                $file_name = substr($file_name, 0, 10);
                $type      = strpos($file, 'data:image/png;base64');
                if ($type !== false) {
                    $img = str_replace('data:image/png;base64,', '', $file);
                    $type = '.png';
                } else {
                    $img = str_replace('data:image/jpeg;base64,', '', $file);
                    $type = '.jpeg';
                }

                $img = str_replace(' ', '+', $img);
                $dataimg = base64_decode($img);
                $file = $path.'/'.$file_name.$type;                    
                $success = file_put_contents($file, $dataimg);
                //chmod($file, 0777);
                $this->resizeImage($file);

                return '/users/'.$folder_name.'/'.$file_name.$type; 

            } else {
                return 'map';
            }

            break;
        }
    }

    public function resizeImage($filename) {

        $original_info = getimagesize($filename);
        $original_w = $original_info[0];
        $original_h = $original_info[1];
        $mime       = $original_info['mime'];
 
        $edited = false;
        // получение нового размера
        list($width, $height) = getimagesize($filename);

        if ($original_w < 100 && $original_h >= 141) {
            $newwidth = 100;
            $newheight = ($original_h * 100) / $original_w;
            $edited = true;             
        } else if ($original_h < 141 && $original_w >= 100) {
            $newwidth = (141 * $original_w) / $original_h;
            $edited = true; 
            $newheight = 141;
        } else {
            $newwidth = 100;
            $newheight = ($original_h * 100) / $original_w; 
            $edited = true; 
        }

        if ($edited) {
            // загрузка
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            //image/png
            if($mime == 'image/png') {
                $source = imagecreatefrompng($filename);
            } else {
                $source = imagecreatefromjpeg($filename);
            }
            //imagecreatefromjpeg
            // изменение размера
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            // вывод
            if($mime == 'image/png') {
                imagepng($thumb, $filename);
            } else {
                imagejpeg($thumb, $filename);
            }
        }
    }

    private function addFake($all)
    {
        $module  =  HotStreaks::find($all['module_id']);

        $city_array = explode(';', $all['fake_city']);
        $max        = (count($city_array) > 2 ? count($city_array) - 2 : count($city_array) - 1);

        $minutes_current = 0;
        $minutes_from    = 0;
        $minutes_to      = 0;
        $all_object      = $this->parseTime((object) $all);

        if ($all_object->time_from_type == 'm') {
            $minutes_from = $all_object->time_from;
        } else if ($all_object->time_from_type == 'h') {
            $minutes_from = $all_object->time_from * 60;
        } else if ($all_object->time_from_type == 'd') {
            $minutes_from = $all_object->time_from * 1440;
        }

        if ($all_object->time_to_type == 'm') {
            $minutes_to = $all_object->time_to;
        } else if ($all_object->time_to_type == 'h') {
            $minutes_to = $all_object->time_to * 60;
        } else if ($all_object->time_to_type == 'd') {
            $minutes_to = $all_object->time_to * 1440;
        }
 
        if ($all['conversions'] > 50) { $all['conversions'] == 50; }
        if (($module->fake_city != $all['fake_city'] || $module->fake_locale != $all['fake_locale'] || $module->conversions != $all['conversions']) || (isset($all['type']) && $all['type'] == 'new')) {
 
            HotStreakFake::where('hot_streak_id', $all['module_id'])->delete();

            switch ($all['locale']) {
                case 'en':
                    $country = 'United States';
                    break;
                case 'ru':
                    $country = 'Russia';
                    break;
                case 'el':
                    $country = 'Greece';
                    break;
                case 'it':
                    $country = 'Italy';
                    break;     
                case 'de':
                    $country = 'Germany';
                    break;  
                case 'tr':
                    $country = 'Turkey';
                    break;                          
                default:
                    $country = 'United States';
                    break;
            }


            $name_m = \App\FakeNames::where(['type' => 'name', 'gender' => 'male', 'country' => $country])->limit($all['conversions'])->inRandomOrder()->get()->toArray();
            $name_f = \App\FakeNames::where(['type' => 'name', 'gender' => 'female', 'country' => $country])->limit($all['conversions'])->inRandomOrder()->get()->toArray();

            $surname_m = \App\FakeNames::where(['type' => 'surname', 'gender' => 'male', 'country' => $country])->limit($all['conversions'])->inRandomOrder()->get()->toArray();
            $surname_f = \App\FakeNames::where(['type' => 'surname', 'gender' => 'female', 'country' => $country])->limit($all['conversions'])->inRandomOrder()->get()->toArray();

            $current_gender = 'm';
     
            for ($i = 0; $i < $all['conversions']; $i++) {

                if (isset(${'name_'.$current_gender}[$i]['value'])) {
                    $name = ${'name_'.$current_gender}[$i]['value'];
                } else {
                    $index = $i % count(${'name_'.$current_gender});
                    $name  = ${'name_'.$current_gender}[$index]['value'];
                }

                if (isset(${'surname_'.$current_gender}[$i]['value'])) {
                    $surname = ${'surname_'.$current_gender}[$i]['value'];
                } else {
                    $index = $i % count(${'surname_'.$current_gender});
                    $surname = ${'surname_'.$current_gender}[$index]['value'];
                }
  
                $current_gender = ($current_gender == 'm' ? 'f' : 'm');
 
                $city_index      = rand(0, $max);
                $minutes_current = $minutes_current + rand($minutes_from , $minutes_to);

                $fake = new HotStreakFake();
                $fake->hot_streak_id = $all['module_id'];  
                $fake->email         = "fake@fake.com";
                $fake->ip            = "192.168.0.0";       
                $fake->city          = ($city_array[$city_index] == '' ? $city_array[0] : $city_array[$city_index]);
                $fake->city_code     = 'UK';      
                $fake->gravatar_data = 's:4:"none";';  
                $fake->minutes_ago   = $minutes_current;    
                $fake->name          = $name;
                $fake->surname       = $surname;            
                $fake->created_at    = \Carbon\Carbon::now()->subMinutes($minutes_current); 
                $fake->updated_at    = \Carbon\Carbon::now()->subMinutes($minutes_current); 
                $fake->save();
            }
 
        } else if($all['conversions'] > $module->conversions) {

            $total = $all['conversions'] - $module->conversions; 
            for ($i = 0; $i < $total; $i++) {

                $city_index      = rand(0, $max);
                $minutes_current = $minutes_current + rand($minutes_from , $minutes_to);

                $fake = new HotStreakFake();
                $fake->hot_streak_id = 1;  
                $fake->email         = "fake@fake.com";
                $fake->ip            = "192.168.0.0";       
                $fake->city          = $city_array[$city_index];
                $fake->city_code     = 'UK';      
                $fake->gravatar_data = 's:4:"none";';  
                $fake->minutes_ago   = $minutes_current;   
                $fake->created_at    = \Carbon\Carbon::now()->subMinutes($minutes_current); 
                $fake->updated_at    = \Carbon\Carbon::now()->subMinutes($minutes_current); 
                $fake->save();
            }
        }
    }

 
}
