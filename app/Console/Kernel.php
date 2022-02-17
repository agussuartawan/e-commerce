<?php

namespace App\Console;

use App\Models\DeliveryStatus;
use App\Models\PaymentStatus;
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
            $sales = tap(Sale::where('due_date', '<' , Carbon::now())
                ->where('payment_status_id', PaymentStatus::MENUNGGU_PEMBAYARAN)
                ->where('is_cancle', 0)
                ->update([
                    'is_cancle' => 1,
                    'delivery_status_id' => DeliveryStatus::DIBATALKAN,
                    'payment_status_id' => PaymentStatus::DIBATALKAN,
                ]))
                ->get();
            foreach($sales as $sale){
                $sale = Sale::find($sale->id);
                $sale->product->increment('stock', $sale->qty);
            }
        })->everyMinute();
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
