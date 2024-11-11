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
use App\Mail\OrderShipped;
use App\Models\CartItems;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\ProductVariants;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{   

    private function calculateShippingFee($total_weight)
    {
        // Xử lý mức phí vận chuyển dựa trên trọng lượng sản phẩm (có thể cứng hóa giá trị trong code)
        if ($total_weight >=0  && $total_weight <= 0.7) {
            return 15000;
        } elseif ($total_weight > 0.7 && $total_weight <= 1.5) {
            return 25000;  // Phí vận chuyển cho trọng lượng từ 5kg đến 10kg là 100
        } elseif ($total_weight > 1.5 && $total_weight < 5 ) {
            return 40000;  // Phí vận chuyển cho trọng lượng từ 10kg đến 20kg là 150
        } else {
            return 0;  // Phí vận chuyển cho trọng lượng trên 20kg là 200
        }
    }

    public function Checkout(){
        $user = Auth::user();
        if(!$user){
            return redirect()->route('login')->with('error','Vui lòng đăng nhập trước');
        }

        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->first();

        $cartItems = CartItems::with('variants.product','variants.size')->where('cart_id',$cart->id)->get();
        
        // Tính tổng trọng lượng cho tất cả các sản phẩm trong giỏ hàng
        $total_weight = 0; // Khởi tạo tổng trọng lượng

        $cartItems = $cartItems->map(function($item) use (&$total_weight) {
            $variant = $item->variants;
            $product = $variant->product;

            
            $total_weight += $variant->weight * $item->quantity ;

        
            return [
                'id' => $item->id,
                'variant_id' => $variant->id,
                'name' => $product->name,
                'image' =>  asset($product->image),
                'price' => $variant->price,
                'quantity' => $item->quantity,
                'size' => $variant->size->name,
                'total_price' => $variant->price * $item->quantity,
            ];



        });

        $province = Province::orderBy('matinh','asc')->get();
        $payment = Payment_Methods::all();  

        $shipping = $this->calculateShippingFee($total_weight);
        session(['shipping'=>$shipping]);

        $newTotal = session('newTotal',0) - $shipping;

        
        return view('client.pages.checkout',compact('cartItems','user','province','payment','shipping','newTotal'));
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
            $cart = Cart::where('user_id', auth()->id())->first();

            $couponId = session('coupon_id',null);
            $totalAmount = session('totalAmount',0);
            $discountAmount = session('discount',0);
            $shipping = session('shipping',0);


            $cartItems = CartItems::with('variants.product','variants.size')->where('cart_id',$cart->id)->get();

            // Tạo đơn hàng mới
            $order = Order::create([
                'user_id' => auth()->id(),
                'status_id' => 1, // Đang chờ xử lý
                'total_amount' => $totalAmount,
                'coupon_id' => $couponId,
                'discount_amount' => $discountAmount,
                'shipping_fee' => $shipping,
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
            foreach ($cartItems as $item) {

                // giảm số lượng khi đặt hàng
                // decrement hàm có trong orm của laravel dùng để làm giảm 1 cột cụ thể trong bảng
                $productVariant = ProductVariants::find($item->product_variant_id);
                $productVariant->decrement('stock', $item->quantity);
                $productVariant->save();


                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $productVariant->price,
                    'product_name' => $productVariant->product->name,
                    'product_image' => $productVariant->product->image,
                    'size' => $productVariant->size->name,
                ]);
            }

            // Eager load các quan hệ: 'payment' và 'orderItems'
            $order = $order->load('payment', 'cartItems');

            // Xóa giỏ hàng của người dùng
            $cart->delete();

            // Kiểm tra null trước khi gửi email
            if (!$order || !$orderAddress) {
                return response()->json(['message' => 'Không tìm thấy đơn hàng hoặc địa chỉ giao hàng.'], 404);
            }
            

            // Gửi email xác nhận đơn hàng
            Mail::to($data['recipient_email'])->queue(new OrderShipped($order,$orderAddress));

            session()->forget(['coupon_id', 'discount', 'newTotal','totalAmount']);

            // Trả về thông báo thành công
            return response()->json(
                ['message' => 'Đơn hàng đã được tạo thành công.'],
            );
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }
}
