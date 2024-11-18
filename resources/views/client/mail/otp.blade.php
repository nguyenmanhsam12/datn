<!DOCTYPE html>
<html>
<head>
    <title>Yêu cầu đặt lại mật khẩu</title>
</head>
<body>
    <h1>Yêu cầu đặt lại mật khẩu</h1>
    <p>Chào bạn,</p>
    <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Vui lòng sử dụng mã OTP dưới đây để đặt lại mật khẩu:</p>

    <p><strong>{{ $otp }}</strong></p>

    {{-- <p>Hoặc bạn có thể nhấp vào <a href="{{ route('password.reset', ['token' => $status]) }}">đây</a> để thay đổi mật khẩu của mình.</p> --}}

    <p>Mã OTP này sẽ hết hạn trong 5 phút.</p>
</body>
</html>
