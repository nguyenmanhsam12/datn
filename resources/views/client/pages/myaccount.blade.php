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

        .btn-info {
            background-color: #E03550;
            color: white;
        }

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
                        <a href="#" class="tab-link" data-status="processing">Đang Xử Lý</a>
                        <a href="#" class="tab-link" data-status="confirming">Đã Xác Nhận</a>
                        <a href="#" class="tab-link" data-status="shipping">Đang Giao Hàng</a>
                        <a href="#" class="tab-link" data-status="delivered">Đã Giao Hàng</a>
                        <a href="#" class="tab-link" data-status="canceled">Đã Hủy</a>
                    </div>

                    <!-- Order Cards -->
                    <div id="ordersContainer">
                        <div class="order-card" data-status="delivered">
                            <div class="order-header">
                                <h6>Đơn Hàng #12345</h6>
                                <p class="order-status text-success">Đã Giao Hàng</p>
                            </div>
                            <div class="order-body">
                                <div class="order__left">
                                    <div class="image">
                                        <img src="https://via.placeholder.com/80" alt="product image" class="img-fluid">
                                    </div>
                                    <div class="order-details">
                                        <p><strong>Sản Phẩm:</strong> Giày Thể Thao</p>
                                        <p><strong>Kích Cỡ:</strong> 40</p>
                                        <p><strong>Số Lượng:</strong> 1</p>
                                    </div>
                                </div>
                                <div class="order__right">
                                    <p><strong>Tổng Tiền:</strong> 500,000 VND</p>
                                    <div class="button-group">
                                        <button class="btn btn-info">Xem Chi Tiết</button>
                                        <button class="btn btn-primary">Mua Lại</button>
                                        <button class="btn btn-success">Đánh Giá</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="order-card" data-status="processing">
                            <div class="order-header">
                                <h6>Đơn Hàng #12346</h6>
                                <p class="order-status text-warning">Đang Chờ Xử Lý</p>
                            </div>
                            <div class="order-body">
                                <div class="order__left">
                                    <div class="image">
                                        <img src="https://via.placeholder.com/80" alt="product image" class="img-fluid">
                                    </div>
                                    <div class="order-details">
                                        <p><strong>Sản Phẩm:</strong> Giày Thể Thao</p>
                                        <p><strong>kích cỡ:</strong> 40</p>
                                        <p><strong>Số Lượng:</strong> 1</p>
                                    </div>
                                </div>
                                <div class="order__right">
                                    <p><strong>Tổng Tiền:</strong> 400,000 VND</p>
                                    <div class="button-group">
                                        <button class="btn btn-info">Xem Chi Tiết</button>
                                        <button class="btn btn-danger">Hủy Đơn Hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="order-card" data-status="confirming">
                            <div class="order-header">
                                <h6>Đơn Hàng #12348</h6>
                                <p class="order-status text-success">Đã Xác Nhận</p>
                            </div>
                            <div class="order-body">
                                <div class="order__left">
                                    <div class="image">
                                        <img src="https://via.placeholder.com/80" alt="product image" class="img-fluid">
                                    </div>
                                    <div class="order-details">
                                        <p><strong>Sản Phẩm:</strong> Giày Thể Thao</p>
                                        <p><strong>Kích Cỡ:</strong> 40</p>
                                        <p><strong>Số Lượng:</strong> 1</p>
                                    </div>
                                </div>
                                <div class="order__right">
                                    <p><strong>Tổng Tiền:</strong> 400,000 VND</p>
                                    <div class="button-group">
                                        <button class="btn btn-info">Xem Chi Tiết</button>
                                        <button class="btn btn-secondary">Liên Hệ Hỗ Trợ</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="order-card" data-status="shipping">
                            <div class="order-header">
                                <h6>Đơn Hàng #12347</h6>
                                <p class="order-status text-primary">Đang Giao Hàng</p>
                            </div>
                            <div class="order-body">
                                <div class="order__left">
                                    <div class="image">
                                        <img src="https://via.placeholder.com/80" alt="product image" class="img-fluid">
                                    </div>
                                    <div class="order-details">
                                        <p><strong>Sản Phẩm:</strong> Giày Thể Thao</p>
                                        <p><strong>Kích Cỡ:</strong> 40</p>
                                        <p><strong>Số Lượng:</strong> 1</p>
                                    </div>
                                </div>
                                <div class="order__right">
                                    <p><strong>Tổng Tiền:</strong> 700,000 VND</p>
                                    <div class="button-group">
                                        <button class="btn btn-info">Xem Chi Tiết</button>
                                        <button class="btn btn-primary">Theo Dõi Giao Hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="order-card" data-status="canceled">
                            <div class="order-header">
                                <h6>Đơn Hàng #12347</h6>
                                <p class="order-status text-danger">Đã Hủy</p>
                            </div>
                            <div class="order-body">
                                <div class="order__left">
                                    <div class="image">
                                        <img src="https://via.placeholder.com/80" alt="product image" class="img-fluid">
                                    </div>
                                    <div class="order-details">
                                        <p><strong>Sản Phẩm:</strong> Giày Thể Thao</p>
                                        <p><strong>Kích Cỡ:</strong> 40</p>
                                        <p><strong>Số Lượng:</strong> 1</p>
                                    </div>
                                </div>
                                <div class="order__right">
                                    <p><strong>Tổng Tiền:</strong> 700,000 VND</p>
                                    <div class="button-group">
                                        <button class="btn btn-info">Xem Chi Tiết</button>
                                        <button class="btn btn-secondary">Đặt Lại Đơn Hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
@endsection
