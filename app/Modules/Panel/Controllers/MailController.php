<?php 

namespace App\Modules\Panel\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;

use App\Mail\DemoEmail;
use App\EmailsLogs;

use Illuminate\Support\Facades\Mail;
 
class MailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    { 
 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    static public function registration($user)
    {
        self::trackSending($user, 'registration');
        //$user->email = 'php@positron-it.ru';

        Mail::send('mails.registration', ['email' => $user->email], function ($m) use ($user) {
            $m->from('noreply@trustactivity.com', 'Trustactivity');
            $m->to($user->email, $user->email)->subject('You has been registered on Trustactivity.com!');
        });
    }

    static public function registrationSocial($user, $pass)
    {
        self::trackSending($user, 'registration_social');
        //$user->email = 'php@positron-it.ru';

        Mail::send('mails.registration_social', ['email' => $user->email, 'password' => $pass], function ($m) use ($user) {
            $m->from('noreply@trustactivity.com', 'Trustactivity');
            $m->to($user->email, $user->email)->subject('You has been registered on Trustactivity.com!');
        });
    }

    // срок подходит к концу
    static public function expireSoon($user)
    {
        self::trackSending($user, 'expireSoon');   
        //$user->email = 'php@positron-it.ru';
        //echo 'event: expireSoon, email:' . $user->email.'<br>';
        Mail::send('mails.expiring_soon', ['email' => $user->email, 'url' => $user->url], function ($m) use ($user) {
            $m->from('noreply@trustactivity.com', 'Trustactivity');
            $m->to($user->email, $user->email)->subject('Notification module expires soon!');
        });
    }
    // срок истек
    static public function hasExpired($user)
    {
        self::trackSending($user, 'hasExpired'); 
        //$user->email = 'php@positron-it.ru';
        //echo 'event: hasExpired, email:' . $user->email.'<br>';
        Mail::send('mails.has_expired', ['email' => $user->email, 'url' => $user->url], function ($m) use ($user) {
            $m->from('noreply@trustactivity.com', 'Trustactivity');
            $m->to($user->email, $user->email)->subject('Notification module has expired!');
        });
    }
    // осталось 3 дня
    static public function threeDaysLeft($user)
    {
        self::trackSending($user, 'threeDaysLeft');  
        //$user->email = 'php@positron-it.ru';
        //echo 'event: threeDaysLeft, email:' . $user->email.'<br>';
        Mail::send('mails.three_days_left', ['email' => $user->email, 'url' => $user->url], function ($m) use ($user) {
            $m->from('noreply@trustactivity.com', 'Trustactivity');
            $m->to($user->email, $user->email)->subject('Three days left till module has expired!');
        });
    }
    // осталось 3 дня
    static public function threeDaysUnActive($user)
    {
        self::trackSending($user, 'threeDaysUnActive');
        //$user->email = 'php@positron-it.ru';
        //echo 'event: threeDaysUnActive, email:' . $user->email.'<br>';
        Mail::send('mails.three_days_unactive', ['email' => $user->email], function ($m) use ($user) {
            $m->from('noreply@trustactivity.com', 'Trustactivity');
            $m->to($user->email, $user->email)->subject('We are waiting you at Trustactivity.com!');
        });
    }

    // 10 дней активен
    static public function tenDaysActive($user)
    {
        self::trackSending($user, 'tenDaysActive');
        //$user->email = 'php@positron-it.ru';
        //echo 'event: tenDaysActive, email:' . $user->email.'<br>';
        Mail::send('mails.ten_days_active', ['email' => $user->email], function ($m) use ($user) {
            $m->from('noreply@trustactivity.com', 'Trustactivity');
            $m->to($user->email, $user->email)->subject('We have some useful stuff for you!');
        });
    }
    // первые 12 часов не установил скрипт на сайт
    static public function twelveHoursNoScript($user)
    {
        self::trackSending($user, 'twelveHoursNoScript');
        //$user->email = 'php@positron-it.ru';
        //echo 'event: tenDaysActive, email:' . $user->email.'<br>';
        Mail::send('mails.12hours_pixel', ['email' => $user->email], function ($m) use ($user) {
            $m->from('noreply@trustactivity.com', 'Trustactivity');
            $m->to($user->email, $user->email)->subject('Ran into any problems with settings? Let us help you!');
        });
    }
    // первые 12 часов не установил скрипт на сайт
    static public function Autopurchase($user)
    {
        self::trackSending($user, 'autopurchase');
        //$user->email = 'php@positron-it.ru';
        //echo 'event: tenDaysActive, email:' . $user->email.'<br>';
        Mail::send('mails.autopurchase', ['email' => $user->email, 'url' => $user->url], function ($m) use ($user) {
            $m->from('noreply@trustactivity.com', 'Trustactivity');
            $m->to($user->email, $user->email)->subject('Subscription was successfully renewed!');
        });
    }

    static protected function trackSending($user, $type)
    {
        $user->url = ($user->url ? $user->url : '');

        $event = new EmailsLogs();
        $event->user   = $user->email;
        $event->domain = $user->url;
        $event->type   = $type;     
        $event->save();
    }
}
