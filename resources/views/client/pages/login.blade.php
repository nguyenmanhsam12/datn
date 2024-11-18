@extends('client.components.default')

@push('styles')
<style>
    .form-register {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .form-register .form-group {
        margin-bottom: 20px;
        /* Tăng khoảng cách giữa các trường */
    }

    .form-register label {
        font-weight: bold;
        margin-bottom: 5px;
        /* Tạo khoảng cách giữa label và input */
    }

    .form-register .form-control {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        transition: border-color 0.3s ease;
        /* Hiệu ứng chuyển tiếp cho border */
    }

    .form-register .form-control:focus {
        border-color: #007bff;
        /* Đổi màu border khi input được chọn */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        /* Thêm bóng cho input khi focus */
    }

    .form-register .button-register {
        background-color: #007bff;
        /* Nền xanh */
        color: white;
        /* Màu chữ trắng */
        border: none;
        /* Không có viền */
        padding: 10px 20px;
        border-radius: 5px;
        width: 100%;
        /* Làm cho nút đăng ký rộng đầy đủ */
        cursor: pointer;
        /* transition: background-color 0.3s ease, border 0.3s ease, color 0.3s ease; */
        /* Thêm border và color cho transition */
    }

    .form-register .button-register:hover {
        background-color: transparent !important;
        /* Đổi nền thành trong suốt */
        border: 2px solid #007bff;
        /* Thêm viền xanh */
        color: #007bff;
        /* Đổi màu chữ thành xanh */
    }

    
</style>
@endpush

@section('content')
    <div class="heading-banner-area overlay-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-banner">
                        <div class="heading-banner-title">
                            <h2>Đăng nhập</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="{{route('home')}}">Trang chủ</a></li>
                                <li>Đăng nhập</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="login-area  pt-80 pb-80">
        <div class="container">
            <form action="{{ route('postlogin') }}" method="POST" class="form-register">
                @csrf
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="customer-login text-left">
                            <h4 class="title-1 title-border text-uppercase mb-30">Đăng Nhập Tài Khoản</h4>
                            <p class="text-gray mb-4">Hãy điền thông tin bên dưới để đăng nhập.</p>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="abc@gmail.com"
                                    value=" {{  old('email') }}"
                                    >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Mật khẩu"
                                    >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            

                            <button type="submit" class="btn btn-primary button-register">Đăng Nhập</button>
                            <p class="text-gray mt-3">Bạn chưa có tài khoản? <a href="{{ route('register') }}"
                                    class="text-primary">Đăng ký tại đây</a></p>


                                    <p class="text-gray mt-3">Bạn đã  <a href="{{ route('password.request') }}"
                                        class="text-primary">Quên mật khẩu</a></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
