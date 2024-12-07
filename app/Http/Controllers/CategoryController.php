<?php

namespace App\Http\Controllers;

use App\Components\Recursive;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(){
        $list_cate = Category::orderBy('id','desc')->get();
        return view('admin.category.list',compact('list_cate'));
    }

    public function create(Recursive $recursive){
        $categories=$recursive->getCategoryTree();
        return view('admin.category.add',compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|min:2|max:255|unique:brands,name',
            'parent_id'=>'required|integer',
        ],[
            'name.required'=>'Tên danh mục buộc phải nhập',
        ]);

        $data = $request->all();

        Category::create($data);

        return redirect()->route('admin.category.index')->with('success','Thêm danh mục thành công');

    }

    public function edit(Recursive $recursive , $id){
        $category = Category::find($id);
        $categories = $recursive->getCategoryTree();
        return view('admin.category.edit',compact('category','categories'));
    }

    public function update(Request $request , $id){

        $category = Category::find($id);

        $data = $request->validate([
            'name'=>['required','string','min:2','max:255',Rule::unique('brands')->ignore($category)],
            'parent_id'=>'required|integer',
        ],[
            'name.required'=>'Tên thương hiệu buộc phải nhập',
        ]);

        $category->update($data);

        return redirect()->route('admin.category.index')->with('success','Cập nhập danh mục thành công');

    }

    public function delete($id){
        $category = Category::find($id);

        $product = Product::where('category_id',$category->id)->first();

        if($product){
            $product->category_id = null;
            $product->save();
        }
        
        $category->delete();
        return redirect()->route('admin.category.index')->with('success','Xóa thành công');
    }
}
