<?php namespace App\Modules\TranslationApi\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\LanguageValues;
use Validator, Auth, Hash, Session;
use App\User;

class TranslationController extends \App\Modules\Panel\Controllers\AbstractController
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

    public function index(Request $request)
    {	
        $inputs = Input::all();
        if (Auth::user()->force_update == 0){
        	$arr = $this->translate;
        } else if (Session::has('translate')) {
            $arr = Session::get('translate');
        } else {
            $arr = $this->translate;
        }
 
        switch ($inputs['page']) {
            case 'domain-item':
                return response()->json(self::domainItem($arr));
                break;
            case 'domain-metrics':
                return response()->json(self::domainMetrics($arr));
                break;
            case 'domain-contacts':
                return response()->json(self::domainContacts($arr));
                break;   
            case 'domain-add':
                return response()->json(self::domainAdd($arr));
                break;   
            case 'billing':
                return response()->json(self::billing($arr));
                break;  
        }
    }

    private static function billing($arr)
    {
        return [
            'hide-details'         => $arr['hide-details'],        
            'show-details'         => $arr['show-details'],
            'cancel-subscription'  => $arr['cancel-subscription'],
            'subscribe'            => $arr['subscribe'],
            'unsubscribed'         => $arr['unsubscribed'],
            'plan'                 => $arr['plan'],
            'notifications'        => $arr['notifications'],    
            'select-your-plan'     => $arr['select-your-plan'],
            'none'                 => $arr['none'],    
            'up-to'                => $arr['up-to'],
            'unique-visitorsmo'    => $arr['unique-visitorsmo'],
            'add-to-bill'          => $arr['add-to-bill'],
            'total'                => $arr['total'],    
            'remove'               => $arr['remove'],    
            'step'                 => $arr['step'],   
            're-select'            => (isset($arr['re-select']) ? $arr['re-select'] : 'Re select'),
            'select-your-plan'     => $arr['select-your-plan'],
            'check-out-2'          => $arr['check-out-2'],    
            'select-payment-method'  => $arr['select-payment-method'],    
            'from-balance'           => $arr['from-balance'],   
            'activate-notifications' => (isset($arr['activate-notifications']) ? $arr['activate-notifications'] : 'Activate notifications'),
            'update-plan'            => (isset($arr['update-plan']) ? $arr['update-plan'] : 'Update plan'),
            'limits-reached'         => (isset($arr['limits-reached']) ? $arr['limits-reached'] : 'Limits reached'),
            'remove-from-bill'       => (isset($arr['remove-from-bill']) ? $arr['remove-from-bill'] : 'Remove from bill'),
            'activate-notifications' => (isset($arr['activate-notifications']) ? $arr['activate-notifications'] : 'Update plan'),
        ];
    }   

    private static function domainContacts($arr)
    {
        return [
            'contact-list' => $arr['contact-list'],
            'see-all'      => $arr['see-all-contacts-added-by-this-widget'],
            'someone'      => $arr['someone'],
            'from'         => $arr['from']
        ];
    } 

    private static function domainMetrics($arr)
    {
        return [
            'campaign-metrics' => $arr['campaign-metrics'],
            'metrics'          => $arr['metrics'],
            'hours'            => $arr['hours'],  
            'how-it-looks'     => $arr['how-it-looks-on-page'],
            'month'            => $arr['month'],  
            'week'             => $arr['week'],  
            'pageviews'        => $arr['pageviews'],
            'visitors'         => $arr['visitors'],
            'minutes-ago'      => $arr['minutes-ago'],
        ];
    } 

    private static function domainAdd($arr)
    {
        return [
            'or'          => (isset($arr['or']) ? $arr['or'] : 'or'),  
            'locale'      => (isset($arr['locale']) ? $arr['locale'] : 'locale'),  
            'got-it'      => (isset($arr['got-it']) ? $arr['got-it'] : 'Got it!'),  
            'english'     => (isset($arr['english']) ? $arr['english'] : 'English'),  
            'russian'     => (isset($arr['russian']) ? $arr['russian'] : 'Russian'),  
            'turkish'     => (isset($arr['turkish']) ? $arr['turkish'] : 'Turkish'),    
            'greek'       => (isset($arr['greek']) ? $arr['greek'] : 'Greek'),  
            'german'       => (isset($arr['german']) ? $arr['german'] : 'German'),            
            'italian'     => (isset($arr['italian']) ? $arr['italian'] : 'Italian'),   
            'example'     => (isset($arr['example']) ? $arr['example'] : 'example'),  
            'new-domain'  => (isset($arr['new-domain']) ? $arr['new-domain'] : 'New domain'),  
            'still-confused' => (isset($arr['still-confused']) ? $arr['still-confused'] : 'Still confused'),  
            'add-domain'  => (isset($arr['add-domain']) ? $arr['add-domain'] : 'Add Domain'),    
            'domain-name' => (isset($arr['domain-name']) ? $arr['domain-name'] : 'Domain name'),
            'domain-url'  => (isset($arr['domain-url']) ? $arr['domain-url'] : 'Domain URL'),
            'enter-your-domain-url-without'     => (isset($arr['enter-your-domain-url-without']) ? $arr['enter-your-domain-url-without'] : 'Enter your domain URL without'),   
            'domain-successfully-added'         => (isset($arr['domain-successfully-added']) ? $arr['domain-successfully-added'] : 'Domain successfully added!'),
            'that-is-how-your-domain-will-show' => (isset($arr['that-is-how-your-domain-will-show']) ? $arr['that-is-how-your-domain-will-show'] : 'That is how your domain will show in the domain\'s list and dashboard'),
            'this-option-is-designed-to-correctly-translate-time-information'     => $arr['this-option-is-designed-to-correctly-translate-time-information'],
            'enter-domain-info-about-site-on-which-you-want-to-apply-our-service' => (isset($arr['enter-domain-info-about-site-on-which-you-want-to-apply-our-service']) ? $arr['enter-domain-info-about-site-on-which-you-want-to-apply-our-service'] : 'Enter domain info about site on which you want to apply our service'),
        ];
    } 
 
    private static function domainItem($arr)
    {

        return [
            'amount-of-visitors-viewing' => (isset($arr['amount-of-visitors-viewing']) ? $arr['amount-of-visitors-viewing'] : 'Amount of visitors viewing page in real-time'),       
            'created' => (isset($arr['created']) ? $arr['created'] : 'created'),
            'currently-viewing-this-page' => (isset($arr['currently-viewing-this-page']) ? $arr['currently-viewing-this-page'] : 'currently viewing this page'),
            'more' => (isset($arr['more']) ? $arr['more'] : 'more'),

 
            'got-it'      => (isset($arr['got-it']) ? $arr['got-it'] : 'Got it!'),  
            /*'' => $arr[''],
            '' => $arr[''],
            '' => $arr[''],
            '' => $arr[''],
            '' => $arr[''],*/
            'still-confused' => (isset($arr['still-confused']) ? $arr['still-confused'] : 'Still confused'),  
            'locale'      => (isset($arr['locale']) ? $arr['locale'] : 'locale'),  
            'english'     => (isset($arr['english']) ? $arr['english'] : 'English'),  
            'russian'     => (isset($arr['russian']) ? $arr['russian'] : 'Russian'),  
            'turkish'     => (isset($arr['turkish']) ? $arr['turkish'] : 'Turkish'),    
            'greek'       => (isset($arr['greek']) ? $arr['greek'] : 'Greek'),  
            'german'      => (isset($arr['german']) ? $arr['german'] : 'German'),            
            'italian'     => (isset($arr['italian']) ? $arr['italian'] : 'Italian'),  
            'greek'       => (isset($arr['greek']) ? $arr['greek'] : 'Greek'),  
            'german'      => (isset($arr['german']) ? $arr['german'] : 'German'),            
            'italian'     => (isset($arr['italian']) ? $arr['italian'] : 'Italian'),    
            'seconds' => $arr['seconds'],
            'this-option-is-designed-to-correctly-translate-time-information' => $arr['this-option-is-designed-to-correctly-translate-time-information'],
            'set-the-spacing-between-notifications-in' => $arr['set-the-spacing-between-notifications-in'],
            'setting-the-interval-with-which-notifications-will-be-displayed' => (isset($arr['setting-the-interval-with-which-notifications-will-be-displayed']) ? $arr['setting-the-interval-with-which-notifications-will-be-displayed'] : 'Setting the interval with which notifications will be displayed.'),
            'choose-position-for-notifications-on-desktop-laptops-and-tablet-devices-left-or-right' => $arr['choose-position-for-notifications-on-desktop-laptops-and-tablet-devices-left-or-right'],
            'position-notifications' => $arr['position-notifications'],
            'choose-position-for-notifications-on-mobile-devices-top-or-bottom' => $arr['choose-position-for-notifications-on-mobile-devices-top-or-bottom'],
            'show-on-top-of-page-on-mobile' => $arr['show-on-top-of-page-on-mobile'],
            'toggle-this-option-on-if-you-dont-want-to-show-any-notifications-on-mobile-devices' => $arr['toggle-this-option-on-if-you-dont-want-to-show-any-notifications-on-mobile-devices'],
            'hide-notifications-on-mobile' => $arr['hide-notifications-on-mobile'],
            'left'  => $arr['left'],
            'right' => $arr['right'],
            'yes'   => $arr['yes'],
            'no'    => $arr['no'],
            'someone'  => $arr['someone'],
            'from'     => $arr['from'],
            'visitors' => $arr['visitors'],
            'shows'    => $arr['shows'],
            'contacts' => $arr['contacts'],
            'metrics'  => $arr['metrics'],
            'edit'     => $arr['edit'],  
            'delete'   => $arr['delete'],
            'times'    => $arr['times'],   
            'modified' => $arr['modified'], 
            'off'      => $arr['off'],  
            'on'       => $arr['on'],    
            'undo'     => $arr['undo'],
            'hours'    => $arr['hours'],  
            'activate' => $arr['activate'],          
            'campaign-deleted' => $arr['campaign-deleted'],
            'fully-deleted'    => $arr['the-campaign-will-be-fully-deleted-from-our-database-after'],  
            'press-undo'       => $arr['please-press-undo-if-you-want-to-restore-this-campaign-or-all-data-will-be-deleted-permanently'],
            'no-subscription-yet' => $arr['no-subscription-yet'],
            'sorry-you-dont-have' => $arr['sorry-you-dont-have-active-subscription-yet-please-activate-this-module-in-the-dashboard'],
            'cancelled-your-plan' => $arr['you-have-cancelled-your-plan'],
            'remain-active-until' => $arr['it-will-remain-active-until'],
            'no-active-campaign-yet' => (isset($arr['no-active-campaign-yet']) ? $arr['no-active-campaign-yet'] : 'No Active Campaign yet'),
            'new-campaign'           => (isset($arr['new-campaign']) ? $arr['new-campaign'] : 'New Campaign'),
            'need-to-add-first-notification-campaign-for-start' => (isset($arr['need-to-add-first-notification-campaign-for-start']) ? $arr['need-to-add-first-notification-campaign-for-start'] : 'Need to add first notification campaign for start'),
            'just-click-the-button-below' => (isset($arr['just-click-the-button-below']) ? $arr['just-click-the-button-below'] : 'Just click the button below'),
        ];
    }
}
