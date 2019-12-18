<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DomainCompanyDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:company_delete';

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
        echo 'Deleting...'.PHP_EOL;
        $this->delete();
        echo 'Deleting done!'.PHP_EOL;
        //
    }

    protected  function delete()
    {
        $companies = DB::table('hot_streaks')->where('deleted_at', '!=' , NULL)->get();

        foreach ($companies as $key => $value) {

            $now = \Carbon\Carbon::now();
            $diff = $now->diffInHours($value->deleted_at);

            if ($diff > 23) {
                //delete
                //echo  $value->name.' '. PHP_EOL;         

                //echo 'deleting hot_streak_visitors...'. PHP_EOL;
                DB::table('hot_streak_visitors')->where('module_id', '=', $value->id)->delete();
                //echo 'deleted hot_streak_visitors.'. PHP_EOL;
                //echo 'deleting hot_streak_shows...'. PHP_EOL;
                DB::table('hot_streak_shows')->where('module_id', '=' , $value->id)->delete();
                //echo 'deleted hot_streak_shows.'. PHP_EOL;
                //echo 'deleting hot_streak_fakes...'. PHP_EOL;
                DB::table('hot_streak_fakes')->where('hot_streak_id', '=' , $value->id)->delete();
                //echo 'deleted hot_streak_fakes.'. PHP_EOL;
                //echo 'deleting hot_streak_displays...'. PHP_EOL;
                DB::table('hot_streak_displays')->where('module_id', '=' , $value->id)->delete();
                //echo 'deleted hot_streak_displays.'. PHP_EOL;
                //echo 'deleting hot_streak_captures...'. PHP_EOL;
                DB::table('hot_streak_captures')->where('module_id', '=' , $value->id)->delete();
                //echo 'deleted hot_streak_captures.'. PHP_EOL;
                //echo 'deleting hot_streak_activities...'. PHP_EOL;
                DB::table('hot_streak_activities')->where('hot_streak_id', '=' , $value->id)->delete();
                //echo 'deleted hot_streak_activities.'. PHP_EOL;
                //echo 'deleting hot_streaks...'. PHP_EOL;
                DB::table('hot_streaks')->where('id', '=' , $value->id)->delete();
                //echo 'deleted hot_streaks.'. PHP_EOL;

                //echo 'fully deleted'. PHP_EOL;
            }

 
            //var_dump($now->diffInHours($value->deleted_at));  
        }
    }
}
