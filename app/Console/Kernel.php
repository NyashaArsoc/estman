<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:propmanleaseexpiry')->daily()->withoutOverlapping();
        $schedule->command('app:propmanruninvoice')->monthlyOn(25, '00:20')->withoutOverlapping();
        $schedule->command('app:propmanrunremit')->monthlyOn(7, '00:20')->withoutOverlapping();
        $schedule->command('app:hcruntakeondays')->dailyAt('00:10')->withoutOverlapping();
        $schedule->command('app:valweeklynormalreport')->weeklyOn(1, '04:30')->withoutOverlapping();
        $schedule->command('app:valweeklyportfolioreport')->weeklyOn(1, '06:30')->withoutOverlapping();
        $schedule->command('app:hcmonthlyactivity')->monthlyOn(1, '00:30')->withoutOverlapping();
        $schedule->command('app:hcmonthlyleavereport')->monthlyOn(22, '00:30')->withoutOverlapping();
        //$schedule->command('app:hcmonthlyleavereport')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
