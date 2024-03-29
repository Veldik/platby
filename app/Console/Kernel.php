<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        Commands\CheckBankPayments::class,
        Commands\AdminRegister::class,
        Commands\CheckPeriodPayments::class,
        Commands\LatePaymentAnnounce::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('telescope:prune --hours=48')->daily();
        $schedule->command('check:bank-payments')->everyMinute();
        $schedule->command('check:period-payments')->everyMinute();
        $schedule->command('mail:late-payment-announce')->weekly()->mondays()->at('9:15');
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
