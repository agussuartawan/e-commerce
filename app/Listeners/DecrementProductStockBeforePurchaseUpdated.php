<?php

namespace App\Listeners;

use App\Events\PurchaseUpdating;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DecrementProductStockBeforePurchaseUpdated
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
     * @param  \App\Events\PurchaseUpdating  $event
     * @return void
     */
    public function handle(PurchaseUpdating $event)
    {
        $purchase = $event->purchase;
        $product = $event->product;
        $product->decrement('stock', (int)$purchase->qty);
    }
}
