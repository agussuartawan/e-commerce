<?php

namespace App\Listeners;

use App\Events\SaleCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DecrementProductStockAfterSaleCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SaleCreated  $event
     * @return void
     */
    public function handle(SaleCreated $event)
    {
        $sale = $event->sale;
        $sale->product->stock = $sale->product->stock - (int)$sale->qty;
        $sale->product->save();
    }
}
