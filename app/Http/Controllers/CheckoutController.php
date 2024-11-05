<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Province;
use App\Models\City;
use App\Models\Ward;

use App\Models\Payment_Methods;
use App\Http\Requests\PlaceOrderRequest;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\ProductVariants;

class CheckoutController extends Controller
{
    public function Checkout(){
        $user = Auth::user();
        if(!$user){
            return redirect()->route('login')->with('error','Vui lòng đăng nhập trước');
        }

        // Tìm giỏ hàng của người dùng
        $cart = Cart::with('cartItem')->where('user_id', $user->id)->first();

         // Tính tổng tiền của các sản phẩm trong giỏ hàng
         $totalAmount = 0;

         if ($cart && $cart->cartItem) {
             foreach ($cart->cartItem as $item) {
                 $totalAmount += $item->product_price * $item->quantity; // Tính tổng tiền
             }
         }

        $province = Province::orderBy('matinh','asc')->get();
        $payment = Payment_Methods::all();
        
        return view('client.pages.checkout',compact('cart','totalAmount','user','province','payment'));
    }

    public function selectProvince(Request $request){

        try {
            
            $data = $request->all();

            $province = $data['province'];
    
            $citys = City::where('matinh',$province)->get();
    
            // Trả về danh sách thành phố dưới dạng JSON
            

            return response()->json([
                'message' => 'Lấy danh sách thành phố thành công',
                'citys' => $citys,
            ]);

        } catch (\Exception $e) {
            // Bắt lỗi và trả về thông điệp lỗi
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
        
       
    }

    public function selectCity(Request $request){
        try {
            
            $data = $request->all();

            $city = $data['city'];
    
            $wards = Ward::where('macity',$city)->get();
    
            // Trả về danh sách thành phố dưới dạng JSON
            

            return response()->json([
                'message' => 'Lấy danh sách phường thành công',
                'wards' => $wards,
            ]);

        } catch (\Exception $e) {
            // Bắt lỗi và trả về thông điệp lỗi
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    public function placeOrder(PlaceOrderRequest $request){
        try {
            $data = $request->validated();

            // Tạo đơn hàng
            // Lấy thông tin giỏ hàng của người dùng
            $cart = Cart::with('cartItem')->where('user_id', auth()->id())->first();

            $total_amount = 0;
            foreach($cart->cartItem as $ca){
                $total_amount += $ca->product_price *  $ca->quantity;
            }

            // Tạo đơn hàng mới
            $order = Order::create([
                'user_id' => auth()->id(),
                'status_id' => 1, // Đang chờ xử lý
                'total_amount' => $total_amount,
                'payment_method_id' => $data['payment_method'],
            ]);

            // Tạo địa chỉ giao hàng
            $orderAddress = OrderAddress::create([
                'order_id' => $order->id,
                'address_order' => $data['address_order'],
                'city' => $data['city'],
                'province' => $data['province'],
                'ward' => $data['ward'],
                'phone_number' => $data['phone_number'],
                'recipient_name' => $data['recipient_name'],
                'recipient_email' => $data['recipient_email'],

            ]);

            // Tạo các mục trong đơn hàng
            foreach ($cart->cartItem as $cartItem) {

                // giảm số lượng khi đặt hàng
                // decrement hàm có trong orm của laravel dùng để làm giảm 1 cột cụ thể trong bảng
                $productVariant = ProductVariants::find($cartItem->product_variant_id);
                $productVariant->decrement('stock', $cartItem->quantity);
                $productVariant->save();


                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $cartItem->product_variant_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product_price,
                    'product_name' => $cartItem->product_name,
                    'product_image' => $cartItem->product_image,
                    'size' => $cartItem->size,
                ]);
            }

            // Xóa giỏ hàng của người dùng
            $cart->delete();

            // Trả về thông báo thành công
            return response()->json(
                ['message' => 'Đơn hàng đã được tạo thành công.'],
            );
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Đặt hàng không thành công.'], 500);
        }
    }
}
