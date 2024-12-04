<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Components\Permission as PermissionRecusive;

class PermissionController extends Controller
{

    // tạo quyền
    public function createPermission(){
        // $list_permission = Permission::where('parent_id',0)->get();
        $data = Permission::all();
        $recusive = new PermissionRecusive($data);
        $htmlOption = $recusive->permissionRecusive($parentId = '');

        return view('admin.permission.add',compact('htmlOption'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'name'=>'required|string',
            'display_name'=>'required|string',
            'parent_id' => 'required',
        ],[
            'name.required'=>'Tên quyền buộc phải nhập',
            'display_name.required'=>'Mô tả quyền buộc phải nhập',
        ]);
        
        // Tạo key_code tự động
        $keyCode = $this->generateKeyCode($request);

        // Kiểm tra trùng key_code
        if (Permission::where('key_code', $keyCode)->exists()) {
            return redirect()->back()->with('error', 'Key code này đã tồn tại, vui lòng chọn tên quyền khác!');
        }

        $permission = new Permission();
        $permission->name = $data['name'];
        $permission->display_name = $data['display_name'];

        if($data['parent_id'] != 0){
            $permission->parent_id = $data['parent_id'];
            $permission->key_code = $keyCode;
        }

        $permission->parent_id = $data['parent_id'];
        $permission->key_code = $keyCode;
        $permission->save();

        return redirect()->back()->with('success','Thêm quyền thành công');
    }

    private function generateKeyCode(Request $request)
    {
        // Tạo key_code tự động từ tên quyền và module cha
        $permissionName = strtolower(str_replace(' ', '_', $request->name));
        $parentModule = $request->input('parent_id');

        // Nếu quyền có module cha, ta kết hợp tên module với tên quyền
        if ($parentModule != '0') {
            $parent = Permission::find($parentModule);
            $keyCode = $parent->name . '_' . $permissionName;
        } else {
            // Nếu không có quyền cha, key_code là tên quyền
            $keyCode = $permissionName;
        }

        return $keyCode;
    }
}
