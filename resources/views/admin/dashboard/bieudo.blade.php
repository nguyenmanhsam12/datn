@extends('admin.layout.default')

@section('content')
<style>
    /* Tùy chỉnh giao diện tổng quan */
.content-wrapper {
    background-color: #f9f9f9;
    padding: 20px;
}

.card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card h5 {
    font-size: 18px;
    margin-bottom: 15px;
}

.card .card-text {
    font-size: 24px;
}

.card .btn-group a {
    margin: 0 5px;
    border-radius: 50px;
}

.card .btn-group a.active {
    background-color: #0275d8;
    color: white;
}

/* Màu sắc cho các loại thẻ */
.card.text-center {
    transition: all 0.3s;
}

.card.text-center:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.card.bg-primary {
    background-color: #007bff !important;
    color: white !important;
}

.card.bg-success {
    background-color: #28a745 !important;
    color: white !important;
}

.card.bg-warning {
    background-color: #ffc107 !important;
    color: black !important;
}

.card.bg-danger {
    background-color: #dc3545 !important;
    color: white !important;
}

/* Tùy chỉnh biểu đồ */
.chart-container {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}


canvas {
    max-width: 100%;
    height: auto;
}

/* Giao diện chung cho tiêu đề */
h1, h3 {
    font-weight: bold;
    color: #333;
}

/* Padding và bố cục */
.row {
    margin-bottom: 20px;
}

.row .col-md-3, .row .col-md-5, .row .col-md-7 {
    margin-bottom: 15px;
}

/* Form lọc */
form#filterForm {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
}

form#filterForm .form-label {
    font-weight: bold;
    color: #555;
}

form#filterForm .form-control-sm {
    border-radius: 5px;
    font-size: 14px;
}
canvas {
    max-width: 100%;
    max-height: 100%;
    height: auto; /* Đảm bảo tỷ lệ chiều cao và chiều rộng */
}
.container-fluid {
    margin-top: 20px; /* Khoảng cách từ trên xuống */
}

.card {
    border-radius: 10px; /* Bo tròn góc cho thẻ card */
    overflow: hidden; /* Ẩn phần thừa ra ngoài thẻ card */
}

.card-body {
    padding: 20px; /* Khoảng cách bên trong cho card body */
}

h3 {
    font-size: 24px; /* Kích thước chữ tiêu đề */
}

.table {
    border-collapse: collapse; /* Để loại bỏ khoảng cách giữa các ô */
}

.table th, .table td {
    text-align: center; /* Căn giữa nội dung */
    vertical-align: middle; /* Căn giữa theo chiều dọc */
    padding: 15px; /* Khoảng cách giữa nội dung và viền ô */
    font-size: 16px; /* Kích thước chữ cho ô */
}

.table thead th {
    font-weight: bold; /* Làm đậm tiêu đề bảng */
    font-size: 1.1rem; /* Tăng kích thước chữ tiêu đề */
}

.table tbody tr {
    transition: background-color 0.3s, transform 0.3s; /* Hiệu ứng chuyển màu cho hàng */
}

.table tbody tr:hover {
    background-color: #e8f5e9; /* Màu nền khi hover vào hàng */
    transform: translateY(-2px); /* Nhấc hàng lên khi hover */
}

.table img {
    border-radius: 8px; /* Bo tròn góc ảnh */
    max-width: 100%; /* Đảm bảo ảnh không vượt quá chiều rộng của ô */
    height: auto; /* Tự động điều chỉnh chiều cao của ảnh */
    transition: transform 0.3s; /* Thêm hiệu ứng chuyển động */
}

.table img:hover {
    transform: scale(1.1); /* Tăng kích thước ảnh khi hover */
}

.product-link {
    color: #4caf50; /* Màu xanh lá cây cho liên kết */
    text-decoration: none; /* Không có gạch chân */
    font-weight: bold; /* Làm đậm chữ liên kết */
    transition: color 0.3s; /* Hiệu ứng chuyển màu */
}

