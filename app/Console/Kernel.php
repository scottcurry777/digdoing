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
        //
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
        
        // Run Backups
        $schedule->command('backup:clean')->everyMinute(); // UTC is 6 hours ahead, so 01:00 = 05:00
        $schedule->command('backup:run')->everyMinute() // 02:00, 02:04 // UTC is 6 hours ahead, so 02:00 = 06:00
            ->onFailure(function () {
                // Do something on failed backup
            })
            ->onSuccess(function () {
                // Do something on successful backup
            });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
