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
    public function shop(Request $request)
    {
        // Lấy giá trị min và max từ request hoặc mặc định lấy giá trị từ database
        $minPrice = ProductVariants::min('price');
        $maxPrice = ProductVariants::max('price');

        $newMinPrice = $request->min_price ?? ProductVariants::min('price');
        $newMaxPrice = $request->max_price ?? ProductVariants::max('price');

        
        $list_brand = Brand::where('deleted_at','=',null)
                    ->orderBy('id', 'desc')->get();
        $list_category = Category::where('deleted_at','=',null)
                    ->orderBy('id','desc')->get();

        $list_product = $this->filterByPrice($newMinPrice,$newMaxPrice)
                        ->withQueryString(); // Giữ lại toàn bộ query string;

        $startItem = ($list_product->currentPage() - 1) * $list_product->perPage() + 1;
        $endItem = min($startItem + $list_product->count() - 1, $list_product->total());
        
        return view('client.pages.shop', compact('list_brand','list_category','list_product',
            'minPrice','maxPrice','startItem','endItem'
        ));
    }

    public function filterByPrice($minPrice, $maxPrice , $categoryId = null , $brandId = null)
    {
        // Lọc sản phẩm theo tất cả biến thể trong phạm vi giá
        $query = Product::whereHas('variants', function ($query) use ($minPrice, $maxPrice) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        })
        ->with('variants') // eager load tất cả các biến thể
        ->orderBy('id', 'desc');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        
        // Nếu có brandId, lọc theo brand
        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

    
        return $query->paginate(6);
    }

  
    public function category(Request $request , $slug)
    {
        $minPrice = ProductVariants::min('price');
        $maxPrice = ProductVariants::max('price');

        $newMinPrice = $request->min_price ?? ProductVariants::min('price');
        $newMaxPrice = $request->max_price ?? ProductVariants::max('price');

        $list_brand = Brand::orderBy('id', 'desc')->get();
        $list_category = Category::orderBy('id', 'desc')->get();
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = $this->filterByPrice($newMinPrice,$newMaxPrice,$category->id)
                    ->withQueryString(); // Giữ lại toàn bộ query string;

        $startItem = ($products->currentPage() - 1) * $products->perPage() + 1;
        $endItem = min($startItem + $products->count() - 1, $products->total());
        
        return view('client.pages.shop_category', compact('products','category','list_brand','list_category'
            ,'startItem','endItem','minPrice','maxPrice'
        ));
    }

    // Lấy sản phẩm theo thương hiệu
    public function brand(Request $request,$slug)
    {   
        $minPrice = ProductVariants::min('price');
        $maxPrice = ProductVariants::max('price');

        $newMinPrice = $request->min_price ?? ProductVariants::min('price');
        $newMaxPrice = $request->max_price ?? ProductVariants::max('price');

        $list_brand = Brand::orderBy('id', 'desc')->get();
        $list_category = Category::orderBy('id', 'desc')->get();

        $branD = Brand::where('slug', $slug)->firstOrFail();

        $products = $this->filterByPrice($newMinPrice,$newMaxPrice,null,$branD->id)
                    ->withQueryString(); // Giữ lại toàn bộ query string;
       

        $startItem = ($products->currentPage() - 1) * $products->perPage() + 1;
        $endItem = min($startItem + $products->count() - 1, $products->total());
        
        return view('client.pages.shop_brand', compact('products', 'branD','list_brand','list_category'
            ,'startItem','endItem','minPrice','maxPrice'
        ));
    }

    
}
