<?php

namespace App\Listeners;

use App\Models\Product;
use App\Events\SaleUpdating;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncrementProductStockBeforeSaleUpdated
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
     * @param  \App\Providers\App\Events\SaleUpdating  $event
     * @return void
     */
    public function handle(SaleUpdating $event)
    {
        $sale = $event->sale;
        $product = $event->product;
        // $product->increment('stock', (int)$sale->qty);
        $product->stock = $product->stock + (int)$sale->qty;
        $product->save();
    }
}
