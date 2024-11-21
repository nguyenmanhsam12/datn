<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Mail\OrderStatusUpdated;
use Illuminate\Support\Facades\Mail;
use App\Events\OrderStatusUpdatedEvent;



class OrderAdminController extends Controller
{
    // Giao diện admin
    public function index()
    {
        $orders = Order::with('user', 'payment', 'orderStatus')->orderBy('id', 'desc')->get();
        $order_status = OrderStatus::all();
        return view('admin.order.list', compact('orders', 'order_status'));
    }

    public function detail($id)
    {
        $order = Order::with('user', 'payment', 'orderStatus', 'orderAddress', 'cartItems')->find($id);
        $finalTotal = $order->total_amount + $order->shipping_fee + $order->discount_amount;
        $order_status = OrderStatus::all();
        return view('admin.order.detailOrder', compact('order', 'order_status','finalTotal'));
    }

    public function updateOrder(Request $request)
    {   
        $data = $request->all();

        $orderId = $data['orderId'];
        $newStatus = $data['status_id'];

        $order = Order::find($orderId);
        if ($order) {
            $order->status_id = $newStatus;
            $order->save();
            return redirect()->route('admin.order.index')->with('success','Cập nhật thành công');
        } else {
            return redirect()->route('admin.order.index')->with('error','Không tìm thấy đơn hàng');
        }
    }

    // cập nhật bằng js
    public function updateStatus(Request $request)
    {   
        $data = $request->all();

        $orderId = $data['orderId'];
        $newStatus = $data['status_id'];

        $order = Order::find($orderId);
        if ($order) {

            $currentStatus = $order->status_id;

            if($newStatus == $currentStatus + 1 ){

                $order->status_id = $newStatus;
                $order->save();

                // Phát sự kiện OrderStatusUpdatedEvent
                broadcast(new OrderStatusUpdatedEvent($order));

                // Gửi email thông báo
                Mail::to($order->orderAddress->recipient_email)->queue(new OrderStatusUpdated($order));

                return response()->json(['message' => 'Cập nhật trạng thái thành công!'],200);
            }else{
                return response()->json(['error' => 'Chỉ có thể cập nhật trạng thái lên 1 cấp!'],400);
            }
        } else {
            return response()->json(['message' => 'Không tìm thấy đơn hàng!'], 404);
        }
    }
}
