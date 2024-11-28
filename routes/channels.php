<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('order.{orderId}', function (User $user, $orderId) {
    $order = Order::find($orderId);
    Log::debug('Checking access to channel', ['user_id' => $user->id, 'order_user_id' => $order->user_id]);
    return $order && $order->user_id === $user->id; // Chỉ người sở hữu đơn hàng mới nhận được thông báo
});
