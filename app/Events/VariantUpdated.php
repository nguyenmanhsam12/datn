<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VariantUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $variant;

    public function __construct($variant)
    {
        $this->variant = $variant;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('variant-update-'.$this->variant->id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->variant->id,
            'size_id' => $this->variant->size_id,
            'stock' => $this->variant->stock,
            'price' => $this->variant->price,
        ];
    }
}
