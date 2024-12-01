<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CartItems;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $list_product = Product::whereHas('mainVariant')
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();
        $list_cate = Category::orderBy('id', 'asc')->limit(4)->get();

        $list_brand = Brand::orderBy('id', 'desc')->get();
        $list_category = Category::orderBy('id', 'desc')->get();

        return view('client.pages.home', compact('list_product', 'list_cate', 'list_brand', 'list_category'));
    }

    public function getProductsByCategory($category_id)
    {
        // Lấy 8 sản phẩm mới nhất theo danh mục
        $list_product = Product::with('mainVariant')
            ->where('category_id', $category_id)
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        return response()->json($list_product);
    }

    public function getDetailProduct($slug)
    {
        $productDetail = Product::with('variants.size')
            ->where('slug', $slug)
            ->first();
        $productDetail->gallary = json_decode($productDetail->gallary);

        // Lấy giá nhỏ nhất từ các biến thể
        $minPrice = $productDetail->variants->min('price');

        $list_brand = Brand::orderBy('id', 'desc')->get();
        $list_category = Category::orderBy('id', 'desc')->get();

        // sp liên quan
        $relatedProduct = Product::whereHas('mainVariant')
            ->where('category_id', $productDetail->category_id)
            ->where('id', '!=', $productDetail->id)
            ->take(4)   //lấy  4 sp
            ->get();

        // danh gia
        $product = Product::with('reviews.user')->where('slug', $slug)->firstOrFail();
        // Kiểm tra nếu không tìm thấy sản phẩm
        if (!$product) {
            return redirect()->route('home')->with('error', 'Sản phẩm không tồn tại');
        }
        $reviews = Review::where('product_id', $product->id)->with('user')->get();


        $user = Auth::user();
        $userHasPurchased = false;

        $productSlug = Product::where('slug', $slug)->first();

        if (!$productSlug) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
        }

        if ($user) {
            $order = Order::where('user_id', $user->id)
                ->where('status_id', 5)
                ->whereHas('orderItems', function ($query) use ($productSlug) {
                    $query->where('product_name', $productSlug->name);
                })
                ->first();


            $userHasPurchased = $order !== null;
        }

        //  dd($userHasPurchased); 
        return view('client.pages.detail', compact(
            'productDetail',
            'relatedProduct',
            'minPrice',
            'product',
            'reviews',
            'userHasPurchased',
            'list_brand',
            'list_category'
        ));
    }
    public function submitReview(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'nullable|integer|between:1,5',
            'message' => 'nullable|string|max:1000',
        ], [
            'rating.required_without' => 'Bạn phải chọn ít nhất một trong hai: Đánh giá sao hoặc đánh giá văn bản.',
            'message.required_without' => 'Bạn phải chọn ít nhất một trong hai: Đánh giá sao hoặc đánh giá văn bản.',
        ]);
        if (!$request->rating && !$request->message) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng chọn ít nhất một hình thức đánh giá (sao hoặc văn bản).'
            ]);
        }

        $review = new Review();
        $review->user_id = auth()->id();
        $review->product_id = $request->product_id;
        $review->rating = $request->rating;
        $review->message = $request->message;
        $review->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Đánh giá của bạn đã được gửi!',
            'user_name' => auth()->user()->name,
            'date' => now()->format('d M, Y \a\t H:i'),
            'rating' => $review->rating,
            'review_message' => $review->message,
            'id' => $review->id,
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
