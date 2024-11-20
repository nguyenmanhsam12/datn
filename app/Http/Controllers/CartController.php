<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Coupon;
use App\Models\ProductVariants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

    // Cập nhật tổng tiền vào session khi thay đổi giỏ hàng
    public function updateCartSession($cartId)
    {
        $cartItems = CartItems::where('cart_id', $cartId)->with('variants')->get();

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->variants->price * $item->quantity;
        });

        // Lưu tổng tiền vào session
        session(['totalAmount' => $totalAmount]);
    }

    // lấy ra các sp trong giỏ hàng
    public function cart()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước'); // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
        }

        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->first();

        // Kiểm tra nếu giỏ hàng không tồn tại
        if (!$cart) {
            return view('client.pages.cart', ['cartItems' => [], 'totalAmount' => 0]); // Nếu không có giỏ hàng
        }

        // Truy vấn trực tiếp vào bảng cartItems và kết hợp với variants và products
        $cartItems = CartItems::where('cart_id', $cart->id)
            ->with(['variants.product', 'variants.size']) // Eager load variants và product cho cartItems
            ->get();

        // Map các cartItems để lấy thông tin sản phẩm
        $cartItems = $cartItems->map(function ($item) {

            $variant = $item->variants; // Lấy variant từ cartItem
            // Kiểm tra và lấy thông tin sản phẩm
            $product = $variant->product;
            $size = $variant->size;

            // Truy cập trực tiếp vào thuộc tính 'name'
            $productName = $product ? $product->name : 'Tên sản phẩm không tồn tại';
            $price = $variant ? $variant->price : 0;

            return [
                'id' => $item->id,
                'variant_id' => $item->product_variant_id,
                'name' => $productName,
                'price' => $price,
                'quantity' => $item->quantity,
                'size' => $size->name,
                'image' => asset($product->image),
                'total_price' => $price * $item->quantity,
            ];
        });



        // Tính tổng tiền của giỏ hàng
        $totalAmount = $cartItems->sum('total_price');



        // Lưu tổng giỏ hàng vào session
        session(['totalAmount' => $totalAmount]);

        // giá trị của tổng đơn hàng
        $newTotal = session('newTotal', $totalAmount);


        return view('client.pages.cart', compact('cart', 'cartItems', 'newTotal'));
    }

    // thêm giỏ hàng
    public function addToCart(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'error' => 'Vui lòng đăng nhập trước',
            ]); // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
        }

        // Kiểm tra dữ liệu từ request
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            // Tìm giỏ hàng của người dùng
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            // Kiểm tra xem sản phẩm (variant) đã có trong giỏ hàng chưa
            $cartItem = CartItems::where('cart_id', $cart->id)
                ->where('product_variant_id', $request->variant_id)
                ->first();

            if ($cartItem) {
                // Nếu đã có, cập nhật số lượng
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
                $variant = ProductVariants::with('product')->find($request->variant_id); // Lấy thông tin sp

                // Tạo mới CartItem
                $cartItem = new CartItems();
                $cartItem->cart_id = $cart->id;
                $cartItem->product_variant_id = $request->variant_id;
                $cartItem->quantity = $request->quantity;
                $cartItem->save();
            }

            // Cập nhật lại tổng tiền giỏ hàng vào session
            $this->updateCartSession($cart->id);

            // Tính tổng số lượng sản phẩm trong giỏ hàng
            $cartItemCount = CartItems::where('cart_id', $cart->id)->sum('quantity');

            $totalCartPrice = session('totalAmount', 0);

            // Kiểm tra và tính lại giảm giá nếu có mã giảm giá đã áp dụng
            $discount = 0;
            $coupon_id = session('coupon_id');
            if ($coupon_id) {
                $coupon = Coupon::find($coupon_id);
                if ($coupon && $totalCartPrice >= $coupon->minimum_order_value) {
                    // Tính lại giảm giá
                    if ($coupon->discount_type === 'percentage') {
                        $discount = $totalCartPrice * ($coupon->discount_value / 100);
                    } else {
                        $discount = $coupon->discount_value;
                    }
                } else {
                    // Nếu tổng tiền không đủ điều kiện, bỏ giảm giá
                    session()->forget(['discount', 'coupon_id']);
                }
            }

            // Lưu tổng tiền và giảm giá vào session
            session(['totalAmount' => $totalCartPrice, 'discount' => $discount]);

            // Tính tổng tiền cuối cùng sau khi áp dụng giảm giá
            $finalTotalPrice = $totalCartPrice - $discount;

            // Lưu tổng tiền cuối cùng vào session với khóa `newTotal`
            session(['newTotal' => $finalTotalPrice]);

            return response()->json([
                'message' => 'Thêm giỏ hàng thành công',
                'cart_item' => $cartItem,
                'cartItemCount' => $cartItemCount,
            ]);
        } catch (\Exception $e) {
            // Bắt lỗi và trả về thông điệp lỗi
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    // lấy tổng số lượng đang có trong giỏ hàng
    public function getCartItemCount()
    {
        $user = Auth::user();
        $totalItems = 0;

        // Kiểm tra nếu người dùng đã đăng nhập
        if ($user) {
            // Lấy giỏ hàng của người dùng
            $cart = Cart::with('cartItem')->where('user_id', $user->id)->first();


            // Kiểm tra nếu giỏ hàng tồn tại và đếm tổng số lượng sản phẩm trong bảng `cart_items`
            $totalItems = $cart ? $cart->cartItem->sum('quantity') : 0;
            // lấy tất cả sp trong giỏ hàng

        }

        return response()->json([
            'totalItems' => $totalItems,
        ]);
    }


    // xóa 1 sp trong giỏ hàng
    public function removeFromCart(Request $request)
    {
        $cartItems = CartItems::find($request->cart_item_id);

        if (!$cartItems) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại trong giỏ hàng'
            ]);
        }

        $cartItems->delete();

        // Cập nhật lại tổng tiền giỏ hàng vào session
        $this->updateCartSession($cartItems->cart_id);

        // lấy tổng số lượng để hiển thị lên icon
        $cart_items = CartItems::with('variants')->where('cart_id', $cartItems->cart_id)->get();
        $newQuantityCart = $cart_items->sum('quantity');


        // Lấy tổng tiền từ session
        $totalCartPrice = session('totalAmount', 0);

        // Kiểm tra và tính lại giảm giá nếu có mã giảm giá đã áp dụng
        $discount = 0;
        $coupon_id = session('coupon_id');
        if ($coupon_id) {
            $coupon = Coupon::find($coupon_id);
            if ($coupon && $totalCartPrice >= $coupon->minimum_order_value) {
                // Tính lại giảm giá
                if ($coupon->discount_type === 'percentage') {
                    $discount = $totalCartPrice * ($coupon->discount_value / 100);
                } else {
                    $discount = $coupon->discount_value;
                }
            } else {
                // Nếu tổng tiền không đủ điều kiện, bỏ giảm giá
                session()->forget(['discount', 'coupon_id']);
            }
        }

        // Lưu tổng tiền và giảm giá vào session
        session(['totalAmount' => $totalCartPrice, 'discount' => $discount]);

        // Tính tổng tiền cuối cùng sau khi áp dụng giảm giá
        $finalTotalPrice = $totalCartPrice - $discount;

        // Lưu tổng tiền cuối cùng vào session với khóa `newTotal`
        session(['newTotal' => $finalTotalPrice]);


        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
            'newQuantityCart' => $newQuantityCart,
            'newTotalAmount' => $totalCartPrice, // Trả về tổng tiền mới
            'discount' => $discount,
        ]);
    }

    // Tăng số lượng
    public function increaseQuantity(Request $request)
    {
        $data = $request->all();

        // id của chi tiết giỏ hàng
        $cartItemId = $data['cart_item_id'];

        // Tìm CartItem và lấy product_variant_id
        $cartItem = CartItems::with('variants')->findOrFail($cartItemId);

        // Lưu lại số lượng ban đầu trước khi giảm
        $originalQuantity = $cartItem->quantity;

        // Kiểm tra xem số lượng trong giỏ hàng có vượt quá số lượng tồn kho không
        if ($cartItem->quantity + 1 > $cartItem->variants->stock) {
            return response()->json([
                'error' => 'Số lượng yêu cầu vượt quá số lượng sản phẩm còn lại trong kho.',
            ], 400); // Trả về lỗi nếu số lượng vượt quá tồn kho
        }

        // Tăng số lượng lên 1
        $cartItem->quantity += 1;

        // Tính lại thành tiền cho sản phẩm
        $total_price = 0;
        $total_price = $cartItem->variants->price * $cartItem->quantity;

        $cartItem->save();

        // Tính lại tổng số lượng trên icon giỏ hàng
        $cartItems = CartItems::where('cart_id', $cartItem->cart_id)->get();
        $quantityCartIcon  = $cartItems->sum('quantity');

        // Tính tổng tiền của tất cả các sản phẩm trong giỏ hàng
        $this->updateCartSession($cartItem->cart_id);
        $totalCartPrice = session('totalAmount', 0);

        // Kiểm tra và tính lại giảm giá nếu có mã giảm giá đã áp dụng
        $discount = 0;
        $coupon_id = session('coupon_id');
        if ($coupon_id) {
            $coupon = Coupon::find($coupon_id);
            if ($coupon && $totalCartPrice <= $coupon->maximum_discount	) {
                // Tính lại giảm giá
                if ($coupon->discount_type === 'percentage') {
                    $discount = $totalCartPrice * ($coupon->discount_value / 100);
                } else {
                    $discount = $coupon->discount_value;
                }
            } else {
                 // Khôi phục lại số lượng cũ nếu điều kiện không thỏa mãn
                 $cartItem->quantity = $originalQuantity;
                 $cartItem->save(); // Cập nhật lại cơ sở dữ liệu với số lượng ban đầu
 
                 return response()->json([
                     'error' => 'Vui lòng giảm số lượng để đủ điều kiện áp mã',
                     'quantity' => $cartItem->quantity, // Trả lại số lượng ban đầu
                     'totalPrice' => $total_price,
                     'quantityCartIcon' => $quantityCartIcon,
                     'totalCartPrice' => $totalCartPrice,
                 ], 400);
            }
        }

        // Lưu tổng tiền và giảm giá vào session
        session(['totalAmount' => $totalCartPrice, 'discount' => $discount]);

        // Tính tổng tiền cuối cùng sau khi áp dụng giảm giá
        $finalTotalPrice = $totalCartPrice - $discount;

        // Lưu tổng tiền cuối cùng vào session với khóa `newTotal`
        session(['newTotal' => $finalTotalPrice]);


        // Trả về JSON response với số lượng và tổng tiền mới
        return response()->json([
            'quantity' => $cartItem->quantity,
            'totalPrice' => $total_price,
            'quantityCartIcon' => $quantityCartIcon,
            'totalCartPrice' => $finalTotalPrice,
            'total' => $totalCartPrice,
            'discount' => $discount,
        ]);
    }

    // Giảm số lượng
    public function decreaseQuantity(Request $request)
    {
        $data = $request->all();

        $cartItemId = $data['cart_item_id'];

        // Tìm CartItem và lấy product_variant_id
        $cartItem = CartItems::with('variants')->findOrFail($cartItemId);

        // Lưu lại số lượng ban đầu trước khi giảm
        $originalQuantity = $cartItem->quantity;

        // Kiểm tra nếu số lượng lớn hơn 1 thì mới giảm
        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;

            // Tính lại thành tiền cho sản phẩm
            $total_price = 0;
            $total_price = $cartItem->variants->price * $cartItem->quantity;
            $cartItem->save();
        } else {
            // Nếu không thể giảm số lượng, trả về lỗi
            return response()->json([
                'error' => 'Số lượng sản phẩm không thể giảm thêm.',
            ], 400);
        }


        // đếm lại toàn bộ số lượng có trong giỏ hàng
        $cartItems = CartItems::where('cart_id', $cartItem->cart_id)->get();
        $quantityCartIcon  = $cartItems->sum('quantity');

        // Tính tổng tiền của tất cả các sản phẩm trong giỏ hàng
        $this->updateCartSession($cartItem->cart_id);
        $totalCartPrice = session('totalAmount', 0);

        // Kiểm tra và tính lại giảm giá nếu có mã giảm giá đã áp dụng
        $discount = 0;
        $coupon_id = session('coupon_id');
        if ($coupon_id) {
            $coupon = Coupon::find($coupon_id);

            if ($coupon && $totalCartPrice >= $coupon->minimum_order_value) {
                // Tính lại giảm giá
                if ($coupon->discount_type === 'percentage') {
                    $discount = $totalCartPrice * ($coupon->discount_value / 100);
                } else {
                    $discount = $coupon->discount_value;
                }
            } else {

                // Khôi phục lại số lượng cũ nếu điều kiện không thỏa mãn
                $cartItem->quantity = $originalQuantity;
                $cartItem->save(); // Cập nhật lại cơ sở dữ liệu với số lượng ban đầu

                return response()->json([
                    'error' => 'Tổng đơn hàng không đủ điều kiện áp dụng mã giảm giá.',
                    'quantity' => $cartItem->quantity, // Trả lại số lượng ban đầu
                    'totalPrice' => $total_price,
                    'quantityCartIcon' => $quantityCartIcon,
                    'totalCartPrice' => $totalCartPrice,
                ], 400);
            }
        }

        // Lưu tổng tiền và giảm giá vào session
        session(['totalAmount' => $totalCartPrice, 'discount' => $discount]);

        // Tính tổng tiền cuối cùng sau khi áp dụng giảm giá
        $finalTotalPrice = $totalCartPrice - $discount;

        // Lưu tổng tiền cuối cùng vào session với khóa `newTotal`
        session(['newTotal' => $finalTotalPrice]);


        // Trả về JSON response với số lượng và tổng tiền mới
        return response()->json([
            'quantity' => $cartItem->quantity,
            'totalPrice' => $total_price,
            'quantityCartIcon' => $quantityCartIcon,
            'total' => $totalCartPrice,
            'totalCartPrice' => $finalTotalPrice,
            'discount' => $discount,
        ]);
    }

    // số lượng focus từ ô input
    public function updateQuantity(Request $request)
    {
        // Kiểm tra xem 'cart_item_id' và 'quantity' có được gửi không
        $validated = $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItemId = $request->cart_item_id;
        $quantity = $request->quantity;

        // Lấy thông tin về sản phẩm trong giỏ hàng
        $cartItem = CartItems::with('variants')->find($cartItemId);

        // lưu trữ số lượng ban đầu
        $originalQuantity = $cartItem->quantity;


        // Kiểm tra nếu số lượng yêu cầu không vượt quá số lượng tồn kho
        if ($quantity > $cartItem->variants->stock) {
            return response()->json([
                'error' => 'Số lượng yêu cầu vượt quá số lượng sản phẩm còn lại trong kho.',
                'max_quantity' => $cartItem->variants->stock,
            ], 400); // Trả về lỗi nếu số lượng quá lớn
        }

        // Cập nhật số lượng trong giỏ hàng
        $cartItem->quantity = $quantity;
        $cartItem->save();

        // Tính lại thành tiền cho sản phẩm trong giỏ hàng
        $totalPrice = $cartItem->quantity * $cartItem->variants->price;

        // cập nhập lại số lượng trên icon
        $cartItems = CartItems::where('cart_id', $cartItem->cart_id)->get();
        $quantityCartIcon  = $cartItems->sum('quantity');

        // Tính tổng tiền của tất cả các sản phẩm trong giỏ hàng
        $this->updateCartSession($cartItem->cart_id);
        $totalCartPrice = session('totalAmount', 0);

        // Kiểm tra và tính lại giảm giá nếu có mã giảm giá đã áp dụng
        $discount = 0;
        $coupon_id = session('coupon_id');
        if ($coupon_id) {
            $coupon = Coupon::find($coupon_id);
            // Kiểm tra nếu tổng tiền >= giá trị tối thiểu áp dụng mã
            if ($totalCartPrice < $coupon->minimum_order_value) {
                $cartItem->quantity = $originalQuantity;
                $cartItem->save();

                return response()->json([
                    'error' => 'Vui lòng tăng thêm số lượng để đủ điều kiện áp mã.',
                    'quantity' => $cartItem->quantity,
                    'totalPrice' => $totalPrice,
                    'quantityCartIcon' => $quantityCartIcon,
                    'totalCartPrice' => $totalCartPrice,
                ], 400);
            }

            // Kiểm tra nếu tổng tiền <= giá trị tối đa áp dụng mã (nếu có)
            $maximumDiscount = $coupon->maximum_discount ?? PHP_INT_MAX; // Nếu null, mặc định là không giới hạn
            if ($totalCartPrice > $maximumDiscount) {
                $cartItem->quantity = $originalQuantity;
                $cartItem->save();

                return response()->json([
                    'error' => 'Vui lòng giảm số lượng để đủ điều kiện áp mã.',
                    'quantity' => $cartItem->quantity,
                    'totalPrice' => $totalPrice,
                    'quantityCartIcon' => $quantityCartIcon,
                    'totalCartPrice' => $totalCartPrice,
                ], 400);
            }

            // Tính giảm giá nếu đủ điều kiện
            if ($coupon->discount_type === 'percentage') {
                $discount = $totalCartPrice * ($coupon->discount_value / 100);
            } else {
                $discount = $coupon->discount_value;
            }
        }

        // Lưu tổng tiền và giảm giá vào session
        session(['totalAmount' => $totalCartPrice, 'discount' => $discount]);

        // Tính tổng tiền cuối cùng sau khi áp dụng giảm giá
        $finalTotalPrice = $totalCartPrice - $discount;

        // Lưu tổng tiền cuối cùng vào session với khóa `newTotal`
        session(['newTotal' => $finalTotalPrice]);

        // Trả về kết quả
        return response()->json([
            'quantity' => $cartItem->quantity,
            'totalPrice' => $totalPrice,
            'quantityCartIcon' => $quantityCartIcon,
            'totalCartPrice' => $finalTotalPrice,
            'total' => $totalCartPrice,
            'discount' => $discount,
        ]);
    }

    // áp mã giảm giá
    public function applyCoupon(Request $request)
    {
        $data = $request->all();

        // Kiểm tra xem mã giảm giá có tồn tại hay không
        $coupon = Coupon::where('code', $data['code'])->first();

        if (!$coupon) {
            return response()->json([
                'error' => 'Mã giảm giá không tồn tại!'
            ]);
        }

        // Kiểm tra xem mã giảm giá có còn hạn hay không
        if ($coupon->isExpired()) {
            return response()->json([
                'error' => 'Mã giảm giá đã hết hạn!'
            ]);
        }

        // Kiểm tra trạng thái mã giảm giá
        if ($coupon->status !== 'active') {
            return response()->json([
                'error' => 'Mã giảm giá này đã bị vô hiệu hóa!'
            ]);
        }

        // Lấy tổng tiền từ session (đã lưu trước đó khi thêm sản phẩm vào giỏ)
        $totalAmount = session('totalAmount', 0);

        // Kiểm tra tổng tiền có đủ để áp dụng mã giảm giá không
        if ($totalAmount <= 0 || $totalAmount < $coupon->minimum_order_value || $totalAmount > $coupon->maximum_discount) {
            return response()->json([
                'error' => 'Tổng giỏ hàng không đủ để áp dụng mã giảm giá!'
            ]);
        }

        // Tính toán giảm giá
        $discount = 0;
        if ($coupon->discount_type === 'percentage') {
            $discount = $totalAmount * ($coupon->discount_value / 100);
        } else {
            $discount = $coupon->discount_value; // Mã giảm giá theo số tiền cố định
        }

        // tổng tiền mới sau khi áp mã
        $newTotal = $totalAmount - $discount;

        // Lưu mã giảm giá vào session (sử dụng session helper)
        session(['discount' => $discount, 'newTotal' => $newTotal, 'coupon_id' => $coupon->id]);

        // Trả về kết quả cho người dùng
        return response()->json([
            'success' => true,
            'message' => 'Mã giảm giá đã được áp dụng!',
            'new_total' => $newTotal,
            'discount' => $discount,
        ]);
    }

    public function removeCoupon(Request $request)
    {
        // Xóa thông tin mã giảm giá khỏi session
        session()->forget(['discount', 'newTotal', 'coupon_id']);

        // Trả lại tổng tiền ban đầu
        $originalTotal = session('totalAmount', 0);

        return response()->json([
            'success' => true,
            'original_total' => $originalTotal
        ]);
    }
}
