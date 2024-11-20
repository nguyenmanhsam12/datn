@extends('admin.layout.default')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 style="font-weight: bold;">Biểu đồ</h1>
                </div>
            </div>
        </div>

    <div class="container">
        <div class="row">
        <!-- Total Orders -->
            <div class="col-md-3">
                <div class="card text-center" style="background-color: #4db6ac; color: white;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-shopping-cart"></i> Tổng số đơn hàng
                        </h5>
                        <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

        <!-- Total Products -->
        <div class="col-md-3">
            <div class="card text-center" style="background-color: #f06292; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-box"></i>Số sản phẩm
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $totalProducts }}</p>
                </div>
            </div>
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
            <div class="card text-center" style="background-color: #64b5f6; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-shield"></i> Quản trị viên
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $totalAdmins }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="background-color: #64b5f6; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-shield"></i> Số danh mục
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="background-color: #64b5f6; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-shield"></i> Mã giảm giá còn hạn
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $expiredCouponsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="background-color: #64b5f6; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-shield"></i> Mã giảm giá hết hạn
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $activeCouponsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="background-color: #64b5f6; color: white;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-shield"></i> Đánh giá
                    </h5>
                    <p class="card-text" style="font-size: 24px; font-weight: bold;">{{ $activeCouponsCount }}</p>
                </div>
            </div>
        </div>

     
    </div>
</div>
        <!-- Form lọc -->
    <form id="filterForm" class="mb-4 p-4 shadow-sm rounded bg-light">
        @csrf
            <div class="row">
                <!-- First Row -->
                <div class="col-md-4 mb-2">
                    <label for="start_date" class="form-label">Ngày bắt đầu</label>
                    <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ $startDate->format('Y-m-d') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="end_date" class="form-label">Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ $endDate->format('Y-m-d') }}">
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
                        <button type="submit" class="btn btn-primary w-100">Lọc</button>
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
    </div>

            {{-- Xử lý ajax --}}
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
            </script>

            <!-- Biểu đồ (Chart Containers) -->
            <div class="row">
                <div class="col-md-7" >
                    <!-- Biểu đồ doanh thu -->
                    <div class="card p-4 border" style="height: 450px;">
                        <h3 class="text-center">Biểu đồ doanh thu theo ngày trong tháng</h3>
                        <canvas id="revenueChart" width="650" height="350"></canvas>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-center">
                        <!-- Biểu đồ trạng thái đơn hàng -->
                    <div class="card p-4 border" style="height: 450px; width: 100%;">
                        <h3 class="text-center">Biểu đồ trạng thái đơn hàng</h3>
                        <div class="chart-container d-flex justify-content-center" style="width: 100%; height: 100%; overflow: hidden;">
                            <canvas id="orderStatusChart" width="700" height="600" style="max-width: 100%; max-height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Biểu đồ tồn kho -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card p-4 border" style="height: 450px;">
            <h3 class="text-center">Biểu đồ tồn kho theo sản phẩm biến thể</h3>
            <canvas id="inventoryChart" width="650" height="350"></canvas>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card p-4 border" style="height: 450px;">
            <h3 class="text-center">Doanh thu sản phẩm</h3>
            <canvas id="huhu" width="650" height="350"></canvas>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card p-4 border" style="height: 450px;">
            <h3 class="text-center">Doanh thu sản phẩm theo các tỉnh</h3>
            <canvas id="revenueSalesChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>


            </div>

            {{-- Script for charts --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Revenue Chart Data
                var dates = @json($dates);
                var totals = @json($totals);

                var ctx = document.getElementById('revenueChart').getContext('2d');
                var revenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Doanh thu (VND)',
                            data: totals,
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

                // Order Status Chart Data
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




//bieu do
                var productNames = @json($inventoryData->pluck('product_name'));

// Cắt ngắn tên sản phẩm nếu tên quá dài (Ví dụ cắt dài hơn 20 ký tự)
// productNames = productNames.map(function(name) {
//     return name.length > 20 ? name.substring(0, 0) + '...' : name;
// });
    var stockQuantities = @json($inventoryData->pluck('stock'));

    var ctx = document.getElementById('inventoryChart').getContext('2d');
    var inventoryChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: productNames,  // Tên sản phẩm
            datasets: [{
                label: 'Số lượng tồn kho',
                data: stockQuantities,  // Số lượng tồn kho
                backgroundColor: [
                // 'rgba(75, 192, 192, 0.5)',  // Màu cột đầu tiên
                'rgba(255 106 106)',  // Màu cột thứ hai
                'rgba(153, 190, 255, 0.5)',  // Màu cột thứ ba
                // 'rgba(255, 159, 64, 0.5)',   // Màu cột thứ tư
                // Thêm màu cho các cột tiếp theo nếu cần
            ],
            
                borderColor: 'rgba(255 255 0)',  // Màu viền
                borderWidth: 2,
                pointBackgroundColor: 'rgba(255 106 106)',  // Màu nền của dấu chấm
            pointRadius: 4,  // Kích thước của dấu chấm
            pointBorderWidth: 3,  // Độ dày viền của dấu chấm
            }],
        },
        
        options: {
            responsive: true,
            scales: {
                x: {
                display: false,  // Ẩn trục X (không hiển thị tên sản phẩm)
            },
                
                y: {
                    beginAtZero: true
                }
            }
        }
    });

//bieu do
 // Dữ liệu từ controller
 var productNames = @json($productNames);  // Tên sản phẩm
    var quantities = @json($quantities);      // Số lượng sản phẩm đã bán
    var revenues = @json($revenues);          // Doanh thu từ sản phẩm

    var ctx = document.getElementById('huhu').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'bar', // Biểu đồ cột
        data: {
            labels: productNames, // Tên sản phẩm
            datasets: [{
                label: 'Số lượng đã bán',
                data: quantities, // Số lượng sản phẩm bán được
                backgroundColor: 'rgba(75, 192, 192, 0.6)',  // Màu sắc cột Số lượng đã bán
                borderColor: 'rgba(75, 192, 192, 1)',        // Màu viền cột Số lượng đã bán
                borderWidth: 1
            }, {
                label: 'Doanh thu (VND)', 
                data: revenues,   // Doanh thu từ các sản phẩm
                backgroundColor: 'rgba(255, 159, 64, 0.6)',  // Màu sắc cột Doanh thu
                borderColor: 'rgba(255, 159, 64, 1)',        // Màu viền cột Doanh thu
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                display: false,  // Ẩn trục X (không hiển thị tên sản phẩm)
            },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            // Định dạng số liệu theo kiểu VND
                            return value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                        }
                    }
                }
            }
        }
    });



    //tỉnh
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
                                    <td>{{ $item->productVariant->product ? $item->productVariant->product->name : 'N/A' }}</td>
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
           
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #4caf50; color: white;">
                            <tr>
                                <th>Tên sản phẩm</th>
                      

                                <th>Tồn kho</th>
                           
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sanPham as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->total_stock }}</td> <!-- Hiển thị tổng tồn kho -->
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
