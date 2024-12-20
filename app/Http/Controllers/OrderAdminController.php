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
        $orders = Order::with('user', 'payment', 'orderStatus')->orderBy('id','desc')->get();

        $order_status = OrderStatus::all();
        
        return view('admin.order.list', compact('orders', 'order_status'));
    }

    public function detail($id)
    {
        $order = Order::with('user', 'payment', 'orderStatus', 'orderAddress', 'cartItems')->find($id);
        $finalTotal = $order->total_amount + $order->shipping_fee - $order->discount_amount;
        $order_status = OrderStatus::all();
        return view('admin.order.detailOrder', compact('order', 'order_status','finalTotal'));
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

                if($order->payment_status == 'pending' && $order->payment_method_id == 2){
                    return response()->json(['error' => 'Bạn không thể cập nhập trạng thái này khi đơn hàng chưa thanh toán'],400);
                }

                if($newStatus == 6 && $currentStatus == 5){
                    return response()->json(['error' => 'Đơn hàng đã được hoàn tất nên không thể hủy được'],400);
                }

                $order->status_id = $newStatus;

                if($order->status_id == 5){
                    $order->payment_status = 'paid';
                }

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

    public function deleteOrder($id){
        $order = Order::find($id);

        if($order){
            $order->delete();
            return redirect()->back()->with('success','Xóa đơn hàng thành công');
        }

        return redirect()->back()->with('error','Đơn hàng không tồn tại');
    }
}
