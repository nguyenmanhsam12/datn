<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $list_role = Role::orderBy('id','desc')->get();
        return view('admin.role.list',compact('list_role'));
    }

    public function create(){
        $permission = Permission::where('parent_id',0)->get();
        return view('admin.role.add',compact('permission'));
    }

    public function store(Request $request){
        $data = $request->all();

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

    public function update(Request $request , $id){
        $data = $request->all();

        $role = Role::find($id);
        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->save();

        $role->permissions()->sync($data['permission_id']);

        return redirect()->route('admin.role.index')->with('success','Cập nhập vai trò thành công');

    }

    
}
