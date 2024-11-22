<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

// class ShopController extends Controller
// {   
//     public function shop(Request $request)
// {
//     $sizeFilter = $request->input('size'); // Lấy kích cỡ từ request
//     $priceRange = $request->input('price'); // Lấy giá từ request
//     $searchQuery = $request->input('search'); // Từ khóa tìm kiếm
//     $list_size = Size::all(); // Lấy danh sách các kích cỡ
//     $list_category = Category::all(); // Lấy danh sách các danh mục

//     // Lọc sản phẩm theo kích cỡ, giá và từ khóa tìm kiếm
//     $list_product = Product::with('mainVariant')
//         ->when($sizeFilter, function ($query) use ($sizeFilter) {
//             $query->whereHas('variants', function ($q) use ($sizeFilter) {
//                 $q->where('size_id', $sizeFilter);
//             });
//         })
//         ->when($priceRange, function ($query) use ($priceRange) {
//             $prices = explode('-', $priceRange);
//             if (count($prices) == 2) {
//                 $query->whereHas('mainVariant', function ($q) use ($prices) {
//                     $q->whereBetween('price', [trim($prices[0]), trim($prices[1])]);
//                 });
//             }
//         })
//         ->when($searchQuery, function ($query) use ($searchQuery) {
//             $query->where('name', 'like', '%' . $searchQuery . '%');
//         })
//         ->paginate(6); // Hiển thị 6 sản phẩm mỗi trang

//     return view('client.pages.shop', compact('list_product', 'list_category', 'list_size', 'searchQuery'));
// }

// public function showProByCate($categoryId)
// {
//     // Lấy danh sách sản phẩm theo category_id
//     $list_product = Product::where('category_id', $categoryId)->with('mainVariant')->paginate(9);

//     // Lấy danh sách các danh mục để hiển thị trong sidebar
//     $list_category = Category::all();

//     // Trả về view với dữ liệu
//     return view('client.pages.shop', compact('list_product', 'list_category', 'categoryId'));
// }


// }



// class ShopController extends Controller
// {
//     public function shop(Request $request)
//     {
//         $sizeFilter = $request->input('size'); // Lấy kích cỡ từ request nếu có
//         $priceFilter = $request->input('price'); // Lấy khoảng giá từ request nếu có
//         $searchQuery = $request->input('search'); // Lấy từ khóa tìm kiếm từ request
//         $list_size = Size::all(); // Lấy danh sách các kích cỡ
//         $list_category = Category::all(); // Lấy danh sách các danh mục
    
//         // Lọc sản phẩm theo kích cỡ, giá và từ khóa tìm kiếm
//         $list_product = Product::with('mainVariant')
//             ->when($sizeFilter, function ($query) use ($sizeFilter) {
//                 $query->whereHas('variants.size', function ($q) use ($sizeFilter) {
//                     $q->where('name', $sizeFilter);
//                 });
//             })
//             ->when($priceFilter, function ($query) use ($priceFilter) {
//                 $priceRange = explode('-', $priceFilter); // Lấy khoảng giá
//                 if (count($priceRange) == 2) {
//                     $query->whereBetween('mainVariant.price', [trim($priceRange[0]), trim($priceRange[1])]);
//                 }
//             })
//             ->when($searchQuery, function ($query) use ($searchQuery) {
//                 $query->where('name', 'like', '%' . $searchQuery . '%');
//             })
//             ->paginate(6); // Hiển thị 6 sản phẩm mỗi trang
    
//         return view('client.pages.shop', compact('list_product', 'list_category', 'list_size', 'searchQuery', 'priceFilter'));
//     }

//     public function showProByCate(Request $request, $categoryId)
// {
//     $sizeFilter = $request->input('size'); // Lấy kích cỡ từ request nếu có
//     $priceFilter = $request->input('price'); // Lấy khoảng giá từ request nếu có
//     $list_size = Size::all(); // Lấy danh sách các kích cỡ
//     $list_category = Category::all(); // Lấy danh sách các danh mục

