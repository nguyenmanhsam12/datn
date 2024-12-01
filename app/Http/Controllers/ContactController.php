<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact(){
        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();
        return view('client.pages.contact',compact('list_brand','list_category'));
    }
}
