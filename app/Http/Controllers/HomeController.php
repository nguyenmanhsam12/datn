<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CartItems;
use App\Models\Review;
use App\Models\Post;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    public function index()
    {
        $list_product = Product::whereHas('variants')
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        // dùng hàm withSum sẽ sinh ra 1 trường là variants_sum_selled
        $top_selling_products = Product::whereHas('variants', function ($query) {
                $query->where('selled', '>', 0); // Chỉ lấy các sản phẩm có biến thể đã bán
            })
            ->withSum('variants', 'selled') // Tính tổng số lượng selled từ biến thể
            ->orderByDesc('variants_sum_selled') // Sắp xếp theo tổng số lượng bán
            ->limit(8) // Lấy 8 sản phẩm bán chạy nhất
            ->get();
        
       

        $list_cate = Category::orderBy('id', 'asc')->limit(4)->get();
        $list_brand = Brand::orderBy('id', 'desc')->get();
        $list_category = Category::orderBy('id', 'desc')->get();
        $posts = Post::orderBy('created_at', 'desc')
                       ->take(3) 
                       ->get();
       
        return view('client.pages.home', compact('list_product', 'list_cate', 'list_brand', 'list_category'
            ,'posts','top_selling_products'
        ));

    }

    // public function getProductsByCategory($category_id)
    // {
    //     // Lấy 8 sản phẩm mới nhất theo danh mục
    //     $list_product = Product::whereHas('category',function($query) use ($category_id){
    //         $query->where('category.id', $category_id); // Lọc theo danh mục
    //     })
    //     ->whereHas('mainVariant') // Chỉ lấy sản phẩm có biến thể
    //     ->orderBy('id', 'desc')
    //     ->limit(8)
    //     ->get();

    //     foreach ($list_product as $product) {
    //         Log::info('Biến thể:', ['variant' => $product->mainVariant->toArray()]);
    //     }

    //     return response()->json($list_product);
    // }

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
        $relatedProduct = Product::whereHas('category', function ($query) use ($productDetail) {
            $query->whereIn('category.id', $productDetail->category->pluck('id')->toArray());
        })
        ->where('brand_id',$productDetail->brand_id)
        ->whereHas('variants')
        ->where('id', '!=', $productDetail->id)
        ->take(4)  // Lấy 4 sản phẩm liên quan
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
            'rating' => 'required|integer|between:1,5', // Rating là bắt buộc
            'message' => 'required|string|max:1000',   // Nội dung là bắt buộc
        ], [
            'rating.required' => 'Bạn phải chọn số sao để đánh giá.',
            'rating.integer' => 'Đánh giá sao phải là một số nguyên.',
            'rating.between' => 'Đánh giá sao phải nằm trong khoảng từ 1 đến 5.',
            'message.required' => 'Bạn phải nhập nội dung đánh giá.',
            'message.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
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

    // tìm kiếm
    public function serachProduct(Request $request){
        $data = $request->all();

        $products = Product::where('name','LIKE','%'.$data['query'].'%')->get();

        // Thêm đường dẫn đầy đủ cho hình ảnh
        $products = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'image' => asset($product->image), 
                'slug' => $product->slug,
            ];
        });

        return response()->json($products);
    }
}
     
  
  
