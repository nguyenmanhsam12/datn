<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            overflow: hidden;
        }

        .thank-you-card {
            background: rgba(0, 0, 0, 0.7);
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 90%;
            z-index: 1;
        }

        .thank-you-card h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #ffdd57;
        }

        .thank-you-card p {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #f0f0f0;
        }

        .thank-you-card .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .thank-you-card a {
            text-decoration: none;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            border-radius: 5px;
            background: linear-gradient(to right, #ff416c, #ff4b2b);
            box-shadow: 0 5px 15px rgba(255, 65, 108, 0.4);
            transition: transform 0.3s ease;
        }

        .thank-you-card a:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(255, 65, 108, 0.6);
        }
    </style>
</head>
<body>
    <!-- Thẻ video với các thuộc tính đúng -->
    <video autoplay loop muted playsinline class="background-video">
        <source src="{{ asset('img/ty/gif.mp4') }}" type="video/mp4">
        Trình duyệt của bạn không hỗ trợ video.
    </video>

    <div class="thank-you-card">
        <h1>Cảm ơn bạn đã mua hàng!</h1>
        <p>Đơn hàng của bạn đang được xử lý. Chúng tôi sẽ thông báo khi đơn hàng được cập nhật.</p>
        <div class="button-group">
            <a href="{{ route('shop') }}">Tiếp tục mua sắm</a>
            <a href="{{ route('myAccount') }}">Xem đơn hàng</a>
        </div>
    </div>
</body>
</html>
