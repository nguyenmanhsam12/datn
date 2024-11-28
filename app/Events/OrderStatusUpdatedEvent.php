<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderStatusUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $newStatus;
    public $orderItems;

    /**
     * Create a new event instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->newStatus = $order->orderStatus;
        $this->orderItems = $order->cartItems;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {   
        Log::debug('OrderStatusUpdatedEvent broadcasting', [
            'order_id' => $this->order->id,
            'status_id' => $this->order->status_id
        ]);
        return new PrivateChannel('order.'.$this->order->id);   
    }

    public function broadcastWith()
    {
        return [
            'order' => $this->order, // Đơn hàng đầy đủ
            'newStatus' => $this->newStatus, // Trạng thái mới
            'orderItems' => $this->orderItems, // Danh sách sản phẩm
        ];
    }

    
}
