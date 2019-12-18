<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\DomainStatus;
use App\DomainStatusUpdate;
use App\Modules\Domains\Models\Domains;
use App\Modules\Domains\Models\HotStreaks;
use App\Modules\Domains\Models\HotStreakShows;
use DB;

class SelectDomainToCheckInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:SelectDomainToCheckInstall';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        /*$domains = DB::table('domain_statuses')->get()
            ->where('updated_at', '>=', \Carbon\Carbon::now()->subMinutes(15)->toDateTimeString())
            ->get();*/
        /*$shows = DB::table('hot_streak_shows')->where('domain_id', null)->limit(50000)->get();

        foreach ($shows as $key => $value) {
            if ($value->module_id != 0) {
                $item = HotStreaks::where('id', $value->module_id)->first();
                if ($item) {
                    HotStreakShows::where('id', $value->id)->update(['domain_id' => $item->domain_id]);   
                    echo 'success '.$value->id.''.PHP_EOL;                 
                }  

            }*/ /*else {
                HotStreakShows::destroy($value->id);
                echo 'delete'.PHP_EOL;
            }*/
        //}

        //die;

        $domains = DB::table('domain_statuses')->get();

        foreach ($domains as $key => $value) {
            echo $value->domain_id.PHP_EOL;
            $domain      = Domains::find($value->domain_id);
            if (!$domain) { continue; }
            $ifExist = DomainStatusUpdate::where('domain_id', $value->domain_id)->first();
            if (!$ifExist) {
                $item = new DomainStatusUpdate();
                $item->domain_id = $value->domain_id;
                $item->status = 0;
                $item->save();
            }
            # code...
        }

        //
    }
}
