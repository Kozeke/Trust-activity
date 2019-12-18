<?php namespace App\Modules\Mail\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\Mail\Handlers\HandlerController;

use App\User;
use Auth, DB;

class twelveHoursNoScriptController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $user, $currentValue, $purchases;

    public function __construct()
    {
        //$this->middleware('auth');
        //parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function index()
    {
        echo 'twelveHoursNoScript start...'.PHP_EOL;
        $domains = DB::table('domains')
            ->where('installedOnce', 0)
            ->where('created_at', '<=', \Carbon\Carbon::now()->subHours(12)->toDateTimeString())
            ->get();

        foreach ($domains as $key => $value) {
            echo $value->url.PHP_EOL;

            $this->user      = User::find($value->user_id);

            $handler               = new HandlerController();
            $handler->user         = $this->user;
            $handler->currentValue = $value;
            $handler->sendMessage('12_hours_noscript', 'system_event');

            DB::table('domains')->where('id', $value->id)->update(['installedOnce' => 2]);
        }
    }
}
