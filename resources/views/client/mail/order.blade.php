<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của bạn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        h2, h3 {
            color: #2a2a2a;
        }

        p {
            font-size: 14px;
            line-height: 1.6;
        }

        .header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .content {
            padding: 20px;
        }

        .order-summary {
            margin-bottom: 20px;
            border-bottom: 2px solid #f4f4f4;
        }

        .order-summary th, .order-summary td {
            padding: 10px;
            text-align: left;
        }

        .order-summary th {
            background-color: #f8f8f8;
            color: #555;
        }

        .order-summary td {
            font-size: 14px;
        }

        .order-items td {
            padding: 10px;
        }

        .order-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-items th {
            background-color: #f8f8f8;
        }

        .footer {
            background-color: #f8f8f8;
            color: #777;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .footer a {
            color: #28a745;
            text-decoration: none;
        }

        .total-price {
            font-size: 16px;
            font-weight: bold;
            color: #2a2a2a;
        }

        .product-name {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table>
        <tr class="header">
            <td>
                <h2>Đơn hàng của bạn đã được xác nhận!</h2>
                <p>Chúng tôi xin cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi.</p>
            </td>
        </tr>

        <tr class="content">
            <td>
                <div class="order-summary">
                    <h3>Thông tin đơn hàng</h3>
                    <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
                    <p><strong>Tổng giá trị:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</p>
                    <p><strong>Phương thức thanh toán:</strong> {{ optional($order->payment)->name ?? 'Không có thông tin' }}</p>
                </div>

                <div class="order-summary">
                    <h3>Thông tin giao hàng</h3>
                    <p><strong>Người nhận:</strong> {{ $orderAddress->recipient_name }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $orderAddress->address_order }}, 
                        {{ $orderAddress->ward }},
                        {{ $orderAddress->city }},
                        {{ $orderAddress->province }}
                        </p>
                    </p>
                    <p><strong>Số điện thoại:</strong> {{ $orderAddress->phone_number }}</p>
                </div>

                <h3>Chi tiết sản phẩm trong đơn hàng</h3>
                <table class="order-items">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Kích cỡ</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->cartItems as $item)
                            <tr>
                                <td class="product-name">{{ $item->product_name }}</td>
                                <td>{{ $item->size }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p class="total-price">Tổng giá trị đơn hàng: {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</p>
            </td>
        </tr>

        <tr class="footer">
            <td>
                <p>Chúng tôi sẽ gửi bạn thông tin cập nhật về tình trạng đơn hàng qua email. Cảm ơn bạn đã chọn chúng tôi!</p>
                <p><a href="{{ route('home') }}">Truy cập website của chúng tôi</a></p>
            </td>
        </tr>
    </table>
</body>
</html>
