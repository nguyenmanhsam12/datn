<?php

namespace App\Http\Controllers;

use App\Events\VariantUpdated;
use App\Models\ProductVariants;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index(){
        $list_variant = ProductVariants::whereHas('product', function($query) {
            $query->whereNull('deleted_at'); // Điều kiện cho bảng product
        })
        ->with('size')
        ->orderBy('id','desc')->get();
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

        broadcast(new VariantUpdated($variant));

        return redirect()->route('admin.product.index')->with('success','Cập nhập thành công');

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

        $variant =  ProductVariants::where('product_id',$data['product_id'])
            ->where('size_id',$data['size_id'])
            ->first();
        if($variant){
            return redirect()->back()->with('error','Thuộc tính này đã tồn tại');
        }

        ProductVariants::create($data);
        return redirect()->back()->with('success','Thêm thuộc tính thành công');
    }

    public function deleteAt(){
        $softVariant = ProductVariants::withTrashed()->where('deleted_at', '!=', null)->get();
        return view('admin.variant.delete',compact('softVariant'));
    }

    public function restore($id){
        $variant = ProductVariants::onlyTrashed()->find($id); // Lấy bản ghi bị xóa mềm
        if ($variant) {
            $variant->restore(); // Khôi phục bản ghi
            return redirect()->back()->with('success', 'Thuộc tính đã được khôi phục!');
        }
        return redirect()->back()->with('error', 'Thuộc tính không tồn tại hoặc không bị xóa mềm.');
    }

    public function forceDeleteVariant($id){
        $variant = ProductVariants::onlyTrashed()->find($id); // Lấy bản ghi bị xóa mềm
        if ($variant) {
            $variant->forceDelete(); // Xóa vĩnh viễn
            return redirect()->back()->with('success', 'Thuộc tính đã được xóa vĩnh viễn!');
        }
        return redirect()->back()->with('error', 'Thuộc tính không tồn tại hoặc không bị xóa mềm.');
    }

    // api lấy ra biến thể dựa theo sản phẩm
    public function getVariants(Request $request)
    {
        $productId = $request->input('product_id');
        // Tiến hành truy vấn các biến thể của sản phẩm với $productId
        $variants = ProductVariants::with('size')
            ->where('product_id', $productId)->get();
        return response()->json($variants);
    }
}
