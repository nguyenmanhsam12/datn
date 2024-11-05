<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\ProductVariants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function cart()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước'); // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
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



        return view('client.pages.cart', compact('cart', 'totalAmount'));
    }

    public function addToCart(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước'); // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
        }

        // Kiểm tra dữ liệu từ request
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required',
            'price' => 'required',
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
                $cartItem->product_price = $request->price; // Giá của biến thể
                $cartItem->product_name = $variant->product->name; // Lưu tên sản phẩm
                $cartItem->product_image = $variant->product->image;  // Lưu hình ảnh sản phẩm
                $cartItem->size = $request->size; // Lưu kích thước (giả sử bạn có mối quan hệ size)
                $cartItem->save();
            }

            // Tính tổng số lượng sản phẩm trong giỏ hàng
            $cartItemCount = CartItems::where('cart_id', $cart->id)->sum('quantity');

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

    public function getCartItemCount()
    {
        $user = Auth::user();
        $totalItems = 0;
        $totalPrice = 0;
        $cartItems = [];
        // Kiểm tra nếu người dùng đã đăng nhập
        if ($user) {
            // Lấy giỏ hàng của người dùng
            $cart = Cart::where('user_id', $user->id)->first();

            // Kiểm tra nếu giỏ hàng tồn tại và đếm tổng số lượng sản phẩm trong bảng `cart_items`
            $totalItems = $cart ? CartItems::sum('quantity') : 0;
            // lấy tất cả sp trong giỏ hàng
            $cartDetails = CartItems::where('cart_id', $cart->id)->get();

            $totalPrice = $cartDetails->sum(function ($item) {
                return $item->quantity * $item->product_price;
            });

            $cartItems = $cartDetails->map(function ($item) {
                return [
                    'id' => $item->id,  
                    'name' => $item->product_name,
                    'price' => $item->product_price,
                    'quantity' => $item->quantity,
                    'size' => $item->size,
                    'image' => asset($item->product_image) // Thay đổi đường dẫn hình ảnh
                ];
            });
        } else {
            $totalItems = 0; // Nếu người dùng chưa đăng nhập, số lượng là 0
        }

        return response()->json([
            'totalItems' => $totalItems,
            'totalPrice' => $totalPrice,
            'cartItems' => $cartItems,
        ]);
    }

    public function updateCartQuantity(Request $request)
    {
        try {
            // Xác thực dữ liệu đầu vào
            $data = $request->validate([
                'cart_item_id' => 'required|integer|exists:cart_items,id',
                'product_variant_id' => 'required|integer|exists:product_variants,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Lấy thông tin từ request
            $cartItemId = $data['cart_item_id'];
            $productVariantId = $data['product_variant_id'];
            $quantity = $data['quantity'];

            // Tìm kiếm cart_item bằng ID
            $cartItem = CartItems::find($cartItemId);

            if ($cartItem) {
                // Cập nhật số lượng
                $cartItem->quantity = $quantity;
                $cartItem->save(); // Lưu lại thay đổi

                // Tính toán tổng số tiền cho sản phẩm

                $subtotal = $cartItem->quantity * $cartItem->product_price;

                $newQuantityCart = CartItems::sum('quantity'); 

                // Trả về response JSON
                return response()->json([
                    'success' => true,
                    'subtotal' => number_format($subtotal,0,',','.').' VNĐ',
                    'newQuantityCart'=>$newQuantityCart,
                ]);
            }

            // Nếu không tìm thấy cart item, ghi log và trả về lỗi
            Log::error('Cart item not found', [
                'cart_item_id' => $cartItemId,
                'product_variant_id' => $productVariantId,
                'quantity' => $quantity,
            ]);
            return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error('Error updating cart item', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }

    public function removeFromCart(Request $request){
        $cartItems = CartItems::find($request->cart_item_id);
        $cartItems->delete();

        // lấy tổng số lượng để hiển thị lên icon
        $newQuantityCart = CartItems::sum('quantity'); 
        $remainingItems = CartItems::all();
        $newTotalAmount = $remainingItems->sum(function ($item) {
            return $item->product_price * $item->quantity;
        });

        

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
            'newQuantityCart'=>$newQuantityCart,
            'cartTotal'=>$newTotalAmount,
        ]);
    }
}
