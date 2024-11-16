<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $sizeFilter = $request->input('size');
        $priceFilter = $request->input('price');
        $searchQuery = $request->input('search');
        $list_size = Size::all();
        $list_category = Category::all();

        $list_product = Product::with(['variants', 'mainVariant'])
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

        return view('client.pages.shop', compact('list_product', 'list_category', 'list_size', 'searchQuery', 'priceFilter'));
    }

    public function showProByCate(Request $request, $categoryId)
    {
        $sizeFilter = $request->input('size');
        $priceFilter = $request->input('price');
        $list_size = Size::all();
        $list_category = Category::all();

        $list_product = Product::where('category_id', $categoryId)
            ->with(['variants', 'mainVariant'])
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
            ->paginate(6);

        return view('client.pages.shop', compact('list_product', 'list_category', 'list_size', 'categoryId', 'priceFilter'));
    }
    // public function filter(Request $request)
    // {
    //     $sizeFilter = $request->input('size');
    //     $priceFilter = $request->input('price');
    //     $searchQuery = $request->input('search');
    //     $list_size = Size::all();
    //     $list_category = Category::all();

    //     $list_product = Product::with(['variants', 'mainVariant'])
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
    //         ->when($searchQuery, function ($query) use ($searchQuery) {
    //             $query->where('name', 'like', '%' . $searchQuery . '%');
    //         })
    //         ->paginate(6);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Sản phẩm đã được xóa khỏi wishlist',
    //             'html' =>  $list_product,
    //         ]);
    // }
}
