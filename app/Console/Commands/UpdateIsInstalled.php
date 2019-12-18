<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\DomainStatus;
use App\DomainStatusUpdate;
use App\Modules\Domains\Models\Domains;
use DB;

class UpdateIsInstalled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:isInstalled';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update domain status';
 
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //DomainStatusUpdate::where('status', 1)->update(['status' => 0]);
        $list = DomainStatusUpdate::where('status', 0)->get();
        if (count($list) > 0) {
            DomainStatusUpdate::where('status', 0)->update(['status' => 1]);
            foreach ($list as $key => $value) {

                $domain      = Domains::find($value->domain_id);
                if (!$domain) { 
                    DB::table('domain_status_updates')->where('id', $value->id)->delete();
                    continue;
                }
                $isInstalled = UpdateIsInstalled::isScriptInstalled($domain);
                if ($isInstalled == false) {
                    if ($domain->acitivityFor24h($domain->id)) {
                        $isInstalled == true;
                    }
                } 

                if ($isInstalled) {
                    DomainStatus::where('domain_id', $value->domain_id)->update(['isInstalled' => 1]);
                } else {
                    DomainStatus::where('domain_id', $value->domain_id)->update(['isInstalled' => 0]); 
                } 

                DB::table('domain_status_updates')->where('id', $value->id)->delete();
                echo $value->id.PHP_EOL;

                //$item = DomainStatusUpdate::find($value->id);
                //$item->delete();
            }
        }
    }

    static public function returnLastActivityUrl($domain) {

        /*$url = DB::table('hot_streaks')
        //->where('domain_id', $domain->id)
        ->join('hot_streak_shows', 'hot_streak_shows.domain_id', '=', $domain->id)
        ->first();*/
        $url = DB::table('hot_streak_shows')
        ->where('domain_id', $domain->id)
        ->orderBy('id', 'DESC')
        ->first();

        if ($url) {
            return $url->url;
        } else {
            return $domain->url;      
        }
    }

    static public function isScriptInstalled($domain) {
        
        $url = UpdateIsInstalled::returnLastActivityUrl($domain);
        echo $url.PHP_EOL;

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

        $c = curl_init($url);
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
}
