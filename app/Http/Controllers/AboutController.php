<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about(){
        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();
        return view('client.pages.about',compact('list_brand','list_category'));
    }
}
