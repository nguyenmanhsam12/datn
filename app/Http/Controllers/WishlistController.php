<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    // Hiển thị danh sách sản phẩm trong wishlist
    public function index()
    {
        $user = Auth::user();
        // Lấy tất cả sản phẩm trong wishlist của người dùng, kèm theo thông tin sản phẩm
        $wishlistProducts = $user->wishlist()->with('product')->paginate(10); 
        
        return view('client.pages.wishlist', compact('wishlistProducts'));
    }

    // Thêm sản phẩm vào wishlist
    public function addToWishlist($productId)
    {
        $user = Auth::user();
        
        // Kiểm tra nếu sản phẩm đã có trong wishlist
        if ($user->wishlist()->where('product_id', $productId)->exists()) {
            return redirect()->route('wishlist.index')->with('message', 'Sản phẩm đã có trong wishlist!');
        }
        
        // Thêm sản phẩm vào wishlist
        $user->wishlist()->create(['product_id' => $productId]);
        
        return redirect()->route('wishlist.index')->with('message', 'Sản phẩm đã được thêm vào wishlist.');
    }

    // Xóa sản phẩm khỏi wishlist
  // Xóa sản phẩm khỏi wishlist
// Xóa sản phẩm khỏi wishlist
public function removeFromWishlist($productId)
{
    $user = Auth::user();

    // Kiểm tra xem người dùng có đăng nhập không
    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Bạn cần đăng nhập để thực hiện hành động này']);
    }

    // Kiểm tra xem sản phẩm có trong wishlist của người dùng không
    $wishlistItem = $user->wishlist()->where('product_id', $productId)->first();

    if (!$wishlistItem) {
        return response()->json(['success' => false, 'message' => 'Sản phẩm không có trong wishlist của bạn']);
    }

    // Xóa sản phẩm khỏi wishlist
    $wishlistItem->delete();

    // Lấy lại danh sách wishlist sau khi xóa
    $wishlistProducts = $user->wishlist()->with('product')->paginate(10);

    // Trả về HTML của phần sản phẩm (chỉ phần cần thiết)
    $html = view('client.components.wishlist_products', compact('wishlistProducts'))->render();

    return response()->json([
        'success' => true,
        'message' => 'Sản phẩm đã được xóa khỏi wishlist',
        'html' => $html,
    ]);
}

}


