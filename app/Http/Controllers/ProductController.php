<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariants;
use App\Models\Size;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(){
        $list_product = Product::with('brand','category','user','variants')->orderBy('id','desc')->get();

        // session()->forget('product_attributes');

        return view('admin.product.list',compact('list_product'));
    }

    public function create(){
        $allCategory = Category::all();
        $allBrand = Brand::all();
        $allSize = Size::all();
        return view('admin.product.add',compact('allCategory','allBrand','allSize'));
    }

    public function store(StoreProductRequest $request){
        
        try {
            $validatedData = $request->validated();

            Log::info('list product',$validatedData);

            

            // Lưu hình ảnh chính
            $imagePath = '';
            if (isset($validatedData['image'])) {
    
                $image_name = $validatedData['image']->getClientOriginalName();
                $extension = $validatedData['image']->getClientOriginalExtension();
                $name_extension = $image_name . '_' . time() . '_' . $extension;
    
                // Di chuyển ảnh và lưu đường dẫn tương đối
                $validatedData['image']->move(public_path('product_image'), $name_extension);
    
                $imagePath = '/'.'product_image/' . $name_extension;
    
            }
    
            // Lưu các ảnh phụ
            $gallaryPaths = [];
            // kiểm tra tồn tại và là 1 mảng
            if (isset($validatedData['gallary']) && is_array($validatedData['gallary'])) {
                foreach ($validatedData['gallary'] as $image) {
                    if ($image) {
    
                        $gallary_name = $image->getClientOriginalName();
    
                        $gallary_extension = $image->getClientOriginalExtension();
    
                        $gallary_name_extension = $gallary_name . '_' . time() . '_' . $gallary_extension;
    
                        // Di chuyển ảnh phụ và lưu đường dẫn tương đối
                        $image->move(public_path('product_images'), $gallary_name_extension);
                        $gallaryPaths[] = 'product_images/' . $gallary_name_extension; // Đường dẫn tương đối
                    }
                }
            }
    
            // Tạo sản phẩm mới
            $product = Product::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'description_text' => $validatedData['description_text'],
                'brand_id' => $validatedData['brand_id'],
                'category_id' => $validatedData['category_id'],
                'sku' => $validatedData['sku'],
                'image' => $imagePath,
                'gallary' => json_encode($gallaryPaths),
                'user_id' => 1,
                
            ]);
    
            if (!empty($validatedData['variants'])) {
                // Lưu các biến thể của sản phẩm
                foreach ($validatedData['variants'] as $variant) {
                    // Kiểm tra xem biến thể đã tồn tại chưa
                    $existingVariant = ProductVariants::where('product_id', $product->id)
                        ->where('size_id', $variant['size_id'])
                        ->first();
    
                    if ($existingVariant) {
                        Log::warning('Variant already exists', [
                            'product_id' => $product->id,
                            'size_id' => $variant['size_id'],
                            'price' => $variant['price'],
                            'weight' => $variant['weight'],
    
                        ]);
                    }
    
                    // Tạo biến thể mới
                    ProductVariants::create([
                        'product_id' => $product->id,
                        'size_id' => $variant['size_id'],
                        'stock' => $variant['stock'],
                        'price' => $variant['price'],
                        'weight' => $variant['weight'],
                    ]);

                }
            }

            
    
            return redirect()->route('admin.product.index')->with('success','Thêm sản phẩm thành công');
        } catch (\Exception  $e) {
            // Ghi log lỗi
            Log::error('Error while storing product', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Trả về trang trước với thông báo lỗi
            return redirect()->back()->withInput()->with('error', 'Đã xảy ra lỗi khi thêm sản phẩm. Vui lòng thử lại.');
        }

       

    }

    public function edit($id){
        $allCategory = Category::all();
        $allBrand = Brand::all();
        $product = Product::find($id);
        $product->gallary = json_decode($product->gallary);
        
        return view('admin.product.edit',compact('product','allCategory','allBrand'));
    }

    public function update(UpdateProductController $request , $id){

            Log::debug('Vào hàm updateProduct'); // Thêm log này
            Log::info(['products_update'], $request->all());


            $product = Product::findOrFail($id);

            $validatedData = $request->validated();

            // Kiểm tra và xử lý cập nhật ảnh chính
            $imagePath = $product->image;
            if (isset($validatedData['image'])) {
                // Xóa ảnh cũ nếu tồn tại
                if ($imagePath && file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                }

                // Lưu ảnh mới
                $image_name = $validatedData['image']->getClientOriginalName();
                $extension = $validatedData['image']->getClientOriginalExtension();
                $name_extension = $image_name . '_' . time() . '.' . $extension;
                $validatedData['image']->move(public_path('product_image'), $name_extension);
                $imagePath = '/'.'product_image/' . $name_extension;
            }

            // Kiểm tra và xử lý cập nhật các ảnh phụ
            $gallaryPaths = json_decode($product->gallary, true) ?? [];
            if (isset($validatedData['gallary']) && is_array($validatedData['gallary'])) {
                // Xóa ảnh phụ cũ nếu có
                foreach ($gallaryPaths as $oldPath) {
                    if (file_exists(public_path($oldPath))) {
                        unlink(public_path($oldPath));
                    }
                }

                // Lưu ảnh phụ mới
                $gallaryPaths = [];
                foreach ($validatedData['gallary'] as $image) {
                    if ($image) {
                        $gallary_name = $image->getClientOriginalName();
                        $gallary_extension = $image->getClientOriginalExtension();
                        $gallary_name_extension = $gallary_name . '_' . time() . '.' . $gallary_extension;
                        $image->move(public_path('product_images'), $gallary_name_extension);
                        $gallaryPaths[] = 'product_images/' . $gallary_name_extension;
                    }
                }
            }

            // Cập nhật thông tin sản phẩm
            $product->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'description_text' => $validatedData['description_text'],
                'brand_id' => $validatedData['brand_id'],
                'category_id' => $validatedData['category_id'],
                'sku' => $validatedData['sku'],
                'image' => $imagePath,
                'gallary' => json_encode($gallaryPaths),
                'user_id' => 1,
            ]);

        return redirect()->route('admin.product.index')->with('success','Cập nhập sản phẩm thành công');

    }

    public function delete($id){
        $product = Product::find($id);

        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image)); // Xóa ảnh chính
        }

        // Thêm các ảnh trong gallery vào danh sách xóa
        if ($product->gallary) {
            $galleryImages = json_decode($product->gallary, true);
            foreach ($galleryImages as $galleryImage) {
                if ($galleryImage && file_exists(public_path($galleryImage))) {
                    unlink(public_path($galleryImage)); // Xóa ảnh trong gallery
                }
            }
        }
        
        $product->delete();

        return redirect()->route('admin.product.index')->with('success','Xóa thành công');
    }

}
