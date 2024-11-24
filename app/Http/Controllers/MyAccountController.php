<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountController extends Controller
{
    
    public function myAccount()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước');
        }

        $status = OrderStatus::all();
        $order =  Order::with('cartItems', 'orderStatus','orderAddress')
            ->where('user_id', $user->id)
            ->get();
        return view('client.pages.myaccount', compact('status', 'order', 'user'));
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
    // public function submitReview(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'rating' => 'required|integer|between:1,5',
    //         'message' => 'nullable|string|max:1000',
    //     ]);
    
    //     $review = new Review();
    //     $review->user_id = auth()->id();
    //     $review->product_id = $request->product_id;
    //     $review->rating = $request->rating;
    //     $review->message = $request->message;
    //     $review->save();
    
    //     return redirect()->back()->with('success', 'Đánh giá đã được gửi thành công!');
    // }
    
    
    
}
