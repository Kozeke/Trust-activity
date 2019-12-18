<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\hotStreakVisitorsTemp;
use App\hotStreakVisitorsCount;


class HotstreakTempParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hotstreak:parse';
 
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
        $this->parseVisitors();
        //echo 'test';
        //
    }

    private function parseVisitors()
    {
        $visitors = DB::table('hot_streak_visitors')->where('created_at', '<', \Carbon\Carbon::now()->subMonth())->orderBy('id')->chunk(10000, function ($visitors) {
            foreach ($visitors as $visitor) {
                //echo $visitor->id.' / ';
                $count = DB::table('hot_streak_visitors_counts')->where('module_id', $visitor->module_id)->first();     

                if ($count === null) {
                    $cnt            = new hotStreakVisitorsCount();
                    $cnt->module_id = $visitor->module_id;
                    $cnt->total     = 1;
                    $cnt->save();
                } else {
                    DB::table('hot_streak_visitors_counts')->where('id', $count->id)->update(['total' => $count->total + 1]);
                }
 
                $temp             = new hotStreakVisitorsTemp();
                $temp->id         = $visitor->id;
                $temp->ip         = $visitor->ip;
                $temp->module_id  = $visitor->module_id;
                $temp->url        = $visitor->url;
                $temp->created_at = $visitor->created_at;       
                $temp->updated_at = $visitor->updated_at;                    
                $temp->save();
                
                DB::table('hot_streak_visitors')->where('id', '=', $visitor->id)->delete();
            }

            echo '10 000 done / ';
        });


    }
}
