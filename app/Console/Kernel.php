<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Sale;
use App\Events\SaleUpdating;
use App\Models\PaymentStatus;
use App\Models\DeliveryStatus;
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
            $sales = Sale::where('due_date', '<' , Carbon::now())
                    ->where('payment_status_id', PaymentStatus::MENUNGGU_PEMBAYARAN)
                    ->where('is_cancel', 0)->get();

            foreach($sales as $sale){
                event(new SaleUpdating($sale, $sale->product));
                $sale->update([
                    'is_cancel' => 1,
                    'delivery_status_id' => DeliveryStatus::DIBATALKAN,
                    'payment_status_id' => PaymentStatus::DIBATALKAN,
                ]);
            }

            $orders = Sale::where('delivery_status_id', DeliveryStatus::DALAM_PENGIRIMAN)->get();
            foreach($orders as $order){
                $delivery_due = Carbon::parse($order->date)->addDays(2);
                if($delivery_due < Carbon::now()){
                    $order->update(['delivery_status_id' => DeliveryStatus::DIKIRIM]);
                }
            }
        })->twiceDaily(8, 17);
        // })->everyMinute();
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