//     // Lọc sản phẩm theo danh mục, kích cỡ và giá
//     $list_product = Product::where('category_id', $categoryId)
//         ->with('mainVariant')
//         ->when($sizeFilter, function ($query) use ($sizeFilter) {
//             $query->whereHas('variants.size', function ($q) use ($sizeFilter) {
//                 $q->where('name', $sizeFilter);
//             });
//         })
//         ->when($priceFilter, function ($query) use ($priceFilter) {
//             $priceRange = explode('-', $priceFilter); // Lấy khoảng giá
//             if (count($priceRange) == 2) {
//                 $query->whereBetween('mainVariant.price', [trim($priceRange[0]), trim($priceRange[1])]);
//             }
//         })
//         ->paginate(6); // Hiển thị 6 sản phẩm mỗi trang

//     return view('client.pages.shop', compact('list_product', 'list_category', 'list_size', 'categoryId', 'priceFilter'));
// }
// }

class ShopController extends Controller
{
    public function shop(Request $request)
{
    $sizeFilter = $request->input('size');
    $priceFilter = $request->input('price');
    $searchQuery = $request->input('search');
    $categoryId = $request->input('category_id');
    
    // Lấy tất cả danh mục và kích thước
    $list_size = Size::all();
    $list_category = Category::all();

    // Lọc theo danh mục, giá, kích thước và từ khóa tìm kiếm
    $list_product = Product::with(['variants', 'mainVariant'])
        ->when($categoryId, function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })
        ->when($sizeFilter, function ($query) use ($sizeFilter) {
            $query->whereHas('variants.size', function ($q) use ($sizeFilter) {
                $q->where('name', $sizeFilter);
            });
        })
        ->when($priceFilter, function ($query) use ($priceFilter) {
            $priceRange = explode('-', $priceFilter);
            if (count($priceRange) == 2) {
                $query->whereHas('variants', function ($q) use ($priceRange) {
                    $q->whereBetween('price', [(int)trim($priceRange[0]), (int)trim($priceRange[1])]);
                });
            }
        })
        ->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%');
        })
        ->paginate(6);

    if ($request->ajax()) {
        // Trả về kết quả AJAX dưới dạng JSON với sản phẩm và phân trang
        $products_html = view('client.pages.partials.product-list', compact('list_product'))->render();
        $pagination = $list_product->links('pagination::bootstrap-4')->toHtml();

        return response()->json([
            'products_html' => $products_html,
            'pagination' => $pagination
        ]);
    }

    return view('client.pages.shop', compact('list_product', 'list_category', 'list_size', 'searchQuery', 'priceFilter'));
}

    
    

    // public function showProByCate(Request $request, $categoryId)
    // {
    //     $sizeFilter = $request->input('size');
    //     $priceFilter = $request->input('price');
    //     $list_size = Size::all();
    //     $list_category = Category::all();

    //     $list_product = Product::where('category_id', $categoryId)
    //         ->with(['variants', 'mainVariant'])
    //         ->when($sizeFilter, function ($query) use ($sizeFilter) {
    //             $query->whereHas('variants.size', function ($q) use ($sizeFilter) {
    //                 $q->where('name', $sizeFilter);
    //             });
    //         })
    //         ->when($priceFilter, function ($query) use ($priceFilter) {
    //             $priceRange = explode('-', $priceFilter);
    //             if (count($priceRange) == 2) {
    //                 $query->whereHas('variants', function ($q) use ($priceRange) {
    //                     $q->whereBetween('price', [(int)trim($priceRange[0]), (int)trim($priceRange[1])]);
    //                 });
    //             }
    //         })
    //         ->paginate(6);

    //     return view('client.pages.shop', compact('list_product', 'list_category', 'list_size', 'categoryId', 'priceFilter'));
    // }
}
