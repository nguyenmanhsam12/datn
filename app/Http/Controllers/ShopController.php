<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        // Lấy các tham số từ request
        $sizeFilter = $request->input('size'); // Kích thước đã chọn
        $priceFilter = $request->input('price'); // Khoảng giá đã chọn
        $searchQuery = $request->input('search'); // Từ khóa tìm kiếm
        $categoryId = $request->input('category_id'); // Danh mục đã chọn

        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();

        $list_size = Size::all();
        $list_category = Category::all();
        $minPrice = null;
        $maxPrice = null;

        // Lọc theo khoảng giá
        if ($priceFilter) {
            $priceRange = explode('-', $priceFilter); // Chia khoảng giá (ví dụ: '0-500000')
            if (count($priceRange) == 2) {
                // Lọc giá trong khoảng từ price
                $minPrice = (int) trim($priceRange[0]);
                $maxPrice = (int) trim($priceRange[1]);
            }
        }

        // Truy vấn và lọc sản phẩm
        $list_product = Product::with(['variants', 'mainVariant'])
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($sizeFilter, function ($query) use ($sizeFilter) {
                $query->whereHas('variants.size', function ($q) use ($sizeFilter) {
                    $q->where('name', $sizeFilter);
                });
            })
            ->when($priceFilter, function ($query) use ($minPrice, $maxPrice) {
                $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween('price', [$minPrice, $maxPrice]); // Lọc theo khoảng giá
                });
            })
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%');
            })
            ->paginate(6);

        // Trả về kết quả AJAX
        if ($request->ajax()) {
            $products_html = view('client.pages.product-list', compact('list_product'))->render();
            $pagination = $list_product->links()->toHtml();

            return response()->json([
                'products_html' => $products_html,
                'pagination' => $pagination,
            ]);
        }
        return view('client.pages.shop', compact('list_product', 'list_category', 'list_size', 'searchQuery', 'priceFilter'
            ,'list_brand','list_category'
        ));
    }
}
