<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Trạng Thái Đơn Hàng</title>
</head>
<body>
    <h1>Cập nhật trạng thái đơn hàng #{{ $order->id }}</h1>
    <p>Trạng thái đơn hàng của bạn đã được cập nhật thành: {{ $order->orderStatus->name }}</p>
    <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>
</body>
</html>