.product-link:hover {
    color: #388e3c; /* Màu khi hover vào liên kết */
    text-decoration: underline; /* Gạch chân khi hover */
}

/* Responsive */
@media (max-width: 768px) {
    .table {
        font-size: 14px; /* Giảm kích thước chữ trên màn hình nhỏ */
    }
    
    h3 {
        font-size: 20px; /* Giảm kích thước chữ tiêu đề trên màn hình nhỏ */
    }
}


</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 style="font-weight: bold;">Thống kê</h1>
                </div>
            </div>
        </div>

    <div class="container">
        <div class="row">
        <!-- Total Orders -->
            <div class="col-md-3">
                <a href="{{ route('admin.order.index') }}">
                <div class="card text-center" style="background-color: #4db6ac; color: white;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-shopping-cart"></i> Tổng số đơn hàng
                        </h5>
                        <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $sldh }}</p>
                    </div>
                </div>
            </a>
            </div>

        <!-- Total Products -->
        <div class="col-md-3">
            <a href="{{ route('admin.product.index') }}">
            <div class="card text-center" style="background-color: #f06292; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-box"></i>Số sản phẩm
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $totalProducts }}</p>
                </div>
            </div></a>
        </div>

           <!-- Ratings -->
           <div class="col-md-3">
            <div class="card text-center" style="background-color: #ffb74d; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-star"></i> Tổng doanh thu
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ number_format($doanhThu, 2) }}VND</p>
                </div>
            </div>
        </div>

        <!-- Total Admins -->
        <div class="col-md-3">
            <a href="{{ route('admin.user.index') }}">
            <div class="card text-center" style="background-color: #64b5f6; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-shield"></i> Tống số tài khoản
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $totalAdmins }}</p>
                </div>
            </div></a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.category.index') }}">
            <div class="card text-center" style="background-color: #64b5f6; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-shield"></i> Số danh mục
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $totalCategories }}</p>
                </div>
            </div></a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.coupons.index') }}">
            <div class="card text-center" style="background-color: #64b5f6; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-shield"></i> Mã giảm giá còn hạn
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $activeCouponsCount }}</p>
                </div>
            </div></a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.comlaints.index') }}">
            <div class="card text-center" style="background-color: #64b5f6; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-shield"></i> Đơn hàng đang khiếu nại
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $khieuNai }}</p>
                </div>
            </div></a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.reviews.index') }}">
            <div class="card text-center" style="background-color: #64b5f6; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-shield"></i> Đánh giá
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $totalReviewsCount }}</p>
                </div>
            </div></a>
        </div>

     
    </div>
