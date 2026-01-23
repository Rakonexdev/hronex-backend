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
        Commands\ScheduleAlert::class,
        Commands\AutoAttendance::class,
        Commands\DailyNotif::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {       
        //$schedule->command('schedulealert:cron')->cron('0 06 * * *');
        $schedule->command('schedulealert:cron')->everyFifteenMinutes();
        $schedule->command('autoattendance:cron')->dailyAt('23:30'); /*cron('0 23 * * *');*/
        $schedule->command('dailynotif:cron')->dailyAt('07:00');
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
