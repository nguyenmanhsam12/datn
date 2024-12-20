<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\UpdateRoleRequest;

use Illuminate\Http\Request;



class RoleController extends Controller
{
    public function index(){
        $list_role = Role::all();
        return view('admin.role.list',compact('list_role'));
    }

    public function create(){
        $permission = Permission::where('parent_id',0)->get();
        return view('admin.role.add',compact('permission'));
    }

    public function store(RoleRequest $request){
        $data = $request->validated();

        $role = new Role();
        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->save();

        $role->permissions()->attach($data['permission_id']);

        return redirect()->route('admin.role.index')->with('success','Thêm vai trò thành công');

    }

    public function edit($id){
        $permission = Permission::where('parent_id',0)->get();
        $role = Role::find($id);
        $permissionChecked = $role->permissions;
        return view('admin.role.edit',compact('permission','role','permissionChecked'));
    }

    public function update(UpdateRoleRequest $request , $id){
        $data = $request->validated();

        $role = Role::find($id);
        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->save();

        $role->permissions()->sync($data['permission_id']);

        return redirect()->route('admin.role.index')->with('success','Cập nhập vai trò thành công');

    }

    public function delete($id){

        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('admin.role.index')->with('error', 'Vai trò không tồn tại');
        }
    
        // Xóa tất cả các quyền liên kết với vai trò trước khi xóa vai trò
        $role->permissions()->detach();
    
        // Xóa vai trò
        $role->delete();
    
        return redirect()->route('admin.role.index')->with('success', 'Xóa vai trò thành công');
    }

    
}
