<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Modules\Billing\Controllers\PurchaseUpdateController;
use \App\Modules\Domains\Controllers\DomainMailEventsController;
use \App\Console\Commands\DomainScriptStatus;
 
 
class UpdatePurchases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase:update';

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
        echo 'handle'.PHP_EOL;
        ini_set("memory_limit", "4096M");
        
        $status = new DomainScriptStatus();
        $status->handle();

        $purchases = new PurchaseUpdateController();
        $purchases->init();
        
        $domains = new DomainMailEventsController();
        $domains->init();
    }
}
