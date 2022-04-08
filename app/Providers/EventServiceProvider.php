<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \App\Events\SaleCreated::class => [
            \App\Listeners\DecrementProductStockAfterSaleCreated::class,
        ],
        \App\Events\SaleUpdating::class => [
            \App\Listeners\IncrementProductStockBeforeSaleUpdated::class,
        ],
        \App\Events\SaleUpdated::class => [
            \App\Listeners\DecrementProductStockAfterSaleUpdated::class,
        ],
        \App\Events\PaymentConfirmed::class => [
            \App\Listeners\CreateJournalAfterPaymentConfirmed::class,
        ],
        \App\Events\ProductDeleted::class => [
            \App\Listeners\RemoveImageAfterProductDeleted::class,
        ],
        \App\Events\PurchaseUpdating::class => [
            \App\Listeners\DecrementProductStockBeforePurchaseUpdated::class,
        ],
        \App\Events\PurchaseUpdated::class => [
            \App\Listeners\IncrementProductStockAfterPurchaseUpdated::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
