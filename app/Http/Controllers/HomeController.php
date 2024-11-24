<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CartItems;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $list_product = Product::with('mainVariant')
            ->orderBy('id','desc')
            ->limit(8)
            ->get();
        $list_category = Category::orderBy('id','asc')->limit(4)->get();
       
        return view('client.pages.home',compact('list_product','list_category'));
    }

    public function getProductsByCategory($category_id) {
        // Lấy 8 sản phẩm mới nhất theo danh mục
        $list_product = Product::with('mainVariant')
            ->where('category_id', $category_id)
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        return response()->json($list_product);
    }

    public function getDetailProduct($slug){
        $productDetail = Product::with('variants.size')
            ->where('slug',$slug)
            ->first();
        $productDetail->gallary = json_decode($productDetail->gallary);
        
        // Lấy giá nhỏ nhất từ các biến thể
        $minPrice = $productDetail->variants->min('price');
        


        // sp liên quan
        $relatedProduct = Product::where('category_id',$productDetail->category_id)
            ->where('id','!=',$productDetail->id)
            ->take(4)   //lấy  4 sp
            ->get();


        // danh gia
    $product = Product::with('reviews.user')->where('slug', $slug)->firstOrFail();
     // Kiểm tra nếu không tìm thấy sản phẩm
     if (!$product) {
        return redirect()->route('home')->with('error', 'Sản phẩm không tồn tại');
    }
    $reviews = Review::where('product_id', $product->id)->with('user')->get();

//    $userHasPurchased = false;

// if (Auth::check()) {
//     // Kiểm tra xem người dùng đã đặt sản phẩm với trạng thái đơn hàng là "Đã hoàn tất" chưa
//     $userHasPurchased = Order::where('user_id', Auth::id())
//         ->whereHas('cartItems', function ($query) use ($product) {
//             $query->where('product_variant_id', $product->id); // Kiểm tra sản phẩm trong đơn hàng
//         })
//         ->whereHas('orderStatus', function ($query) {
//             $query->where('name', 'Đã hoàn tất'); // Kiểm tra trạng thái "Đã hoàn tất" trong bảng order_status
//         })
//         ->exists();
// }

// Truyền biến $userHasPurchased về view
return view('client.pages.detail', compact(
    'productDetail',
    'relatedProduct',
    'minPrice',
    'product',
     'reviews',
    // 'userHasPurchased'
));


        return view('client.pages.detail',compact('productDetail','relatedProduct','minPrice','product', 'reviews', 'userHasPurchased'));
    }




   public function submitReview(Request $request)
{
    $product = Product::findOrFail($request->product_id);
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'rating' => 'nullable|integer|between:1,5',  // rating có thể null nhưng nếu có thì phải là số từ 1 đến 5
        'message' => 'nullable|string|max:1000',    // message có thể null nhưng nếu có thì phải là chuỗi không quá 1000 ký tự
    ], [
        'rating.required_without' => 'Bạn phải chọn ít nhất một trong hai: Đánh giá sao hoặc đánh giá văn bản.',
        'message.required_without' => 'Bạn phải chọn ít nhất một trong hai: Đánh giá sao hoặc đánh giá văn bản.',
    ]);
      // Nếu không có rating và message thì trả về lỗi
      if (!$request->rating && !$request->message) {
        return response()->json([
            'status' => 'error',
            'message' => 'Vui lòng chọn ít nhất một hình thức đánh giá (sao hoặc văn bản).'
        ]);
    }

    $review = new Review();
    $review->user_id = auth()->id(); // Lấy ID người dùng đang đăng nhập
    $review->product_id = $request->product_id;
    $review->rating = $request->rating;
    $review->message = $request->message;
    $review->save();
    

    return response()->json([
        'status' => 'success',
        'message' => 'Đánh giá đã được gửi thành công!'
    ]);
}
    

    

    
    
    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
    
        if ($review->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn không có quyền xóa đánh giá này.'
            ]);
        }
    
        $review->delete();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Đánh giá đã được xóa thành công!'
        ]);
    }
    
    

    
}
