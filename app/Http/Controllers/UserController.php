<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $list_user = User::orderBy('id', 'desc')->get();
        return view('admin.user.list', compact('list_user'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user.add', compact('roles'));
    }

    public function store(UserRequest $request)
    {

        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone_number' => $validatedData['phone_number'],
        ]);

        $user->roles()->attach($validatedData['role_id']);

        return redirect()->route('admin.user.index')->with('success', 'Thêm thành công');
    }

    public function edit($id)
    {
        $user = User::with('roles')->find($id);
        $roles = Role::all();


        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, $id)
    {

        // Tìm người dùng theo ID
        $user = User::findOrFail($id);

        $validated = $request->validated();
        // Cập nhật thông tin người dùng
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'];

        // Chỉ cập nhật mật khẩu nếu có thay đổi
        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }

        // Cập nhật vai trò
        $user->roles()->sync($validated['role_id']);

        // Lưu thay đổi
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Cập nhập người dùng thành công');
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.user.index')->with('success','Xóa thành công');
    }

    public function deleteAt(){
        $softUser = User::onlyTrashed()->get();
        return view('admin.user.delete',compact('softUser'));
    }

    public function restore($id){
        $user = User::onlyTrashed()->find($id); // Lấy bản ghi bị xóa mềm
        if ($user) {
            $user->restore(); // Khôi phục bản ghi
            return redirect()->back()->with('success', 'Tài khoản đã được khôi phục!');
        }
        return redirect()->back()->with('error', 'Tài khoản không tồn tại hoặc không bị xóa mềm.');
    }

    public function forceDeleteUser($id){
        $user = User::onlyTrashed()->find($id); // Lấy bản ghi bị xóa mềm
        if ($user) {
            $user->forceDelete(); // Xóa vĩnh viễn
            return redirect()->back()->with('success', 'Tài khoản đã được xóa vĩnh viễn!');
        }
        return redirect()->back()->with('error', 'Tài khoản không tồn tại hoặc không bị xóa mềm.');
    }

}
