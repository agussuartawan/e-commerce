<?php

namespace App\Console;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Sale::where('due_date', '<' , Carbon::now())
                ->where('payment_status', 'menunggu pembayaran')
                ->update([
                    'is_cancle' => 1,
                    'delivery_status' => 'dibatalkan',
                    'payment_status' => 'dibatalkan',
                ]);
        })->hourly();;
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
