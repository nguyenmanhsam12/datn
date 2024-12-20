<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của bạn</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #e0eafc);
            margin: 0;
            padding: 0;
            color: #333;
        }

        table {
            width: 100%;
            max-width: 900px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        h2, h3 {
            color: #ffffff; /* Đảm bảo màu chữ là trắng */
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        p {
            font-size: 16px;
            line-height: 1.8;
            margin: 10px 0;
        }

        .header {
            background: linear-gradient(135deg, #5e35b1, #9c27b0);
            color: white;
            padding: 40px;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .content {
            padding: 30px;
            background-color: #f9f9f9;
        }

        .order-summary {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .order-summary p {
            margin: 10px 0;
        }

        .order-summary strong {
            color: #9c27b0;
        }

        .order-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .order-items th, .order-items td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .order-items th {
            background-color: #f1f1f1;
            color: #2c3e50;
        }

        .order-items td {
            color: #7f8c8d;
        }

        .footer {
            background-color: #f1f1f1;
            color: #7f8c8d;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .footer a {
            color: #9c27b0;
            text-decoration: none;
            font-weight: bold;
        }

        .total-price {
            font-size: 22px;
            font-weight: bold;
            color: #9c27b0;
            text-align: right;
            margin-top: 20px;
        }

        .product-name {
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <table>
        <tr class="header">
            <td>
                <h2>Đơn hàng của bạn đã được xác nhận!</h2>
                <p>Cảm ơn bạn đã tin tưởng và mua sắm tại cửa hàng của chúng tôi. Chúng tôi sẽ xử lý đơn hàng của bạn ngay lập tức.</p>
            </td>
        </tr>

        <tr class="content">
            <td>
                <div class="order-summary">
                    <h3>Thông tin đơn hàng</h3>
                    <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
                    <p><strong>Phí vận chuyển:</strong> {{ number_format($order->shipping_fee, 0, ',', '.') }} VNĐ</p>
                    <p><strong>Giá tiền giảm:</strong> {{ number_format($order->discount_amount, 0, ',', '.') }} VNĐ</p>
                    <p><strong>Phương thức thanh toán:</strong> {{ optional($order->payment)->name ?? 'Không có thông tin' }}</p>
                </div>

                <div class="order-summary">
                    <h3>Thông tin giao hàng</h3>
                    <p><strong>Người nhận:</strong>{{ $orderAddress->recipient_name }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $orderAddress->address_order }}, 
                        {{ $orderAddress->ward }},
                        {{ $orderAddress->city }},
                        {{ $orderAddress->province }}
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

                @php
                    $finalTotal = $order->total_amount + $order->shipping_fee - $order->discount_amount;
                @endphp

                <p class="total-price">Tổng giá trị đơn hàng: {{ number_format($finalTotal, 0, ',', '.') }} VNĐ</p>
            </td>
        </tr>

        <tr class="footer">
            <td>
                <p>Chúng tôi sẽ gửi bạn thông tin cập nhật về tình trạng đơn hàng qua email. Cảm ơn bạn đã chọn chúng tôi!</p>
                <p><a href="https://www.websitecua.com">Truy cập website của chúng tôi</a></p>
            </td>
        </tr>
    </table>
</body>
</html>
