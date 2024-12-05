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

    // thêm thuộc tính từ danh sách sp
    public function productVariant(Request $request){
       
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'stock' => 'required|integer|min:1',
            'length' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ], [
            // Các thông báo lỗi tùy chỉnh
            'product_id.required' => 'Không tìm thấy sản phẩm.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'size_id.required' => 'Vui lòng chọn kích cỡ.',
            'size_id.exists' => 'Kích cỡ không hợp lệ.',
            'stock.required' => 'Vui lòng nhập số lượng.',
            'stock.integer' => 'Số lượng phải là số nguyên.',
            'stock.min' => 'Số lượng phải lớn hơn 0.',
            'length.numeric' => 'Chiều dài phải là số.',
            'width.numeric' => 'Chiều rộng phải là số.',
            'height.required' => 'Chiều cao là bắt buộc.',
            'height.numeric' => 'Chiều cao phải là số.',
            'height.min' => 'Chiều cao phải lớn hơn hoặc bằng 0.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'length.required' => 'Chiều dài bắt buộc phải nhập',
            'width.required' => 'Chiều rộng bắt buộc phải nhập',
            'height.required' => 'Chiều cao bắt buộc phải nhập',
        ]);

        $variant =  ProductVariants::where('product_id',$data['product_id'])->first();
        if($variant){
            return redirect()->back()->with('error','Thuộc tính này đã tồn tại');
        }

        ProductVariants::create($data);
        return redirect()->back()->with('success','Thêm thuộc tính thành công');
    }
}
