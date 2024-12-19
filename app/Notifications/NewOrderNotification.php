<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;


class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */

    // Chuyển thông báo sang dạng database
    // khi gọi hàm notify() cho mỗi người dùng bên phía code đặt hàng thì $notifiable chính là người 
    // dùng đó nên là sẽ lấy được id của người dùng
     public function toDatabase($notifiable)
     {
         return [
             'title' => 'Đơn hàng mới',
             'message' => 'Có một đơn hàng mới với mã đơn hàng: ' . $this->order->id,
             'order_id' => $this->order->id,
             'user_id' => $notifiable->id,
             'status' => 'unread',
         ];
     }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // Cấu hình thông báo realtime
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Đơn hàng mới',
            'message' => 'Có một đơn hàng mới với mã đơn hàng: ' . $this->order->id,
            'order_id' => $this->order->id,
            'order_amount' => $this->order->total_amount,
        ]);
    }

    // định nghĩa kênh
    public function broadcastOn(): array
    {
        // Kiểm tra nếu người dùng có quyền admin hoặc manager thì broadcast trên Private Channel
        return [new PrivateChannel('new-orders')];  // Trả về mảng chứa kênh
    }
}
