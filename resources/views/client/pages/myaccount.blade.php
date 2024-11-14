@extends('client.components.default')

@push('styles')
    <style>
        .sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .sidebar a {
            display: block;
            padding: 10px 0;
            color: #333;
            text-decoration: none;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        .sidebar a:hover {
            background-color: #e9ecef;
        }

        .sidebar a.active {
            font-weight: bold;
            color: #E03550;
        }

        .account-info,
        .order-list {
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .order-status {
            font-size: 14px;
            font-weight: bold;
        }

        .order__left img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .order__right {
            text-align: right;
        }

        /* .btn-info {
                                    background-color: #E03550;
                                    color: white;
                                } */

        .tab-links a {
            display: inline-block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }

        .tab-links a.active {
            background-color: #E03550;
            color: white;
        }

        .order-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .order__left {
            display: flex;
            align-items: center;
        }

        .order__left .image {
            margin-right: 10px;
        }

        .order-details p {
            margin: 0;
            font-size: 14px;
        }

        .order__right {
            text-align: right;
        }


        .order-status[data-status="1"] {
            color: #FFC107;
            /* Đang chờ xử lý */
        }

        .order-status[data-status="2"] {
            color: #17A2B8;
            /* Đã xác nhận */
        }

        .order-status[data-status="3"] {
            color: #007BFF;
            /* Đang vận chuyển */
        }

        .order-status[data-status="4"] {
            color: #28A745;
            /* Đang giao hàng */
        }

        .order-status[data-status="5"] {
            color: #28A745;
            /* Hoàn tất */
        }

        .order-status[data-status="6"] {
            color: #DC3545;
            /* Đã hủy */
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
                            <h2>Tài Khoản Của Tôi</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="">Trang Chủ</a></li>
                                <li>Tài Khoản Của Tôi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h4 class="mb-4">Admin!</h4>
                    <div class="sidebar-nav">
                        <a href="#" id="accountLink" class="active">Quản Lý Tài Khoản</a>
                        <a href="#" id="ordersLink">Đơn Mua</a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Account Information Section -->
                <div class="account-info" id="accountInfo">
                    <h5>Thông Tin Tài Khoản</h5>
                    <p>Họ và Tên: <strong>Nguyễn Văn A</strong></p>
                    <p>Email: <strong>email@example.com</strong></p>
                    <p>Số Điện Thoại: <strong>0123456789</strong></p>
                    <button class="btn btn-primary">Chỉnh Sửa</button>
                </div>

                <!-- Order List Section -->
                <div class="order-list" id="orderList" style="display: none;">
                    <h5>Danh Sách Đơn Mua</h5>

                    <!-- Tab Links for Order Status -->
                    <div class="tab-links">
                        <a href="#" class="tab-link active" data-status="all">Tất Cả</a>
                        @foreach ($status as $st)
                            <a href="#" class="tab-link" data-status="{{ $st->id }}">{{ $st->name }}</a>
                        @endforeach
                    </div>

                    <!-- Order Cards -->
                    <div id="ordersContainer">
                        @foreach ($order as $or)
                            <div class="order-card" data-status="{{ $or->status_id }}" data-order-id={{ $or->id }}>
                                <div class="order-header">
                                    <h6 class="order-id">Đơn Hàng #{{ $or->id }}
                                    </h6>
                                    <p class="order-status " data-status= "{{ $or->status_id }}">{{ $or->orderStatus->name }}</p>
                                </div>
                                <div class="order-body">
                                    @foreach ($or->cartItems as $item)
                                        <div class="order__left">
                                            <div class="image">
                                                <img src="{{ $item->product_image }}" alt="product image" class="img-fluid">
                                            </div>
                                            <div class="order-details">
                                                <p><strong>Sản Phẩm:</strong>{{ $item->product_name }}</p>
                                                <p><strong>Kích Cỡ:</strong>{{ $item->size }}</p>
                                                <p><strong>Số Lượng:</strong>{{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <div class="order__right">
                                            @php
                                                $newTotal = 0;
                                                $newTotal =
                                                    $or->total_amount - $or->discount_amount + $or->shipping_fee;
                                            @endphp
                                            <p><strong>Tổng
                                                    Tiền:</strong>{{ number_format($newTotal, 0, ',', '.') . ' VNĐ' }}
                                            </p>
                                            <div class="button-group">
                                                <button class="btn btn-success">Xem Chi Tiết</button>
    
                                                <!-- Nút Hủy cho trạng thái "Chờ xử lý" -->
                                                @if ($or->status_id == 1)
                                                    <button class="btn btn-danger">Hủy</button>
                                                @endif
                                                
                                                <!-- Nút xác nhận đơn hàng cho trạng thái "Đã giao" -->
                                                @if ($or->status_id == 4)
                                                    <button class="btn btn-primary">Xác Nhận Đơn Hàng</button>
                                                @endif
                                                
                                                <!-- Nút Khiếu nại cho trạng thái "Hoàn tất" -->
                                                @if ($or->status_id == 5)
                                                    <button class="btn btn-warning">Khiếu Nại</button>
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        // Switching between Account and Orders sections
        document.getElementById('accountLink').addEventListener('click', function() {
            document.getElementById('accountInfo').style.display = 'block';
            document.getElementById('orderList').style.display = 'none';
            document.getElementById('accountLink').classList.add('active');
            document.getElementById('ordersLink').classList.remove('active');
        });

        document.getElementById('ordersLink').addEventListener('click', function() {
            document.getElementById('accountInfo').style.display = 'none';
            document.getElementById('orderList').style.display = 'block';
            document.getElementById('ordersLink').classList.add('active');
            document.getElementById('accountLink').classList.remove('active');
        });

        // Switching tabs for Order Status
        document.querySelectorAll('.tab-link').forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.tab-link').forEach(function(t) {
                    t.classList.remove('active');
                });
                tab.classList.add('active');

                const status = tab.getAttribute('data-status');
                const orders = document.querySelectorAll('.order-card');
                orders.forEach(function(order) {
                    if (status === 'all' || order.getAttribute('data-status') === status) {
                        order.style.display = 'block';
                    } else {
                        order.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script type="module">
        // Lắng nghe sự kiện từ Laravel Echo
        Echo.channel('order')
            .listen('OrderStatusUpdatedEvent', (e) => {
                console.log(e); // Kiểm tra dữ liệu sự kiện nhận được

                // Lấy thông tin từ sự kiện
                const orderId = e.order.id;
                const newStatus = e.order.order_status.name;
                const newStatusId = e.order.status_id;


                // Tìm đơn hàng trong DOM theo `data-order-id`
                const orderElement = document.querySelector(`.order-card[data-order-id="${orderId}"]`);

                if (orderElement) {
                    // Cập nhật tên trạng thái đơn hàng
                    const statusElement = orderElement.querySelector('.order-status');
                    
                    statusElement.textContent = newStatus;
                    statusElement.setAttribute('data-status', newStatusId); // Cập nhật data-status


                    // Cập nhật `data-status` với trạng thái mới
                    orderElement.setAttribute('data-status', newStatusId);

                    

                    // Hiển thị và ẩn các nút button theo `newStatusId`
                    const buttonGroup = orderElement.querySelector('.button-group');
                    buttonGroup.innerHTML = ''; // Xóa các nút hiện có

                    // Thêm nút dựa vào trạng thái mới
                    if (newStatusId === 1) { // Trạng thái "Chờ xử lý"
                        buttonGroup.innerHTML = '<button class="btn btn-danger">Hủy</button><button class="btn btn-success">Xem chi tiết</button>';
                    } else if(newStatusId === 2){
                        buttonGroup.innerHTML = '<button class="btn btn-success">Xem chi tiết</button>';
                    } else if(newStatusId === 3){
                        buttonGroup.innerHTML = '<button class="btn btn-success">Xem chi tiết</button>';
                    } else if(newStatusId === 4){
                        buttonGroup.innerHTML = '<button class="btn btn-success">Xem chi tiết</button><button class="btn btn-primary">Xác nhận đơn hàng</button>';
                    } else if(newStatusId === 5){
                        buttonGroup.innerHTML = '<button class="btn btn-success">Xem chi tiết</button><button class="btn btn-warning">Khiếu nại</button>';
                    }


                    // Lọc và hiển thị đơn hàng theo tab trạng thái hiện tại
                    const activeStatus = document.querySelector('.tab-link.active').getAttribute('data-status');
                    if (activeStatus !== 'all' && activeStatus !== newStatusId.toString()) {
                        orderElement.style.display = 'none';
                    } else {
                        orderElement.style.display = 'block';
                    }
                }
            });
    </script>
@endpush