</div>
        {{-- <!-- Form lọc -->
    <form id="filterForm" class="mb-4 p-4 shadow-sm rounded bg-light">
        @csrf
            <div class="row">
                <!-- First Row -->
                <div class="col-md-4 mb-2">
                    <label for="start_date" class="form-label">Ngày bắt đầu</label>
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ $startDate->format('Y-m-d\TH:i') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="end_date" class="form-label">Ngày kết thúc</label>
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ $endDate->format('Y-m-d\TH:i') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="status_id" class="form-label">Trạng thái</label>
                        <select name="status_id" id="status_id" class="form-control form-control-sm">
                            <option value="">Tất cả trạng thái</option>
                                @foreach ($revenueByStatus as $status)
                                    <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                    </select>
                </div>
                    <!-- Second Row -->
                <div class="col-md-4 mb-2">
                    <label for="payment_method_id" class="form-label">Phương thức thanh toán</label>
                        <select name="payment_method_id" id="payment_method_id" class="form-control form-control-sm">
                            <option value="">Tất cả phương thức</option>
                                @foreach ($revenueByPaymentMethod as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}" {{ request('payment_method_id') == $paymentMethod->id ? 'selected' : '' }}>
                                        {{ $paymentMethod->name }}
                                    </option>
                                @endforeach
                        </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="coupon_id" class="form-label">Mã giảm giá</label>
                        <select name="coupon_id" id="coupon_id" class="form-control form-control-sm">
                            <option value="">Tất cả mã giảm giá</option>
                                @foreach ($revenueByCoupon as $coupon)
                                    <option value="{{ $coupon->id }}" {{ request('coupon_id') == $coupon->id ? 'selected' : '' }}>
                                        {{ $coupon->code }}
                                    </option>
                                @endforeach
                        </select>
                </div>
                    <div class="col-md-4 mb-2 d-flex align-items-end">
                        <button type="submit" id="filter-button" class="btn btn-primary w-100">Lọc</button>
                    </div>
                </div>

    </form>

    <!-- Kết quả lọc -->
    <div class="row mt-4 justify-content-center" id="statistics">
        <div class="col-md-3 mb-3">
            <div class="stat-card p-3 text-center bg-primary text-white rounded">
                <h4>Tổng giá trị</h4>
                <p id="totalRevenue" class="stat-value">{{ number_format($totalRevenue, 2) }} VND</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card p-3 text-center bg-success text-white rounded">
                <h4>Số đơn hàng</h4>
                <p id="totalOrders" class="stat-value">{{ $totalOrders }}</p>
            </div>
        </div>
    </div> --}}

            {{-- Xử lý ajax
            <script>
                $(document).ready(function() {
                    $('#filterForm').on('submit', function(e) {
                        e.preventDefault();// ngừng load tang
                        var formData = $(this).serialize();

                        $.ajax({
                            url: '{{ route('dashboard') }}',
                            method: 'GET',
                            data: formData,
                            success: function(response) {
                                $('#totalRevenue').text(response.totalRevenue + ' VND');
                                $('#totalOrders').text(response.totalOrders);
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        });
                    });
                });
            </script> --}}
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 style="font-weight: bold;">Biểu đồ</h1>
                </div>
            </div>
            <!-- Biểu đồ (Chart Containers) -->
            <div class="row mt-4">
                <div class="col-md-7">
                    <div class="card p-4 border" style="height: 450px;">
                        <div class="card-header-action">
                            <div class="btn-group">
                                <a href="#" class="btn btn-primary" id="show-week">Ngày</a>
                                <a href="#" class="btn" id="show-month">Tháng</a>
                            </div>
                        </div>
                        <h3 class="text-center">Biểu đồ doanh thu</h3>
                        <canvas id="revenueChart" width="1350" height="650"></canvas>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card p-4 border" style="height: 450px;">
                        <h3 class="text-center">Biểu đồ trạng thái đơn hàng</h3>
                        <div class="chart-container d-flex justify-content-center" style="width: 100%; height: 100%; overflow: hidden;">
                            <canvas id="orderStatusChart" width="700" height="600" style="max-width: 100%; max-height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card p-4 border" style="max-width: 100%;">
                        <h3 class="text-center">Doanh thu sản phẩm theo các tỉnh</h3>
                        <div class="chart-container" style="height: 450px;">
                            <canvas id="revenueSalesChart" style="width: 100%; height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
                

            {{-- Script for charts --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // biểu đồ ngày 
               
            
              
                var abc = document.getElementById('revenueChart').getContext('2d');

                
                var revenueChart = new Chart(abc, {
                    type: 'line',
                    data: {
                        labels: @json($dates),
                        datasets: [{
                            label: 'Doanh thu (VND)',
                            data: @json($totals),
                            tension: 0.4,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            barThickness: 10,
                            fill: true,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                                    }
                                }
                            }
                        },
                        responsive: true,
                    }
                });
                var revenueChart2 = null; 
                document.getElementById('show-week').addEventListener('click', function(e) {
                    e.preventDefault();
                      // Hủy biểu đồ tháng nếu tồn tại
                        if (revenueChart2) {
                            revenueChart2.destroy();
                            revenueChart2 = null;
                        }
                        if (!revenueChart) {
                            var revenueChart = new Chart(abc, {
                    type: 'line',
                    data: {
                        labels: @json($dates),
                        datasets: [{
                            label: 'Doanh thu (VND)',
                            data: @json($totals),
                            tension: 0.4,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                                    }
                                }
                            }
                        },
                        responsive: true,
                    }
                });
                        }
                        this.classList.add('btn-primary');
    document.getElementById('show-month').classList.remove('btn-primary');
                });
                document.getElementById('show-month').addEventListener('click', function(e) {
                    e.preventDefault();
                      // Hủy biểu đồ tuần nếu tồn tại
    if (revenueChart) {
        revenueChart.destroy();
        revenueChart = null;
    }
    if (!revenueChart2) {
        var revenueChart2 = new Chart(abc, {
                    type: 'line',
                    data: {
                        labels: @json($salesMonths),
                        datasets: [{
                            label: 'Doanh thu (VND)',
                            data: @json($salesTotals),
                            tension: 0.4,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                                    }
                                }
                            }
                        },
                        responsive: true,
                    }
                });
    }
    this.classList.add('btn-primary');
    document.getElementById('show-week').classList.remove('btn-primary');
                });
   
         // end doanh thu

                // biểu đồ trạng thái
                var statuses = @json($statuses);
                var statusCounts = @json($orderStatusCounts);

                var labels = [];
                var data = [];
                
                statuses.forEach(function(status) {
                    labels.push(status.name);
                    var statusCount = statusCounts.find(count => count.status_id === status.id);
                    data.push(statusCount ? statusCount.count : 0);
                });

                var ctx = document.getElementById('orderStatusChart').getContext('2d');
                var orderStatusChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Trạng thái đơn hàng',
                            data: data,
                            backgroundColor: [
                                'rgba(255, 127, 80, 0.6)',   // Light Coral
                                'rgba(0, 191, 255, 0.6)',   // Deep Sky Blue
                                'rgba(50, 205, 50, 0.6)',   // Lime Green
                                'rgba(255, 215, 0, 0.6)',   // Golden Yellow
                                'rgba(148, 0, 211, 0.6)',   // Soft Purple
                                'rgba(211, 211, 211, 0.6)', // Sky Gray
                                'rgba(220, 20, 60, 0.6)'    // Crimson Red
                            ],
                            borderColor: [
                                'rgba(255, 127, 80, 1)',     // Light Coral
                                'rgba(0, 191, 255, 1)',     // Deep Sky Blue
                                'rgba(50, 205, 50, 1)',     // Lime Green
                                'rgba(255, 215, 0, 1)',     // Golden Yellow
                                'rgba(148, 0, 211, 1)',     // Soft Purple
                                'rgba(211, 211, 211, 1)',   // Sky Gray
                                'rgba(220, 20, 60, 1)'      // Crimson Red
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.raw + ' đơn hàng';
                                    }
                                }
                            }
                        }
                    }
                });


      

    // biểutỉnh
      // Lấy dữ liệu từ server (dữ liệu đã được truyền qua Blade)
      var provinces = @json($revenueAndSalesData->pluck('province'));  // Tỉnh/thành phố
    var salesData = @json($revenueAndSalesData->pluck('total_sales'));  // Số lượng bán
    var revenueData = @json($revenueAndSalesData->pluck('total_revenue'));  // Doanh thu

    // Khởi tạo biểu đồ
    var ctx = document.getElementById('revenueSalesChart').getContext('2d');
    var revenueSalesChart = new Chart(ctx, {
        type: 'bar',  // Mặc định là 'bar' cho cột
        data: {
            labels: provinces,  // Tên tỉnh/thành phố
            datasets: [{
                label: 'Số lượng bán',  // Chú thích cho biểu đồ cột
                data: salesData,  // Dữ liệu số lượng bán
                backgroundColor: 'rgba(255, 99, 132, 0.5)',  // Màu nền của cột
                borderColor: 'rgba(255, 99, 132, 1)',  // Màu viền cột
                borderWidth: 1,
                barThickness: 50,
                // Tùy chọn này để cột không bị đè lên nhau khi có cả đường
                yAxisID: 'y1'  // Sử dụng trục y thứ hai cho cột

            },
            {
                label: 'Doanh thu',  // Chú thích cho biểu đồ đường
                data: revenueData,  // Dữ liệu doanh thu
                type: 'line',  // Đặt kiểu là đường
                fill: false,  // Không tô màu dưới đường
                borderColor: 'rgba(75, 192, 192, 1)',  // Màu của đường
                borderWidth: 2,
                tension: 0.4,  // Độ cong của đường
                yAxisID: 'y2'  // Sử dụng trục y thứ hai cho đường
            }
            ],
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    
                    beginAtZero: true,  // Trục X bắt đầu từ 0
                    title: {
                        display: true,
                        text: 'Tỉnh/Thành phố'  // Tên trục X
                    }
                },
                y: {
                    beginAtZero: true,  // Trục Y bắt đầu từ 0
                    title: {
                        display: true,
                        
                    },
                    ticks: {
                        display: false  // Ẩn chú thích số liệu bên trái
                    }
                    
                },
                // Thêm một trục y thứ hai cho doanh thu
                y2: {
                    beginAtZero: true,  // Trục Y thứ hai bắt đầu từ 0
                    title: {
                        display: true,
                      
                    },
                    position: 'right',  // Đặt trục Y thứ hai ở bên phải
                    ticks: {
                        
                        callback: function(value) {
                            return value.toLocaleString();  // Định dạng số liệu
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',  // Vị trí của legend
                }
            }
        }
    });

            </script>
            

        </div>
    </section>

    </div>
{{-- 
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-2">
            <h3 class="text-center mb-4" style="font-weight: bold; color: #4caf50;">Danh sách đơn hàng mới</h3>
            <div class="card shadow-md" style="background-color: #ffffff;">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #4caf50; color: white;">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Tên khách hàng</th>
                                <th>Trạng thái</th>
                                <th>Mã giảm giá</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                    <td>{{ $order->orderStatus ? $order->orderStatus->name : 'N/A' }}</td>
                                    <td>{{ $order->coupon ? $order->coupon->code : 'Không có' }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
--}}
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-2">
            <h3 class="text-center mb-4" style="font-weight: bold; color: #4caf50;">Sản phẩm bán chạy</h3>
            <div class="card shadow-md" style="background-color: #ffffff;">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #4caf50; color: white;">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng bán</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $item)
                                <tr>
                                    <td>
                                        @if ($item->productVariant && $item->productVariant->product)
                                            <a href="{{ route('getDetailProduct', ['slug' => $item->productVariant->product->slug]) }}" style="color:black">
                                                {{ $item->productVariant->product->name }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $item->total_sold }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 



{{-- ton kho --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-2">
            <h3 class="text-center mb-4" style="font-weight: bold; color: #4caf50;">Số lượng tồn kho</h3>
            <div class="card shadow-md" style="background-color: #ffffff;">
                <div class="card-body">
           
                    <table class="table table-bordered table-hover table-striped">
                        <thead style="background-color: #4caf50; color: white;">
                            <tr>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Tồn kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sanPham as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('getDetailProduct', ['slug' => $item->product->slug]) }}" > 
                                        <img src="{{$item->product->image}}" alt="" style="height:150px; border-radius: 8px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('getDetailProduct', ['slug' => $item->product->slug]) }}" style="color:black; text-decoration: none;">
                                        {{ $item->product->name }}
                                    </a>
                                </td>
                                <td>{{ $item->total_stock }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
  
</div>




@endsection
