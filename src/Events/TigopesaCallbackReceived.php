<?php

namespace Tumainimosha\TigopesaPush\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Tumainimosha\TigopesaPush\Models\TigopesaPushTransaction;

class TigopesaCallbackReceived implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var TigopesaPushTransaction
     */
    public $transaction;

    /**
     * Create a new event instance.
     *
     * @param TigopesaPushTransaction $transaction
     */
    public function __construct(TigopesaPushTransaction $transaction)
    {
        $this->transaction = $transaction;
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
