<?php namespace App\Modules\AdminMail\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\AdminSettings\Models\AdminSettings;
use App\EmailsLogs;
use Validator, Auth, Hash, Session;

class MailController extends \App\Modules\Panel\Controllers\AbstractController
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

    protected $per_page = 30;
    protected $offset   = 0;
    protected $pagination = false;
    protected $total      = 0;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Auth::user()->role === 1) {

            $this->total = EmailsLogs::count();
            $this->pagenation();
     
            $logs     = EmailsLogs::orderBy('id', 'DESC')->offset($this->offset)->limit($this->per_page)->get();
            $settings = AdminSettings::allSorted();

            return view('AdminMail::index')->with(['domains' => $this->domains, 'settings' => $settings, 'logs' => $logs, 'pagination' => $this->pagination]);

        } else {
            return redirect('/admin');
        }
    }

    protected function pagenation()
    {
        if ($this->total > $this->per_page) {
            $pages      = $this->total / $this->per_page;
            $current = (isset($_GET['page']) ? $_GET['page'] : 1);
            $this->pagination = ['total' => $pages, 'current' => $current];
        } 

        if(isset($_GET['page']) && intval($_GET['page']) && isset($pages)) { $this->offset = ($_GET['page'] - 1) * $this->per_page; } else { $this->offset = 0; }
    }
 
}
