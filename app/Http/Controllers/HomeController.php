<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CartItems;
use Illuminate\Support\Facades\Auth;

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

        // sp liên quan
        $relatedProduct = Product::where('category_id',$productDetail->category_id)
            ->where('id','!=',$productDetail->id)
            ->take(4)   //lấy  4 sp
            ->get();
        
        return view('client.pages.detail',compact('productDetail','relatedProduct'));
    }

    
}
