<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(){
        $coupons = Coupon::orderBy('id','desc')->get();
        return view('admin.coupons.list',compact('coupons'));
    }

    public function create(){
        return view('admin.coupons.add');
    }

    public function storeCoupon(StoreCouponRequest $request){
        $data = $request->validated();

        // Lưu mã giảm giá vào cơ sở dữ liệu
        Coupon::create($data);
        return redirect()->route('admin.coupons.index')->with('success', 'Mã giảm giá đã được thêm thành công!');

    }

    public function edit($id){
        $coupon = Coupon::find($id);
        return view('admin.coupons.edit',compact('coupon'));
    }

    public function update(UpdateCouponRequest $request , $id){
        $data = $request->validated();

        $coupon = Coupon::find($id);

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Mã giảm giá đã cập nhật thành công!');

    }

    public function delete($id){
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Xóa thành công!');
    }

    

}
