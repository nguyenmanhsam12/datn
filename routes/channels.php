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

Broadcast::channel('order-canceled', function (User $user) {
    return $user->hasRole('admin') || $user->hasRole('manager');
});

Broadcast::channel('order-confirm', function (User $user) {
    return $user->hasRole('admin') || $user->hasRole('manager');
});



Broadcast::channel('order.{orderId}', function (User $user, $orderId) {
    $order = Order::find($orderId);
    return $order && $order->user_id === $user->id; // Chỉ người sở hữu đơn hàng mới nhận được thông báo
});



Broadcast::channel('new-orders.{userId}', function (User $user, $userId) {
    // Kiểm tra xem người dùng có quyền truy cập kênh hay không
    return $user->id == $userId && ($user->hasRole('admin') || $user->hasRole('manager'));
});



