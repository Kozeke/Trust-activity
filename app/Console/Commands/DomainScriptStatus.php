<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
 
class DomainScriptStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:update_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check is installed';

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
		$this->updateStatus();
    }

    /**
	 * installedOnce
	 * 0 = no status
	 * 1 = installed once
	 * 2 = not installed 
	 * 3 = selected
    **/

	//update status if < 12h
	//send message if > 12h and no script

	protected function updateStatus()
	{
        $domains = DB::table('domains')
	        ->whereIn('installedOnce', [0,2])
	        ->where('created_at', '>=', \Carbon\Carbon::now()->subHours(12)->toDateTimeString())
	        ->get();

        DB::table('domains')
	        ->whereIn('installedOnce', [0,2])
	        ->where('created_at', '>=', \Carbon\Carbon::now()->subHours(12)->toDateTimeString())
	        ->update(['installedOnce' => 3]);

	    $installed_ids = [];

        foreach ($domains as $key => $value) {

            $isInstalled = $this->isScriptInstalled($value);

            if ($isInstalled == false) {
                $isActive = DB::table('hot_streak_shows')->where('domain_id', $value->id)->first();  
                //$isActive = DB::table('hot_streak_shows')->where('url', 'like', $domain->url.'%')->first();
                if ($isActive) {
                  $isInstalled = true;  
                }
            }

            if ($isInstalled) {
				DB::table('domains')->where('id', $value->id)->update(['installedOnce' => 1]);
                echo $value->url.' installed <br>';
            } else {
				DB::table('domains')->where('id', $value->id)->update(['installedOnce' => 0]);
                echo $value->url.' not installed <br>';
            }
        }
	}
  
    protected function isScriptInstalled($domain)
    {
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
 
        $html = curl_exec($c);
        if (curl_error($c)) {
            return false;
        }

        $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c); 
        $mystring = $html;
        $findme   = $domain->hash_key;
        $pos      = strpos($mystring, $findme);

        return ($pos !== false ? true : false);
    }
 
}
