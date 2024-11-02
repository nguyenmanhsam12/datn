<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('client.pages.login');
    }

    public function postlogin(Request $request){
        $data = $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:6',
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success','Đăng nhập thành công');
        }
 
        return back()->with('error','Thông tin email hoặc mật khẩu không đúng');

    }

    public function logout(){

        Auth::logout();    
        return redirect('/')->with('success','Đăng xuất thành công');
    }


    public function register(){
        return view(('client.pages.register'));
    }

    public function postRegister(RegisterRequest $request){
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $role = Role::where('name','user')->first();

        $user = User::create($data);

        $user->roles()->attach($role);

        return redirect(route('login'))->with('success','Đăng Ký thành công');

        
    }
}
