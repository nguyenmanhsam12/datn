<?php

namespace App\Http\Controllers;

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

    public function create(){
        return view('admin.category.add');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|min:2|max:255|unique:category,name',
        ],[
            'name.required'=>'Tên danh mục buộc phải nhập',
            'name.unique'=>'Tên danh mục đã tồn tại',
        ]);

        $data = $request->all();

        Category::create($data);

        return redirect()->route('admin.category.index')->with('success','Thêm danh mục thành công');

    }

    public function edit($id){
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request , $id){

        $category = Category::find($id);

        $data = $request->validate([
            'name'=>['required','string','min:2','max:255',Rule::unique('brands')->ignore($category)],
        ],[
            'name.required'=>'Tên thương hiệu buộc phải nhập',
        ]);

        $category->update($data);

        return redirect()->route('admin.category.index')->with('success','Cập nhập danh mục thành công');

    }

    public function delete($id){
        $category = Category::find($id);

        $category->products()->detach();
        
        $category->delete();
        return redirect()->route('admin.category.index')->with('success','Xóa thành công');
    }

    public function deleteAt(){
        $softCategory = Category::onlyTrashed()->get();
        return view('admin.category.delete',compact('softCategory'));
    }

    public function restore($id){
        $category = Category::onlyTrashed()->find($id); // Lấy bản ghi bị xóa mềm
        if ($category) {
            $category->restore(); // Khôi phục bản ghi
            return redirect()->back()->with('success', 'Danh mục đã được khôi phục!');
        }
        return redirect()->back()->with('error', 'Danh mục không tồn tại hoặc không bị xóa mềm.');
    }

    public function forceDeleteCategory($id){
        $category = Category::onlyTrashed()->find($id); // Lấy bản ghi bị xóa mềm
        if ($category) {
            $category->forceDelete(); // Xóa vĩnh viễn
            return redirect()->back()->with('success', 'Danh mục đã được xóa vĩnh viễn!');
        }
        return redirect()->back()->with('error', 'Danh mục không tồn tại hoặc không bị xóa mềm.');
    }
}
