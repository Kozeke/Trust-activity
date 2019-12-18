<?php namespace App\Modules\JumpOut\Controllers\Api;


use Illuminate\Http\Request;
use App\Modules\JumpOut\Models\jumpOutActivity;
use DB;

class PublicController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $previous_page = '';



    public function __construct()
    {
 
    }
  
    public function removeUrlPrefix($url) 
    {
        return str_replace(array('http://', 'https://', 'www.'), '', $url);
    } 

    public function storeActivity(Request $request) 
    {
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
