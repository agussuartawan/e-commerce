<?php

namespace App\Listeners;

use App\Events\SaleUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DecrementProductStockAfterSaleUpdated
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
     * @param  \App\Events\SaleUpdated  $event
     * @return void
     */
    public function handle(SaleUpdated $event)
    {
        $sale = $event->sale;
        $request = $event->request;
        $sale->product->decrement('stock', (int)$request['qty']);
    }
}
