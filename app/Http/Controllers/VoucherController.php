<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function voucher(){
        $list_brand = Brand::orderBy('id', 'desc')->get();
        $list_category = Category::orderBy('id', 'desc')->get();
        $list_coupon = Coupon::orderBy('id','desc')->get();
        return view('client.pages.voucher',compact('list_brand','list_category','list_coupon'));
    }
}
