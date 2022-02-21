<?php

namespace App\Listeners;

use App\Events\PaymentConfirmed;
use App\Models\Account;
use App\Models\GeneralJournal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateJournalAfterPaymentConfirmed
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
     * @param  \App\Events\PaymentConfirmed  $event
     * @return void
     */
    public function handle(PaymentConfirmed $event)
    {
        $sale = $event->sale;
        GeneralJournal::create([
            'date' => $sale->date,
            'account_id' => Account::KAS,
            'debit' => $sale->grand_total,
            'credit' => 0
        ]);

        GeneralJournal::create([
            'date' => $sale->date,
            'account_id' => Account::PENJUALAN,
            'debit' => 0,
            'credit' => $sale->grand_total
        ]);
    }
}
