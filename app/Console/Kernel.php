<?php

namespace App\Console;

use App\Events\SaleUpdating;
use App\Mail\PaymentNotificationEmail;
use App\Models\DeliveryStatus;
use App\Models\PaymentStatus;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

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
            //otomatis ganti status pengiriman jadi dikirim setelah 2 hari
            $orders = Sale::where('delivery_status_id', DeliveryStatus::DALAM_PENGIRIMAN)->get();
            foreach($orders as $order){
                $delivery_due = Carbon::parse($order->date)->addDays(2);
                if($delivery_due < Carbon::now()){
                    $order->update(['delivery_status_id' => DeliveryStatus::DIKIRIM]);
                }
            }
    
            //batalkan pesanan jika tidak jatuh tempo
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
        })->everyMinute();

        $schedule->call(function () {
            //kirim notifikasi pembayaran 5 jam sebelum jatuh tempo
            $sale = Sale::where('payment_status_id', PaymentStatus::MENUNGGU_PEMBAYARAN)->where('is_cancel', 0)->get();
            foreach($sale as $s){   
                Mail::to($s->customer->user->email)->send(new PaymentNotificationEmail($s));
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
