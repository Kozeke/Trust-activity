<?php namespace App\Modules\Domains\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use App\Modules\Domains\Models\Domains;
use App\Modules\Domains\Models\DomainSettings;
use App\Modules\Domains\Models\HotStreaks;
use App\DomainStatus;
use App\User;
use Validator, Auth, Hash, DB;
use App\Modules\Billing\Models\ModulePurchase;

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
 
    public function postAdd(Request $request)
    {
        $inputs              = $request->all();
        $inputs['url_valid'] = $this->preValidateURL($inputs['url']);
        $inputs['url']       = (trim($inputs['url']) != '' ? $this->preValidateURL($inputs['url']) : $inputs['url']);
        //$inputs['url']       = (trim($inputs['url']) != '' ? 'https://'.$this->preValidateURL($inputs['url']) : $inputs['url']);
        
        //print_r($inputs['url']);
        Validator::extend('url_custom', function($attribute, $value, $parameters) {
          //$pattern_1 = "/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+.([A-Z0-9][A-Z0-9_-])$)(:(\d+))?\/?/i";
          $pattern_1 = "/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})*\/?$/";
          $pattern_2 = "/^(www)((\.[A-Z0-9][A-Z0-9_-]*)+.([A-Z0-9][A-Z0-9_-])$)(:(\d+))?\/?/i";    

          if (preg_match($pattern_1, $value) || preg_match($pattern_2, $value)) {
            return true;
          } else {
            return false;
          }
         });
 
        //$validator = Validator::make($inputs, [
        $validator = Validator::make($inputs, [
            'name' => 'required|unique:domains|min:3|max:255',
            'url' => 'required|unique:domains|min:3|max:255|url_custom',
            //'url' => 'required|unique:domains|min:3|max:255|regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);  
        } else {
 
            $favicon     = $this->getFavicon($request->get('url'));
            $pieces      = explode('/', $inputs['url_valid']);
            $pure_domain = $pieces[0];

            $domain          = new Domains();
            $domain->name    = $inputs['name'];
            $domain->url     = $pure_domain;        
            $domain->user_id = Auth::user()->id;
            $domain->favicon = $favicon;
            $domain->hash_key = Hash::make($inputs['name'].''.$inputs['url']);
            $domain->save();

            $domain_settings            = new DomainSettings();
            $domain_settings->domain_id = $domain->id;
            $domain_settings->locale = (isset($inputs['locale']) && ($inputs['locale'] == 'en' || $inputs['locale'] == 'ru') ? $inputs['locale'] : 'en');     
            $domain_settings->viewing_this_page = 'on';
            $domain_settings->spacing_between = 5;
            $domain_settings->save();

            $domain_status = new DomainStatus();
            $domain_status->user_id     = Auth::user()->id;
            $domain_status->domain_id   = $domain->id;
            $domain_status->isInstalled = 0;     
            $domain_status->save();

            // add trial purchase
            if (Auth::user()->trial == 1) {
                $purchase = new ModulePurchase();
                $purchase->domain_id      = $domain->id;
                $purchase->module_plan_id = 1;
                $purchase->purchases_at   = \Carbon\Carbon::now()->subMinutes(1);
                $purchase->purchases_till = \Carbon\Carbon::now()->addDays(7)->subMinutes(1);
                $purchase->save();

                $user = User::find(Auth::user()->id);
                $user->trial = 0;
                $user->save();
            }

            return response()->json(['success' => true, 'domain_id' => $domain->id]);  
        }
    }
 
    public function preValidateURL($url)
    {
      $url = str_replace('www.', '', $url);
      $url = str_replace('https://', '', $url);
      $url = str_replace('http://', '', $url);

      if (substr($url, -1) == '/') { $url = substr($url, 0, -1); }
 
      return $url;
    }

    public function validateDomain(Request $request)
    {
        $inputs = $request->all();
        $domain = Domains::where(['user_id' => Auth::user()->id, 'id' => $inputs['domain_id']])->first();
        $result = 'false';

        if($domain)
        {
          if(preg_match("@^http://@i",$inputs['url'])) {
            $inputs['url'] = preg_replace("@(http://)+@i",'http://',$inputs['url']);
          } else {
            $inputs['url'] = 'http://'.$inputs['url'];
          }

          $url_pieces = parse_url($inputs['url']);

          if(isset($url_pieces['path']))
          {
            if(isset($url_pieces['host']))
            {
              $mystring = $inputs['url'];
              $findme   = '.';
              $pos = strpos($mystring, $findme);
              if ($pos === false)
              {
                //точка не найдена
                //echo 'точка не найдена';
                $result = $domain->url.'/'.$request->get('url');
              } else {
                  //точка найдена
                  //echo 'точка найдена';
                  $mystring = strtolower($inputs['url']);
                  $findme   = strtolower($domain->url);
                  $pos = strpos($mystring, $findme);
                  if ($pos === false)
                  {
                    //echo 'домен не совпал';
                    return 'false'; 
                  } else {
                    //echo 'домен совпал';
                    $clear_url = str_replace("www.", "", $request->get('url'));
                    $clear_url = str_replace("https://", "", $clear_url);
                    $clear_url = str_replace("http://", "", $clear_url);
                    $result    = $clear_url;
                  }
              }

            } else {
              return 'false';
            }
          } else {

            if(isset($url_pieces['host']))
            {
              $mystring = $inputs['url'];
              $findme   = '.';
              $pos = strpos($mystring, $findme);
              if ($pos === false)
              {
                //точка не найдена
                //echo 'точка не найдена';
                $result = $domain->url.'/'.$request->get('url');
              } else {
                  //точка найдена
                  //echo 'точка найдена';
                  $mystring = strtolower($inputs['url']);
                  $findme   = strtolower($domain->url);

                  $pos = strpos($mystring, $findme);  
                  if ($pos === false)
                  {
                    return 'false'; 
                  } else {
                    $clear_url = str_replace("www.", "", $request->get('url'));
                    $clear_url = str_replace("https://", "", $clear_url);
                    $clear_url = str_replace("http://", "", $clear_url);
                    $result = $clear_url;
                  }
              }

            } else {
              return 'false';
            }
          }

 
          echo $result;
        }
    }

    public function postDelete(Request $request)
    {
        $ifModuleExist = DB::table('domains')->where(['id' => $request->get('id'), 'user_id' => Auth::user()->id])->first();

        if ($ifModuleExist)
        {
            if ($ifModuleExist->deleted_at === null) {
              echo 'null';
                $now = \Carbon\Carbon::now();
                Domains::where('id', $request->get('id'))
                ->update(['deleted_at' => $now]);
            }  else {
                echo 'not null';
                Domains::where('id', $request->get('id'))
                ->update(['deleted_at' => null]);
            }
        }

        /*$ifModuleExist = DB::table('hot_streaks')->where(['id' => $request->get('module-id'), 'user_id' => Auth::user()->id])->first();

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
        }*/

    }

    public function getFavicon($url)
    {
       $href = false;
       /*$ch = curl_init($url);
       curl_setopt($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       $content = curl_exec($ch);
       if (!empty($content))
       {
          $dom = new DOMDocument();
          @$dom->loadHTML($content);
          $items = $dom->getElementsByTagName('link');
          foreach ($items as $item)
          {
             $rel = $item->getAttribute('rel');
             if ($rel == 'icon' or $rel == 'shortcut icon')
             {
                $href = $item->getAttribute('href');
                break;
             }
          }
       }*/
       return $href;
    }

    public function getInstruction(Request $request)
    {
        $inputs = $request->all(); 
        $inputs['type'];

        $article = DB::table('faq_categories')
        ->where('name', 'Integrations')
        ->join('faqs', 'faqs.category_id', '=', 'faq_categories.id')
        ->where('faqs.title', 'LIKE', '%'.$inputs['type'].'%')
        ->OrWhere('faqs.title', 'LIKE', '%'.ucfirst($inputs['type']).'%')
        ->select('faqs.content', 'faqs.title', 'faqs.description')
        ->first();
 
        return response()->json(['success' => true, 'article' => $article]); 
    }

    public function getInstallStatus(Request $request)
    {
        $inputs = $request->all(); 
        $domain = Domains::where(['user_id' => Auth::user()->id, 'id' => $inputs['id']])->first();
        if(!$domain) { return 'false'; }
        $isInstalled = \App\Modules\Domains\Controllers\DomainsController::isScriptInstalled($domain);

        if ($isInstalled == false) {
            $isActive = DB::table('hot_streak_shows')->where('domain_id', $domain->id)->first();  
            //$isActive = DB::table('hot_streak_shows')->where('url', 'like', $domain->url.'%')->first();
            if ($isActive) {
              $isInstalled = true;  
            }
        }

        if ($isInstalled == true) {
          Domains::where('id', $domain->id)->update(['installedOnce' => 1]);
          DomainStatus::where('domain_id', $domain->id)->update(['isInstalled' => 1]);      
        } 

        return response()->json(['status' => $isInstalled]); 
    }
  
}
