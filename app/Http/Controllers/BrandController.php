<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index(){
        $list_brand = Brand::orderBy('id','desc')->get();
        return view('admin.brand.list',compact('list_brand'));
    }

    public function create(){
        return view('admin.brand.add');
    }

    public function storeBrand(Request $request){
        $request->validate([
            'name'=>'required|string|min:2|max:255|unique:brands,name'
        ],[
            'name.required'=>'Tên thương hiệu buộc phải nhập',
        ]);

        $data = $request->all();

        Brand::create($data);

        return redirect()->route('admin.brand.index')->with('success','Thêm thương hiệu thành công');

    }

    public function edit($id){
        $brand = Brand::find($id);
        return view('admin.brand.edit',compact('brand'));
    }

    public function updateBrand(Request $request , $id){

        $brand = Brand::find($id);

        $data = $request->validate([
            'name'=>['required','string','min:2','max:255',Rule::unique('brands')->ignore($brand)]
        ],[
            'name.required'=>'Tên thương hiệu buộc phải nhập',
        ]);

        $brand->update($data);

        return redirect()->route('admin.brand.index')->with('success','Cập nhập thương hiệu thành công');

    }

    public function deleteBrand($id){
        $brand = Brand::find($id);

        Product::where('brand_id',$brand->id)->update(['brand_id'=>null]);

        $brand->delete();

        return redirect()->route('admin.brand.index')->with('success','Xóa thành công');
    }
}
