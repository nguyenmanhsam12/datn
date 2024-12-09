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
                            <h2>Quên mật khẩu</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="{{route('home')}}">Trang chủ</a></li>
                                <li>Quên mật khẩu</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="login-area  pt-80 pb-80">
<div class="container">
    <h2>Đặt lại mật khẩu mới</h2>

    <form id="reset-password-form" class="form-register">
        @csrf
        <div class="form-group">
            <label for="otp">Mã OTP</label>
            <input type="text" name="otp" id="otp" class="form-control" required>
            <span id="otp-error" class="invalid-feedback" style="display:none;"></span>
        </div>
    
        <div class="form-group">
            <label for="password">Mật khẩu mới</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <div id="password-error" class="invalid-feedback" style="display:none;"></div>
    
        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
    
        <button type="submit" class="btn btn-primary">Đặt lại mật khẩu</button>
    </form>
    
    <div id="success-message" class="alert alert-success" style="display:none;"></div>
    

    
</div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#reset-password-form').on('submit', function(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của form

        // Xóa thông báo lỗi trước đó
        $('#otp-error').hide();
        $('#password-error').hide();
        $('#success-message').hide();

        // Lấy dữ liệu từ form
        const formData = {
            otp: $('#otp').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            url: '{{ route("password.verifyOtp") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Hiển thị thông báo thành công
                $('#success-message').text(response.status).show();
                window.location.href = response.redirect;
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Nếu có lỗi validation, hiển thị thông báo lỗi
                    const errors = xhr.responseJSON.errors;
                    if (errors.otp) {
                        $('#otp-error').text(errors.otp).show();
                    }
                    if (errors.password) {
                        $('#password-error').text(errors.password).show();
                    }
                } else {
                    // Xử lý các lỗi khác nếu cần
                    console.error('Có lỗi xảy ra:', xhr);
                }
            }
        });
    });
});
</script>
