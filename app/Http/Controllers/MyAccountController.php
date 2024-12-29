<?php

namespace App\Http\Controllers;

use App\Events\OrderCanceled;
use App\Events\OrderConfirm;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Complaints;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Province;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MyAccountController extends Controller
{
    public function myAccount(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước');
        }

        $status = OrderStatus::all();
        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();
        
        $order =  Order::with('cartItems', 'orderStatus','orderAddress','complaint')
            ->where('user_id', $user->id)
            ->orderBy('id','desc')
            ->get();
        $list_provice = Province::all();

        return view('client.pages.myaccount', compact('status','user','list_brand','list_category'
            ,'list_provice','order'
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

        // Kiểm tra nếu có khiếu nại cho đơn hàng
        $complaint = Complaints::where('order_id', $order->id)->first();

        // nếu như có khiếu nại tiến hành kiểm tra trạng thái khiếu nại
        if($complaint){
            // trạng thái khiếu nại là hủy bỏ vẫn có  thể xác nhận đơn hàng
            if (in_array($complaint->status, ['Chờ xử lý', 'Đang xử lý'])) {
                // Kiểm tra trạng thái khiếu nại
                    return response()->json([
                        'status' => 'error',
                        'error' => 'Không thể xác nhận đơn hàng khi có khiếu nại chưa được giải quyết.'
                    ], 400);
            }
        }

        
        // Xử lý hành động xác nhận đơn hàng
        if ($order && $order->status_id == $data['currentStatus']) {
            $order->status_id = 5;
            $order->payment_status = 'paid';
            $order->save();

            broadcast(new OrderConfirm($order));

            return response()->json([
                'status' => 'success',
                'message' => 'Đơn hàng đã được xác nhận.',
                'orderId' => $order->id,
                'newStatus' => $order->status_id,
                'statusName' => $order->orderStatus->name,
                'newpaymentStatus' => $order->payment_status,
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

    

        if($order->payment_method_id == 2 ){
            if($order->payment_status == 'pending'){
                $transaction = Transactions::where('order_id',$order->id)->first();
                if ($transaction) {
                    $transaction->status = 'canceled'; // hoặc 'failed' tùy theo logic
                    $transaction->save();
                }
            $order->payment_status = 'canceled'; // Cập nhật trạng thái thanh toán trong đơn hàng
            $order->note = 'Đơn hàng đã bị hủy trước khi thanh toán hoàn tất.';
            }else if($order->payment_status == 'paid'){
                if ($order->payment_status != 'refund_pending' && $order->payment_status != 'refund') {
                    // Cập nhật trạng thái thanh toán trong đơn hàng
                    $order->payment_status = 'refund_pending'; // Đánh dấu là đang chờ hoàn tiền
                    $order->note = 'Đang chờ hoàn tiền do khách hàng hủy đơn hàng.';
                }
            }
           
        }elseif($order->payment_method_id == 1){
            $order->payment_status = 'canceled'; // Cập nhật trạng thái thanh toán trong đơn hàng
            $order->note = 'Đơn hàng đã bị hủy trước khi thanh toán hoàn tất.';           
        }


        // cập nhập trạng thái của đơn hàng
        $order->status_id = 6;
        $order->save();

        broadcast(new OrderCanceled($order));

        

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

        

        return response()->json([
            'status' => 'success',
            'message' => 'Đơn hàng đã được hủy bỏ.',
            'orderId' => $order->id,
            'newStatus' => $order->status_id,   // trạng thái mới
            'statusName' => $order->orderStatus->name, // tên trạng thái mới
            'newPaymentStatus' => $order->payment_status  // Thêm thông tin trạng thái thanh toán
        ]);
    }

    // update profile
    public function updateProfile(UpdateProfileRequest $request)
    {
        // Kiểm tra xem dữ liệu có đúng không
        try {
            $data = $request->validated();
            $user = auth()->user();
            $newUser = User::find($user->id);
    
            // Cập nhật thông tin người dùng
            $newUser->update($data);
    
            return response()->json(['success' => true, 'message' => 'Thông tin cập nhật thành công']);
        } catch (\Exception $e) {
            // Log lỗi chi tiết nếu có
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi cập nhật thông tin']);
        }
    }
    
}

