<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    public function index(){
        $list_size = Size::orderBy('id','desc')->get();
        return view('admin.size.list',compact('list_size'));
    }

    public function create(){
        return view('admin.size.add');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|min:2|max:255|unique:sizes,name'
        ],[
            'name.required'=>'Tên kích cỡ buộc phải nhập',
        ]);

        $data = $request->all();

        Size::create($data);

        return redirect()->route('admin.size.index')->with('success','Thêm kích cỡ thành công');

    }

    public function edit($id){
        $size = Size::find($id);
        return view('admin.size.edit',compact('size'));
    }

    public function update(Request $request , $id){

        $size = Size::find($id);

        $data = $request->validate([
            'name'=>['required','string','min:2','max:255',Rule::unique('sizes')->ignore($size)]
        ],[
            'name.required'=>'Tên thương hiệu buộc phải nhập',
        ]);

        $size->update($data);

        return redirect()->route('admin.size.index')->with('success','Cập nhập kích cỡ thành công');

    }

    public function delete($id){
        $size = Size::find($id);
        $size->delete();

        return redirect()->route('admin.size.index')->with('success','Xóa thành công');
    }
}
