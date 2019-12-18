<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UpdatePurchases::class,
        Commands\DomainCompanyDelete::class,
        Commands\DomainDelete::class,
        Commands\DomainScriptStatus::class,  
        Commands\CityImageParse::class,  
        Commands\SendEmails::class,  
        Commands\UpdateIsInstalled::class,   
        Commands\SelectDomainToCheckInstall::class,
        Commands\HotstreakTempParse::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
