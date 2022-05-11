<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeliveryEmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sale, $delivery_estimation)
    {
        $this->sale = $sale;
        $this->delivery_estimation = $delivery_estimation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                   ->view('email.delivery_email')
                   ->with(
                    [
                        'name' => $this->sale->customer->fullname,
                        'order_number' => $this->sale->sale_number,
                        'order_id' => $this->sale->id,
                        'delivery_estimation' => $this->delivery_estimation
                    ]);
    }
}
