<?php namespace App\Modules\Mail\Handlers;

use Illuminate\Routing\Controller;
use App\Modules\Panel\Controllers\MailController;

use App\Events;
use App\User;
use Auth, DB;

class HandlerController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $user, $currentValue;

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
 
    public function sendMessage($message, $type = 'module_purchases')
    {
        $exist = $this->eventExist($message, $type);

        if (!$exist) { 
 
            $this->createEvent($message, $type);  
            
            switch ($message) {
                case '3_days_left':
                    MailController::threeDaysLeft($this->user); 
                    break;     
                case '3_days_unactive':
                    MailController::threeDaysUnActive($this->user); 
                    break;         
                case '10_days_active':
                    MailController::tenDaysActive($this->user); 
                    break;   
                case '12_hours_noscript':
                    MailController::twelveHoursNoScript($this->user); 
                    break;     
            }
        }
    }
 
    protected function eventExist($event_name, $type) 
    {
        if ($event_name == '3_days_left') { $id = $this->currentValue->domain_id; } else { $id = $this->currentValue->id; }

        return Events::where('item_id', $id)
            ->where('item_type', $type)
            ->where('event_name', $event_name)
            ->first(); 
    }

    protected function createEvent($message, $type)  
    {
        if ($message == '3_days_left') { $id = $this->currentValue->domain_id; } else { $id = $this->currentValue->id; }

        $event = new Events;
        $event->item_id    = $id;
        $event->item_type  = $type;
        $event->event_name = $message;
        $event->save();    
    }
 
}
