<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // tạo quyền
    public function createPermission(){
        $list_permission = Permission::where('parent_id',0)->get();
        return view('admin.permission.add',compact('list_permission'));
    }

    public function store(Request $request){
        $data = $request->all();
        
        // Tạo key_code tự động
        $keyCode = $this->generateKeyCode($request);

        $permission = new Permission();

        $permission->name = $data['name'];
        $permission->display_name = $data['display_name'];

        if($data['parent_id'] != 0){
            $permission->parent_id = $data['parent_id'];
            $permission->key_code = $keyCode;
        }

        $permission->parent_id = $data['parent_id'];
        $permission->save();

        return redirect()->back()->with('success','Thêm quyền thành công');
    }

    private function generateKeyCode(Request $request)
    {
        // Tạo key_code tự động từ tên quyền và module cha
        $parentModule = $request->input('parent_id');
        $permissionName = $request->name;

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
