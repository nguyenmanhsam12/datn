<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountController extends Controller
{
    public function myAccount()
    {
        $user = Auth::user()->load(['ward', 'city', 'province']);
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước');
        }

        $status = OrderStatus::all();
        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();
        $order =  Order::with('cartItems', 'orderStatus','orderAddress','complaint')
            ->where('user_id', $user->id)
            ->get();
        $list_provice = Province::all();
        
        return view('client.pages.myaccount', compact('status', 'order', 'user','list_brand','list_category'
            ,'list_provice'
        ));
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
            $order->status_id = 5;
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

    public function cancelOrder(Request $request)
    {
        $data = $request->all();

        // Kiểm tra xem đơn hàng có tồn tại không
        $order = Order::find($data['orderId']);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn hàng không tồn tại.'
            ], 404);
        }

        // Kiểm tra trạng thái đơn hàng có phải là "Đang chờ xử lý" hay không
        if ($order->status_id != $data['currentStatus']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn hàng không thể hủy trong trạng thái này.'
            ], 400);
        }

        // Lấy các sản phẩm trong đơn hàng
        $orderItems = $order->cartItems;

        // Cập nhật lại tồn kho cho mỗi sản phẩm trong đơn hàng
        foreach ($orderItems as $item) {
            $productVariant = $item->productVariant;

            // Tăng lại số lượng tồn kho
            $productVariant->increment('stock', $item->quantity);
            $productVariant->selled -= $item->quantity;
            $productVariant->save();

        }

        $order->status_id = 6;
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Đơn hàng đã được hủy bỏ.',
            'orderId' => $order->id,
            'newStatus' => $order->status_id,
            'statusName' => $order->orderStatus->name,
        ]);
    }

    // update profile
    public function updateProfile(Request $request){

        $data = $request->all();

        $user = auth()->user();

        $newUser = User::find($user->id);

        $newUser->update($data);

        return response()->json(['success' => true, 'message' => 'Thông tin cập nhật thành công']);

    }
}
