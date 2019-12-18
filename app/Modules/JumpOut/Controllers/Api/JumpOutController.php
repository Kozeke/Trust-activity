<?php namespace App\Modules\JumpOut\Controllers\Api;

use App\Modules\Domains\Models\Domains;
use App\Modules\Domains\Models\DomainSettings;
use Illuminate\Http\Request;
use Session;
use App\JumpOutTemplates;
use App\JumpOutGallery;
use App\JumpOutCompany;
use App\JumpOutDisplay;
use App\Modules\JumpOut\Models\jumpOutActivity;
use Auth;
use DB;
 

class JumpOutController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $previous_page = '';



    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }
 
    public function getList(Request $request) {

        $ifDomainExist = Domains::where(['id' => $request->get('domain-id'), 'user_id' => Auth::user()->id])->first();
        
        if ($ifDomainExist) {

            $ifDomainExist->d_created_at = $this->updateDate($ifDomainExist->created_at);
            $settings = DomainSettings::where('domain_id', $request->get('domain-id'))->first();

            $compaigns = DB::table('domains as d')
            ->where('d.id', $request->get('domain-id'))
            ->where('d.user_id', Auth::user()->id)
            ->join('jump_out_companies as joc', 'joc.domain_id', '=', 'd.id')
            ->join('jump_out_templates as jot', 'joc.template_id', '=', 'jot.id')
            ->orderBy('joc.id', 'DESC')
            ->select('jot.data', 'joc.created_at', 'joc.deleted_at', 'joc.domain_id', 'joc.id', 'joc.name', 'joc.status', 'joc.updated_at', 'd.url', 'joc.user_id') 
            ->get();

            foreach ($compaigns as $key => $value) {
                
                $value->modified_at = $this->updateDate($value->updated_at);
                $value->data        = unserialize($value->data);   

                if ($value->deleted_at !== null) { 
                    $value->deleted = true; 
                    $startTime      = \Carbon\Carbon::createFromTimeStamp(strtotime($value->deleted_at))->addHour(24);
                    $finishTime     = \Carbon\Carbon::now();
                    $totalDuration  = $finishTime->diffInSeconds($startTime);
                    $value->deleted_left = gmdate('H:i', $totalDuration);
                }
            }            

            $visitors = DB::table('domains as d')
            ->where('d.id', $request->get('domain-id'))
            ->where('d.user_id', Auth::user()->id)
            ->join('jump_out_companies as joc', 'joc.domain_id', '=', 'd.id')
            ->join('jump_out_activities as joa', 'joa.module_id', '=', 'joc.id')
            ->where('joa.created_at', '<', \Carbon\Carbon::now())
            ->where('joa.created_at', '>', \Carbon\Carbon::now()->subMonth())
            ->select('joa.created_at as created_at', 'joa.id', 'joa.created_at','joc.id as hs_id', 'joa.ip', 'joa.activity')
            ->orderBy('created_at', 'DESC')
            ->get();

            $traffic = []; 

            foreach ($visitors as $v_key => $v_value) {
                
                if (!isset($traffic[$v_value->hs_id])) {
                    $traffic[$v_value->hs_id] = [
                        'month' => ['close' => 0, 'action' => 0, 'summ' => 0, 'ctr' => 0],
                        'week'  => ['close' => 0, 'action' => 0, 'summ' => 0, 'ctr' => 0],
                        'day'   => ['close' => 0, 'action' => 0, 'summ' => 0, 'ctr' => 0],
                    ];   
                }

                $type = ($v_value->activity == 'action' ? 'action' : 'close');
                $add  = 0;
                $time = '';

                if ($v_value->created_at > \Carbon\Carbon::now()->subMonth()) {
                    $add  = 1;
                    $time = 'month';
                }

                if ($v_value->created_at > \Carbon\Carbon::now()->subWeek()) {
                    $add = 1;
                    $time = 'week';
                }

                if ($v_value->created_at > \Carbon\Carbon::now()->subMinutes(1440)) {
                    $add = 1;
                    $time = 'day';
                }

                if ($add == 1) {
                    $traffic[$v_value->hs_id][$time][$type]  = $traffic[$v_value->hs_id][$time][$type] + 1;     
                    $traffic[$v_value->hs_id][$time]['summ'] = $traffic[$v_value->hs_id][$time]['summ'] + 1;    
                }

            }

            foreach ($traffic as $t_key => $t_value) {
                foreach ($t_value as $tt_key => $tt_value) {
                    if ($traffic[$t_key][$tt_key]['summ'] > 0) {
                        $traffic[$t_key][$tt_key]['ctr'] = round(($traffic[$t_key][$tt_key]['action'] * 100) / $traffic[$t_key][$tt_key]['summ'], 1);                         
                    }
                }
            }

            return response()->json([
                'domain'          => $ifDomainExist->d_created_at,
                'domain_settings' => $settings, 
                'compaigns'       => $compaigns,
                'traffic'         => $traffic,
            ]);
        } else {
            return response()->json(['error']);
        }
    }

    public function saveTemp(Request $request) {

        $data = $request->input('data');

        if (Session::has('jumpout_create')) {
            // get data
            $current_data = Session::get('jumpout_create');
            // set new data
            $current_data['name']  = $data['name'];
            $current_data['queue'] = $data['queue'];         
            $current_data['step'] = 2;
            /// update
            Session::put('jumpout_create', $current_data); 
            // return successful request
            return 'updated';
        } if (Session::has('jumpout_edit')) {
            // get data
            $current_data = Session::get('jumpout_edit');
            // set new data
            $current_data['name'] = $data['name'];
            $current_data['queue'] = $data['queue'];
            $current_data['step'] = 2;
            /// update
            Session::put('jumpout_edit', $current_data); 
            // return successful request
            return 'updated';
        } else {
            return 'error';
        }
    }

    public function storeRedactor(Request $request) {

        $data = $request->input('data');
        $type = ($data['type'] == 'create' ? 'jumpout_create': 'jumpout_edit');
 
        if (Session::has($type)) {
            // get data
            $current_data = Session::get($type);
            // set new data
            $current_data['step']     = 2;
            $current_data['template'] = $this->updateStylesType($data);
            /// update
            Session::put($type, $current_data); 
            // return successful request
            return 'updated';
            //print_r($current_data);
        } else {
            $current_data['step']     = 2;
            $current_data['template'] = $this->updateStylesType($data);
            Session::put($type, $current_data); 
            return 'updated';
        }
    }   
 
    public function storeTemplate(Request $request) {
        
        $data = $request->input('data');

        $template = new JumpOutTemplates;
        $template->name = 'none';
        $template->data = serialize($data);
        $template->base = 0;
        $template->save();

        $gallery              = new JumpOutGallery;
        $gallery->user_id     = Auth::user()->id;
        $gallery->template_id = $template->id;
        $gallery->save();

        return 'success';
    }

    public function loadTemplate(Request $request) {

        $module_id = $request->input('module_id');
        if (Session::has('jumpout_edit')) {
            $data = Session::get('jumpout_edit');
        } else {
            $module   = JumpOutCompany::find($module_id);
            $template = $module->getTemplate($module->template_id);
            $data = [
                'step' => 1,
                'name' => $module->name,
                'template' => $template 
            ];
        }   
        
        $data['template'] = $this->JsStylesType($data['template']);

        return $data;
    }

    private function updateStylesType($data)
    {   
        if (isset($data['elements'])) {
            foreach ($data['elements'] as $e_key => $element) {
                $styles = [];
                foreach($element['styles'] as $s_key => $style) {
                    if ($style != '') {
                        switch ($s_key) {
                            case 'font_type':
                                $new_key = 'font-family';
                                break;
                            case 'font_color':
                                $new_key = 'color';
                                break;                
                            default:
                                $new_key = str_replace('_', '-', $s_key);
                                break;
                        }
                        $styles[$new_key] = $style;
                    }
                }

                $data['elements'][$e_key]['styles'] = $styles;
            }            
        }
 
        return $data;
    }

    private function JsStylesType($data)
    {
        foreach ($data['elements'] as $e_key => $element) {
            $styles = [];
            foreach($element['styles'] as $s_key => $style) {
                if ($style != '') {
                    switch ($s_key) {
                        case 'font-family':
                            $new_key = 'font_type';
                            break;
                        case 'color':
                            $new_key = 'font_color';
                            break;                
                        default:
                            $new_key = str_replace('-', '_', $s_key);
                            break;
                    }
                    $styles[$new_key] = $style;
                }
            }

            $data['elements'][$e_key]['styles'] = $styles;
        }

        return $data;
    }

    public function getUserGallery() {
        
        $templates = [];

        $query = JumpOutGallery::where('user_id', Auth::user()->id)
        ->join('jump_out_templates', 'jump_out_galleries.template_id', '=', 'jump_out_templates.id')
        ->select('jump_out_templates.data')
        ->get();

        foreach ($query as $key => $value) {
            array_push($templates, unserialize($value->data));
        }

        return response()->json($templates);
 
    }

    public function storeCompany(Request $request) {

        $data = $request->input('data');

        if ($data['type'] == 'create') {
            return $this->addCompany($data);
        } else if ($data['type'] == 'edit') {
            return $this->editCompany($data);
        } else {
            return '404';
        }
    }

    public function addCompany($data) {
 
        if (Session::has('jumpout_create') && isset($data['name']) && isset($data['display']) && isset($data['priority'])) {

            $session_data   = Session::get('jumpout_create');
    
            $template       = new JumpOutTemplates;
            $template->name = 'none';
            $template->data = serialize($session_data['template']);
            $template->base = 1;
            $template->save();

            $company              = new JumpOutCompany;
            $company->name        = $data['name'];
            $company->domain_id   = $data['domain_id'];
            $company->priority    = $data['priority'];    
            $company->show_all    = $data['show_all'];    
            $company->show_main   = $data['show_main'];                
            $company->user_id     = Auth::user()->id;
            $company->template_id = $template->id;
            $company->save();

            $display_links = explode(';', $data['display']);
            $display_arr = [];

            foreach ($display_links as $key => $value) {
                if ($value != '') {
                    $value = trim($value);
                    $value = str_replace(' ', '-', $value);
                    $display = new JumpOutDisplay();
                    $display->url = $value;                   
                    $display->module_id = $company->id;
                    $display->save();
                }
            }

            return 'updated';

        } else {

            return '404';
        }
    }

    public function editCompany($data) {

        if (Session::has('jumpout_edit') && isset($data['name']) && isset($data['module_id'])) {

            $session_data   = Session::get('jumpout_edit');
            $template       = new JumpOutTemplates;
            $template->name = 'none';
            $template->data = serialize($session_data['template']);
            $template->base = 1;
            $template->save();

            $company = JumpOutCompany::find($data['module_id']);

            if ($company->user_id == Auth::user()->id)
            {
                $company->name        = $data['name'];
                $company->template_id = $template->id;
                $company->show_all    = $data['show_all'];    
                $company->show_main   = $data['show_main'];   
                $company->priority    = $data['priority'];             
                $company->save();

                JumpOutDisplay::where('module_id', $data['module_id'])->delete();

                $display_links = explode(';', $data['display']);
                $display_arr = [];

                foreach ($display_links as $key => $value) {
                    if ($value != '') {
                        $value = trim($value);
                        $value = str_replace(' ', '-', $value);
                        $display = new JumpOutDisplay();
                        $display->url = $value;                   
                        $display->module_id = $company->id;
                        $display->save();
                    }
                }

            } else {
                return '404';
            }
             
            return 'updated';
        } else {

            return '404';
        }
    }

    public function postStatus(Request $request)
    {
        $ifModuleExist = DB::table('jump_out_companies')->where(['id' => $request->get('module-id'), 'user_id' => Auth::user()->id])->first();

        if ($ifModuleExist)
        {
            $current_status = ($ifModuleExist->status == 1 ? 0 : 1);

            JumpOutCompany::where('id', $request->get('module-id'))
            ->update(['status' => $current_status]);
        }
    }

    public function delete(Request $request)
    {
        $ifModuleExist = DB::table('jump_out_companies')->where(['id' => $request->get('module-id'), 'user_id' => Auth::user()->id])->first();
 
        if ($ifModuleExist)
        {
            if ($ifModuleExist->deleted_at === null)
            {
                $now = \Carbon\Carbon::now();
                JumpOutCompany::where('id', $request->get('module-id'))
                ->update(['deleted_at' => $now, 'status' => 0]);
            }  else {
                JumpOutCompany::where('id', $request->get('module-id'))
                ->update(['deleted_at' => null, 'status' => 1]);
            }
        }
    }

    function removeUrlPrefix($url)
    {
        return str_replace(array('http://', 'https://', 'www.'), '', $url);
    }    

    public function storeActivity(Request $request) 
    {
        echo 'suc';
        die;
        $all = $request->all();

        if (null !== request()->headers->get('origin')) {
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
            ->join('jump_out_companies', 'jump_out_companies.domain_id', '=', 'domains.id')
            ->where('jump_out_companies.id', $all['company_id'])
            ->select('domains.*')
            ->first();

        if ($isExist) {

            $modules = DB::table('jump_out_companies')
                ->where('jump_out_companies.domain_id', $isExist->id)
                ->where('jump_out_companies.id', $all['company_id'])
                ->get();

            $ip = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR'));

            if ($modules) {
                $activity = new jumpOutActivity();
                $activity->module_id = $all['company_id'];
                $activity->activity  = ($all['value'] == 'action' ? 'action' : 'close');
                $activity->ip        = $ip;
                $activity->save();
                return response()->json('success');
            }
        }
    } 
}
