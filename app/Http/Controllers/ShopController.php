<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop()
    {
        $list_brand = Brand::orderBy('id', 'desc')->get();
        $list_category = Category::orderBy('id', 'desc')->get();
        return view('client.pages.shop', compact('list_brand','list_category'));
    }
    
}
