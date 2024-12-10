<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if(!$user){
            return redirect()->back()->with('error','Vui lòng đăng nhập trước');
        }

        $list_brand = Brand::all();
        $list_category = Category::all();

        $wishlists = auth()->user()->wishlists()->with('product.mainVariant')->paginate(12);
        // dd($wishlists);
        DB::enableQueryLog();

        $topSellingProducts = \App\Models\Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(12)
            ->get();

        return view('client.pages.wishlist', compact('wishlists', 'topSellingProducts', 'list_brand', 'list_category'));
    }


    public function addToWishlist(Request $request)
    {
        $user = Auth::user();

        if(!$user){
            return response()->json([
                'error'=>'Vui lòng đăng nhập trước khi thêm yêu thích'
            ]);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
    
        // Thêm sản phẩm vào wishlist hoặc trả về sản phẩm đã có
        $wishlistItem = Wishlist::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $request->product_id]
        );
    
        // Trả về thông báo và link đến trang danh sách yêu thích
        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào yêu thích',
            'redirect_to_wishlist' => route('wishlist') // Trả về đường dẫn đến trang wishlist
        ]);
    }

    public function delWishlist($id){

        $user = Auth::user();
        if(!$user){
            return redirect()->back()->with('error','Vui lòng đăng nhập trước');
        }

        $wistlist = Wishlist::find($id);
        $wistlist->delete();
        return redirect()->route('wishlist')->with('success','Xóa thành công!');
    }
    
}

