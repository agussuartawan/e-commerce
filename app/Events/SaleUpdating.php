<?php

namespace App\Events;

use App\Models\Sale;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SaleUpdating
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sale;
    public $product;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sale, $product)
    {
        $this->sale = $sale;
        $this->product = $product;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
