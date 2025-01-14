<?php

namespace App\Http\Controllers;

use App\Events\NewOrderEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Province;
use App\Models\City;
use App\Models\Ward;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Payment_Methods;
use App\Http\Requests\PlaceOrderRequest;
use App\Mail\OrderShipped;
use App\Models\CartItems;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\ProductVariants;
use Illuminate\Support\Facades\Mail;
use App\Events\ProductStockUpdated;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{

    // Method lấy thông tin đơn hàng từ session
    // hàm tính phí vận chuyển
    private function calculateShippingFee($total_weight,$totalAmount)
    {
        // Xử lý mức phí vận chuyển dựa trên trọng lượng sản phẩm (có thể cứng hóa giá trị trong code)
        if($totalAmount >= 6000000){
            return 0; //freeship
        }

        if ($total_weight <= 1) {
            return 15000; 
        } elseif ($total_weight <= 2) {
            return 25000; 
        } elseif ($total_weight <= 5) {
            return 40000; 
        } else{
            return 50000;
        }
    }

    public function Checkout()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước');
        }

        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return redirect()->route('shop')->with('error', 'Vui lòng chọn sản phẩm trước khi thanh toán');
        }

        
        $cartItems = CartItems::with('variants.product', 'variants.size')->where('cart_id', $cart->id)->get();
        
       

        // Kiểm tra nếu giỏ hàng không có sản phẩm nào
        if ($cartItems->isEmpty()) {
            return redirect()->route('shop')->with('error', 'Vui lòng chọn sản phẩm trước khi thanh toán');
        }

        // Kiểm tra số lượng tồn kho
        foreach ($cartItems as $item) {
            $variant = $item->variants;
            if ($variant->stock < $item->quantity) {
                return redirect()->route('cart')->with('error', "Sản phẩm '{$variant->product->name}' chỉ còn lại {$variant->stock} cái. Vui lòng cập nhật lại giỏ hàng.");
            }
        }

        // Tính tổng trọng lượng cho tất cả các sản phẩm trong giỏ hàng
        $total_weight = 0; // Khởi tạo tổng trọng lượng

        $cartItems = $cartItems->map(function ($item) use (&$total_weight) {
            $variant = $item->variants;
            $product = $variant->product;

            // thể tích 
            $volume = $variant->height * $variant->length * $variant->width/3000;
            $total_weight += $volume * $item->quantity;
            
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

        $province = Province::orderBy('matinh', 'asc')->get();
        $payment = Payment_Methods::all();
        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();

        
        $totalAmount = session('totalAmount',0);

        $shipping = $this->calculateShippingFee($total_weight,$totalAmount);

        // lưu phí ship vào trong session
        session(['shipping' => $shipping]);

        // Kiểm tra session newTotalCheckout
        $finalTotal = session('newTotalCheckout', null);

        if ($finalTotal === null) {
            // Nếu không có newTotalCheckout, lấy tổng tiền từ giỏ hàng và cộng phí vận chuyển
            $totalAmount = session('newTotal', 0);
            if(!$totalAmount){
                $totalAmount = $cartItems->sum('total_price');
                session(['totalAmount'=>$totalAmount]);
            }
            $finalTotal = $totalAmount + $shipping; // Tổng tiền giỏ hàng + phí ship
        }

        // Lưu tổng tiền cuối cùng vào session
        session(['finalTotal' => $totalAmount]);
    
        return view('client.pages.checkout', compact('cartItems', 'user', 'province', 'payment', 'shipping', 
            'list_brand','list_category','finalTotal'
        ));
    }

    public function selectProvince(Request $request)
    {

        try {

            $data = $request->all();

            $province = $data['province'];

            $citys = City::where('matinh', $province)->get();

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

    public function selectCity(Request $request)
    {
        try {

            $data = $request->all();

            $city = $data['city'];

            $wards = Ward::where('macity', $city)->get();

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

    // đặt hàng
    public function placeOrder(PlaceOrderRequest $request)
    {
        try {

            DB::beginTransaction(); // Bắt đầu transaction

            $data = $request->validated();

            // Tạo đơn hàng
            // Lấy thông tin giỏ hàng của người dùng
            $cart = Cart::where('user_id', auth()->id())->first();

            $couponId = session('coupon_id', null);
            $totalAmount = session('totalAmount', 0);
            $discountAmount = session('discount', 0);
            $shipping = session('shipping', 0);


            // hàm lockForupdate dùng để khóa bản ghi 
            $coupon = Coupon::where('id', $couponId)->lockForUpdate()->first();

            if($coupon){
                // Kiểm tra nếu mã giảm giá đã hết
                if ($coupon->usage_limit <= 0) {
                    session()->forget(['coupon_id', 'discount', 'newTotal', 'totalAmount']);
                    return response()->json(['error' => 'Mã giảm giá đã hết số lượng,vui lòng chọn mã khác.'], 400);
                }

                // Giảm số lượng mã giảm giá nếu có
            
                $coupon->decrement('usage_limit'); // Giảm số lượng khả dụng
                $coupon->increment('used_count'); // Tăng số lượng đã sử dụng
                $coupon->save();  

            }

            

            $cartItems = CartItems::with('variants.product', 'variants.size')->where('cart_id', $cart->id)->get();

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

                if ($productVariant->stock < $item->quantity) {
                    return response()->json(['message' => 'Số lượng sản phẩm không đủ.'], 400);
                }

                $productVariant->decrement('stock', $item->quantity);
                $productVariant->selled += $item->quantity;
                $productVariant->save();

                // Phát sự kiện cập nhật tồn kho
                broadcast(new ProductStockUpdated($productVariant->id, $productVariant->stock));

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
            Mail::to($data['recipient_email'])->queue(new OrderShipped($order, $orderAddress));

            session()->forget(['coupon_id', 'discount', 'newTotal', 'totalAmount']);

            // Lấy danh sách user có vai trò admin hoặc manager
            $adminsAndManagers = User::whereHas('roles', function($query) {
                $query->whereIn('name', ['admin', 'manager']);
            })->get();

            // Mảng chứa ID thông báo để phát sóng

            // Tạo thông báo cho mỗi admin hoặc manager
            $message = 'Có một đơn hàng mới với mã đơn hàng: ' . $order->id;
            foreach ($adminsAndManagers as $user) {
                $notification = Notification::create([
                    'user_id' => $user->id,  // Gửi thông báo cho user có vai trò admin hoặc manager
                    'title' => 'Đơn hàng mới',
                    'message' => $message,
                    'status' => 'unread',
                ]);

                broadcast(new NewOrderEvent($user, $notification)); // Gửi id thông báo cho từng user
            }
            
            if ($data['payment_method'] == 2) { // Giả sử 2 là ID của VNPAY
                $newTotal = $order->total_amount + $order->shipping_fee - $order->discount_amount;
                
                // Tạo bản ghi thanh toán trong transactions khi có giao dịch thanh toán
                Transactions::create([
                    'order_id' => $order->id,
                ]);

                DB::commit(); // Commit transaction nếu mọi thứ đều thành công

                // Lưu trạng thái đơn hàng vào session
                session(['order_status' => '1', 'order_id' => $order->id]);

                // Gọi hàm xử lý thanh toán VNPAY
                return $this->vnpayPayment($newTotal,$order->id);
            }

            DB::commit(); // Commit transaction nếu mọi thứ đều thành công


            // Trả về thông báo thành công
            return response()->json(
                ['message' => 'Đơn hàng đã được tạo thành công.'],
            );
        } catch (\Exception $e) {

            DB::rollBack(); // Rollback nếu có lỗi

            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    public function vnpayPayment($newTotal,$orderId){
        
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpayCallback');
        $vnp_TmnCode = "8BH5Y90V";//Mã website tại VNPAY 
        $vnp_HashSecret = "N14KVQSQUB63K18EERWUTT3Z5S1QQXIQ"; //Chuỗi bí mật
        
        $vnp_TxnRef = $orderId; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này , mã giao dịch
        $vnp_OrderInfo = 'Thanh toán vnpay';   //Thông tin đơn hàng
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $newTotal * 100;  // số tiền thanh toán đã được tính trước 
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

   
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return response()->json([
            'vnpay' => $vnp_Url,
        ]);

    }

    // retrun thông tin khi vnpay thanh toán thành công
    public function vnpayCallback(Request $request)
    {
        try {
            $data = $request->all();
            
            $vnp_TransactionStatus = $data['vnp_TransactionStatus'];
            $vnp_TxnRef = $data['vnp_TxnRef'];  // Mã đơn hàng
            
            // Lấy đơn hàng từ mã giao dịch
            $order = Order::find($vnp_TxnRef);
            $transaction = Transactions::where('order_id', $order->id)->first();    

            // Kiểm tra trạng thái thanh toán của VNPAY
            if ($vnp_TransactionStatus == '00') {
                // Thanh toán thành công
                $order->payment_status = 'paid';
                $order->status_id = 1;
                $status = 'success';  // Trạng thái giao dịch thành công
                // Cập nhật trạng thái thanh toán trong bảng transactions ngay lập tức
                if ($transaction) {
                    $transaction->status = $status;
                    $transaction->transaction_id = $data['vnp_TransactionNo'];
                    $transaction->payment_date = $data['vnp_PayDate'];
                    $transaction->amount = $data['vnp_Amount'] / 100;
                    $transaction->bank_code = $data['vnp_BankCode'];
                    $transaction->description = $data['vnp_OrderInfo'];
                    $transaction->save();
                }
            } else {
                // Thanh toán thất bại
                $order->payment_status = 'pending';
                $order->status_id = 1;
                $status = 'pending';  // Trạng thái giao dịch thất bại
                if($transaction){
                    $transaction->status = $status;
                    $transaction->transaction_id = $data['vnp_TransactionNo'];
                    $transaction->payment_date = $data['vnp_PayDate'];
                    $transaction->amount = $data['vnp_Amount'];
                    $transaction->bank_code = $data['vnp_BankCode'];
                    $transaction->description = $data['vnp_OrderInfo'];
                    $transaction->save();
                }
                $order->save();

                return redirect()->route('myAccount'); 
            }

            // Lưu thay đổi vào đơn hàng
            $order->save();

            // Điều hướng người dùng tới trang thành công
            return redirect()->route('thankyou');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    // thanh toán lại của vnpay , momo
    public function retryPayment(Request $request){

        $order = Order::findOrFail($request->order_id);

        // Kiểm tra trạng thái thanh toán và đơn hàng
        if ($order->payment_status === 'pending' && $order->status_id === 1 && $order->payment_method_id === 2) {
            // tổng đơn hàng
            $newTotal = $order->total_amount + $order->shipping_fee - $order->discount_amount;
            // Tạo liên kết thanh toán VNPAY
            return $this->vnpayPayment($newTotal,$order->id);
        }

        // if ($order->payment_status === 'pending' && $order->status_id === 1 && $order->payment_method_id === 3) {
        //     // tổng đơn hàng
        //     $newTotal = $order->total_amount + $order->shipping_fee - $order->discount_amount;
        //         // Tạo liên kết thanh toán momo
        //         $payUrl = $this->momoPayment($newTotal,$order->id);
        //         return response()->json([
        //             'message' => 'Liên kết thanh toán đã được tạo thành công.',
        //             'momo' => $payUrl,
        //         ]);
        // }

        return response()->json(['message' => 'Không thể thực hiện thanh toán lại'], 400);
    }

    // hàm của thanh toán momo
    // public function execPostRequest($url, $data)
    // {
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //             'Content-Type: application/json',
    //             'Content-Length: ' . strlen($data))
    //     );
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    //     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //     //execute post
    //     $result = curl_exec($ch);
    //     //close connection
    //     curl_close($ch);
    //     return $result;
    // }

    // public function momoPayment($newTotal,$id){
    //     $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    //     $partnerCode = 'MOMOBKUN20180529';
    //     $accessKey = 'klm05TvNBzhg7h7j';
    //     $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    //     $orderInfo = "Thanh toán qua MoMo";
    //     $amount = $newTotal;
    //     $orderId = $id.'_'.time();
    //     $redirectUrl = route('momoCallback');
    //     $ipnUrl = route('momoCallback');
    //     $extraData = "";


        
    //         $partnerCode = $partnerCode;
    //         $accessKey = $accessKey;
    //         $serectkey = $secretKey;
    //         $orderId = $orderId;
    //         $orderInfo = $orderInfo;
    //         $amount = $amount;
    //         $ipnUrl = $ipnUrl;
    //         $redirectUrl = $redirectUrl;
    //         $extraData = $extraData;

    //         $requestId = time() . "";
    //         $requestType = "payWithATM";
    //         // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //         //before sign HMAC SHA256 signature
    //         $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    //         $signature = hash_hmac("sha256", $rawHash, $serectkey);
    //         $data = array('partnerCode' => $partnerCode,
    //             'partnerName' => "Test",
    //             "storeId" => "MomoTestStore",
    //             'requestId' => $requestId,
    //             'amount' => $amount,
    //             'orderId' => $orderId,
    //             'orderInfo' => $orderInfo,
    //             'redirectUrl' => $redirectUrl,
    //             'ipnUrl' => $ipnUrl,
    //             'lang' => 'vi',
    //             'extraData' => $extraData,
    //             'requestType' => $requestType,
    //             'signature' => $signature);
    //         $result = $this->execPostRequest($endpoint, json_encode($data));
    //         $jsonResult = json_decode($result, true);  // decode json


    //         Log::info('Phản hồi từ MoMo:', ['result' => $result]);

    //         //Just a example, please check more in there

    //         // Kiểm tra phản hồi từ MoMo
    //         if (isset($jsonResult['payUrl'])) {
    //             return $jsonResult['payUrl']; // Trả về URL thanh toán
    //         } else {
    //             throw new \Exception('Không thể tạo liên kết thanh toán MoMo.');
    //         }
        
    // }

    // public function momoCallback(Request $request){
    //     try {
    //         $data = $request->all();

    //         $orderId = $data['orderId'];
    //         $orderId = explode("_",$orderId);
              
    //         // Lấy đơn hàng từ mã giao dịch
    //         $order = Order::find($orderId[0]);
    //         $transaction = Transactions::where('order_id', $order->id)->first();    

    //         // Kiểm tra trạng thái thanh toán của VNPAY
    //         if ($data['resultCode'] == '0') {
    //             // Thanh toán thành công
    //             $order->payment_status = 'paid';
    //             $order->status_id = 1;
    //             $status = 'success';  // Trạng thái giao dịch thành công
    //             // Cập nhật trạng thái thanh toán trong bảng transactions ngay lập tức
    //             if ($transaction) {
    //                 $transaction->status = $status;
    //                 $transaction->transaction_id = $data['transId'];
    //                 $transaction->payment_date = Carbon::now();
    //                 $transaction->amount = $data['amount'];
    //                 $transaction->bank_code = $data['payType'];
    //                 $transaction->description = $data['orderInfo'];
    //                 $transaction->save();
    //             }
    //         } else {
    //             // Thanh toán thất bại
    //             $order->payment_status = 'pending';
    //             $order->status_id = 1;
    //             $status = 'pending';  // Trạng thái giao dịch thất bại
    //             if($transaction){
    //                 $transaction->status = $status;
    //                 $transaction->transaction_id = $data['transId'];
    //                 $transaction->payment_date = Carbon::now();
    //                 $transaction->amount = $data['amount'];
    //                 $transaction->bank_code = $data['payType'];
    //                 $transaction->description = $data['orderInfo'];
    //                 $transaction->save();
    //             }
    //             $order->save();

    //             return redirect()->route('myAccount');
    //         }

    //         // Lưu thay đổi vào đơn hàng
    //         $order->save();

    //         // Điều hướng người dùng tới trang thành công
    //         return redirect()->route('thankyou');
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
    //     }
    // }   

}
