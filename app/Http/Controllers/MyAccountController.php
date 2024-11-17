<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountController extends Controller
{
    public function myAccount(){
        $user = Auth::user();

        if(!$user){
            return redirect()->route('login')->with('error','Vui lòng đăng nhập trước');
        }

        $status = OrderStatus::all();
        $order =  Order::with('cartItems','orderStatus')
            ->where('user_id',$user->id)
            ->get();
        return view('client.pages.myaccount',compact('status','order','user'));
    }

    // nút xác nhận đã nhận hàng
    public function confirmOrder(Request $request)
    {
        // Lấy ID và hành động từ body
        $data = $request->all();
    
        // Kiểm tra xem đơn hàng có tồn tại không
        $order = Order::find($data['orderId']);
    
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn hàng không tồn tại.'
            ], 404);
        }
    
        // Xử lý hành động xác nhận đơn hàng
        if ($order && $order->status_id == $data['currentStatus']) {
            $order->status_id = 5 ;
            $order->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Đơn hàng đã được xác nhận.',
                'orderId' => $order->id,
                'newStatus' => $order->status_id,
                'statusName' => $order->orderStatus->name,
            ]);
        }

    }

    public function cancelOrder(Request $request){
        $data = $request->all();
    
        // Kiểm tra xem đơn hàng có tồn tại không
        $order = Order::find($data['orderId']);
    
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn hàng không tồn tại.'
            ], 404);
        }
    
        // Xử lý hành động xác nhận đơn hàng
        if ($order && $order->status_id == $data['currentStatus']) {
            $order->status_id = 6 ;
            $order->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Đơn hàng đã được hủy bỏ.',
                'orderId' => $order->id,
                'newStatus' => $order->status_id,
                'statusName' => $order->orderStatus->name,
            ]);
        }
    }
    
}
