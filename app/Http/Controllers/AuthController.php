<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Models\Brand;
use App\Models\Category;

class AuthController extends Controller
{
    public function login(){
        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();
        return view('client.pages.login',compact('list_brand','list_category'));
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

    public function logout(Request $request){
        Auth::logout();    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success','Đăng xuất thành công');
    }


    public function register(){
        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();
        return view('client.pages.register',compact('list_brand','list_category'));
    }

    public function postRegister(RegisterRequest $request){
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $role = Role::where('name','guest')->first();

        $user = User::create($data);

        $user->roles()->attach($role);

        return redirect(route('login'))->with('success','Đăng Ký thành công');        
    }

    public function showForgotPasswordForm()
    {
            $list_brand = Brand::orderBy('id','desc')->get();
            $list_category = Category::orderBy('id','desc')->get();
            return view('client.pages.ForgotPassword',compact('list_brand','list_category'));
    }

    //otp
    public function sendResetLink(Request $request)
    {
    
        
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ],[
            
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',]
        ); 
        $otp = Str::random(6); 
        session(['otp' => $otp, 'otp_expiry' => now()->addMinutes(5), 'email' => $request->email]);

        //link đmk email
        //    $status = Password::sendResetLink($request->only('email'));
    
        Mail::to($request->email)->queue(new OtpMail($otp));
        return redirect()->route('password.otp')->with('status', 'Mã OTP và link đặt lại mật khẩu đã được gửi đến email của bạn!');
    }
    // form có otp
    public function showOtpForm()
    {
        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();
        return view('client.pages.otp',compact('list_brand','list_category'));
    }

    public function verifyOtp(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'otp' => 'required|string|size:6',  
            'password' => 'required|string|min:8|confirmed',
        ],[
            'otp.required' => 'Mã OTP là bắt buộc.',
            'otp.size' => 'Mã OTP phải có đúng 6 ký tự.',
            'password.required' => 'Mật khẩu mới là bắt buộc.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        // Kiểm tra mã OTP
        $isValidOtp = session('otp') === $request->otp;
        $isExpired = now()->greaterThan(session('otp_expiry'));

        if (!$isValidOtp || $isExpired) {
            return response()->json(['errors' => ['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn.']], 422);
        }

        // Cập nhật mật khẩu cho người dùng
        $user = User::where('email', session('email'))->first();

        // Kiểm tra xem người dùng có tồn tại không
        if (!$user) {
                return response()->json(['errors' => ['otp' => 'Không tìm thấy người dùng.']], 422);
        }

        // Cập nhật mật khẩu
        $user->update(['password' => Hash::make($request->password)]);

        // Xóa thông tin OTP khỏi session
        session()->forget(['otp', 'otp_expiry', 'email']);

        return response()->json(['status' => 'Mật khẩu đã được cập nhật!', 'redirect' => route('login')]);
    }

   // form ko co otp
    //    public function showResetPasswordForm($token)
    //    {
    //        return view('client.pages.reset-password', ['token' => $token]);
    //    }

    //   // Cập nhật mật khẩu mới
    //   public function resetPassword(Request $request)
    //   {
    //       // Xác thực input
    //       $request->validate([
    //           'email' => 'required|email|exists:users,email', // Kiểm tra xem email có tồn tại trong bảng 'users' không
    //           'password' => 'required|string|min:8|confirmed', // Kiểm tra password có hợp lệ và xác nhận mật khẩu
    //           'token' => 'required|string' // Kiểm tra token có được gửi qua không
    //       ]);
    
    //       // Kiểm tra token hợp lệ và gửi yêu cầu reset mật khẩu
    //       $status = Password::reset(
    //           $request->only('email', 'password', 'password_confirmation', 'token'),
    //           function ($user) use ($request) {
    //               // Lưu mật khẩu mới vào user
    //               $user->forceFill([
    //                   'password' => Hash::make($request->password), // Mã hóa mật khẩu
    //               ])->save();
    //           }
    //       );
    
    //       // Kiểm tra kết quả của việc reset
    //       if ($status == Password::PASSWORD_RESET) {
    //           // Nếu mật khẩu đã được đặt lại thành công, chuyển hướng người dùng về trang login
    //           return redirect()->route('login')->with('status', 'Mật khẩu đã được đặt lại thành công!');
    //       }
    
    //       // Nếu có lỗi trong quá trình reset mật khẩu
    //       return back()->withErrors(['email' => 'Đã có lỗi xảy ra khi đặt lại mật khẩu. Hãy thử lại.']);
    //   }
  
}