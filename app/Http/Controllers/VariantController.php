<?php

namespace App\Http\Controllers;

use App\Models\ProductVariants;
use App\Models\Size;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index(){
        $list_variant = ProductVariants::with('product','size')->get();
        return view('admin.variant.list',compact('list_variant'));
    }

    public function edit($id){
        $allSize = Size::all();
        $variant = ProductVariants::with('product','size')->find($id);
        return view('admin.variant.edit',compact('variant','allSize'));
    }

    public function update(Request $request , $id){

        $variant = ProductVariants::find($id);

        

        if (!$variant) {
            return redirect()->back()->with('error', 'Kích cỡ này không tồn tại');
        }

        $data = $request->validate([
            'size_id' => 'required|exists:sizes,id',
            'stock' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        $duplicateVariant = ProductVariants::where('product_id', $variant->product_id)
                ->where('size_id', $request->size_id)
                ->where('id', '!=', $variant->id) // Loại bỏ biến thể hiện tại ra khỏi kết quả
                ->first();

        if($duplicateVariant){
            return redirect()->back()->with('error','Kích cỡ này đã tồn tại trong sản phẩm');
        }

        $variant->update($data);

        return redirect()->route('admin.variant.index')->with('success','Cập nhập thành công');

    }

    public function delete($id){
        $variant = ProductVariants::find($id);
        $variant->delete();
        return redirect()->route('admin.variant.index')->with('success','Xóa thành công');
    }   
}
