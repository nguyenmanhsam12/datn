<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductVariants;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop()
    {
        $minPrice = ProductVariants::min('price');  
        $maxPrice = ProductVariants::max('price');  
        $list_brand = Brand::where('deleted_at','=',null)
                    ->orderBy('id', 'desc')->get();
        $list_category = Category::where('deleted_at','=',null)
                    ->orderBy('id','desc')->get();
        $list_product = Product::with('mainVariant')->orderBy('id','desc')->paginate(9);

        $startItem = ($list_product->currentPage() - 1) * $list_product->perPage() + 1;
        $endItem = min($startItem + $list_product->count() - 1, $list_product->total());
        
        return view('client.pages.shop', compact('list_brand','list_category','list_product',
            'minPrice','maxPrice','startItem','endItem'
        ));
    }

   
    public function filterByPrice(Request $request)
    {
        // Lấy giá trị min_price và max_price từ yêu cầu
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Lọc sản phẩm theo giá
        $products = Product::whereHas('variants', function($query) use ($minPrice, $maxPrice) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        })->get();

        // Trả về dữ liệu sản phẩm dưới dạng JSON
        return response()->json([
            'products' => $products
        ]);
    }



    public function category($slug)
    {
        $list_brand = Brand::orderBy('id', 'desc')->get();
        $list_category = Category::orderBy('id', 'desc')->get();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->paginate(9);

        $startItem = ($products->currentPage() - 1) * $products->perPage() + 1;
        $endItem = min($startItem + $products->count() - 1, $products->total());
        
        return view('client.pages.shop_category', compact('products','category','list_brand','list_category'
            ,'startItem','endItem'
        ));
    }

    // Lấy sản phẩm theo thương hiệu
    public function brand($slug)
    {
        $list_brand = Brand::orderBy('id', 'desc')->get();
        $list_category = Category::orderBy('id', 'desc')->get();
        $branD = Brand::where('slug', $slug)->firstOrFail();
        $products = Product::where('brand_id', $branD->id)->paginate(9);

        $startItem = ($products->currentPage() - 1) * $products->perPage() + 1;
        $endItem = min($startItem + $products->count() - 1, $products->total());
        
        return view('client.pages.shop_brand', compact('products', 'branD','list_brand','list_category'
            ,'startItem','endItem'
        ));
    }

    
}
