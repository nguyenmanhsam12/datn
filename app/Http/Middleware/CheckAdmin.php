<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $user = Auth::user();

        if(!$user){
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước');
        }

        // Kiểm tra nếu người dùng tồn tại và chỉ có duy nhất một vai trò là 'guest'
        // hàm first này giúp này 1 phần tử đầu tiên của 1 collection
        if ($user && $user->roles->count() === 1 && $user->roles->first()->name === 'guest') {
            return redirect()->route('home')->with('error', 'Tài khoản này không có quyền truy cập trang quản trị');
        }

        return $next($request);

    }
}
