<?php
namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\CheckOrderDayJob;
class Kernel extends ConsoleKernel {
    protected function schedule(Schedule $schedule): void
    {
        /*$schedule->command('app:check-order-hours')->everySecond();
        $schedule->command('app:check-order-day')->everySecond();*/
        $schedule->job(new CheckOrderDayJob)->everyFourMinutes();
    }

    protected function commands(): void {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
