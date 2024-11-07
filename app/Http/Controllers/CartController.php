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
            ->with(['variants.product','variants.size']) // Eager load variants và product cho cartItems
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


        return view('client.pages.cart', compact('cart', 'cartItems', 'totalAmount'));
    }

    // thêm giỏ hàng
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

    // lấy tổng số lượng đang có trong giỏ hàng
    public function getCartItemCount()
    {
        $user = Auth::user();
        $totalItems = 0;

        // Kiểm tra nếu người dùng đã đăng nhập
        if ($user) {
            // Lấy giỏ hàng của người dùng
            $cart = Cart::where('user_id', $user->id)->first();

            // Kiểm tra nếu giỏ hàng tồn tại và đếm tổng số lượng sản phẩm trong bảng `cart_items`
            $totalItems = $cart ? CartItems::sum('quantity') : 0;
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
        $cartItems->delete();

        // lấy tổng số lượng để hiển thị lên icon
        $newQuantityCart = CartItems::sum('quantity');

        $cart_items = CartItems::with('variants')->get();

        $newTotalAmount = $cart_items->sum(function ($item) {

            $variant = $item->variants;

            return $variant->price * $item->quantity;
        });



        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
            'newQuantityCart' => $newQuantityCart,
            'cartTotal' => $newTotalAmount,
        ]);
    }

    // Tăng số lượng
    public function increaseQuantity(Request $request)
    {
        $data = $request->all();

        $cartItemId = $data['cart_item_id'];

        // Tìm CartItem và lấy product_variant_id
        $cartItem = CartItems::with('variants')->findOrFail($cartItemId);

        // Tăng số lượng lên 1
        $cartItem->quantity += 1;

        // Tính lại thành tiền cho sản phẩm
        $total_price = 0;
        $total_price = $cartItem->variants->price * $cartItem->quantity;

        $cartItem->save();

        $cartItems = CartItems::all();
        $quantityCartIcon  = $cartItems->sum('quantity');

        // Tính tổng tiền của tất cả các sản phẩm trong giỏ hàng
        $totalCartPrice = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->variants->price * $item->quantity);
        }, 0);

        // Trả về JSON response với số lượng và tổng tiền mới
        return response()->json([
            'quantity' => $cartItem->quantity,
            'totalPrice' => $total_price,
            'quantityCartIcon' => $quantityCartIcon,
            'totalCartPrice' => $totalCartPrice,
        ]);
    }

    // Giảm số lượng
    public function decreaseQuantity(Request $request)
    {
        $data = $request->all();

        $cartItemId = $data['cart_item_id'];

        // Tìm CartItem và lấy product_variant_id
        $cartItem = CartItems::with('variants')->findOrFail($cartItemId);

        // Kiểm tra nếu số lượng lớn hơn 1 thì mới giảm
        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            // Tính lại thành tiền cho sản phẩm
            $total_price = 0;
            $total_price = $cartItem->variants->price * $cartItem->quantity;

            

            $cartItem->save();
        }

        $cartItems = CartItems::all();
        $quantityCartIcon  = $cartItems->sum('quantity');

         // Tính tổng tiền của tất cả các sản phẩm trong giỏ hàng
         $totalCartPrice = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->variants->price * $item->quantity);
        }, 0);

        // Trả về JSON response với số lượng và tổng tiền mới
        return response()->json([
            'quantity' => $cartItem->quantity,
            'totalPrice' => $total_price,
            'quantityCartIcon' => $quantityCartIcon,
            'totalCartPrice' => $totalCartPrice,
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

        // Tính lại tổng tiền cho sản phẩm trong giỏ hàng
        $totalPrice = $cartItem->quantity * $cartItem->variants->price;

        $cartItems = CartItems::all();
        $quantityCartIcon  = $cartItems->sum('quantity');

         // Tính tổng tiền của tất cả các sản phẩm trong giỏ hàng
         $totalCartPrice = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->variants->price * $item->quantity);
        }, 0);

        // Trả về kết quả
        return response()->json([
            'quantity' => $cartItem->quantity,
            'totalPrice' => $totalPrice,
            'quantityCartIcon' => $quantityCartIcon,
            'totalCartPrice' => $totalCartPrice,
        ]);
    }
}
