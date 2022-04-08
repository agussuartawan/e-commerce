<?php

namespace App\Listeners;

use App\Events\PurchaseUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncrementProductStockAfterPurchaseUpdated
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
     * @param  \App\Events\PurchaseUpdated  $event
     * @return void
     */
    public function handle(PurchaseUpdated $event)
    {
        //
    }
}
