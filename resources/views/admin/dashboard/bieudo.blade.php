@extends('admin.layout.default')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Biểu đồ</h1>
                    </div>
                </div>
                </div><!-- /.container-fluid -->
                <div class="container">


                    
                    <div class="row">
                        <div class="col-md-3">
                            <p><strong>Tổng số đơn hàng:</strong> {{ $totalOrders }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Tổng số sản phẩm:</strong> {{ $totalProducts }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Tổng số Admins:</strong> {{ $totalAdmins }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Đánh giá</strong></p>
                        </div>
                    </div>



                    {{-- Form lọc lấy raa tổng doanh thu theo tổng đơn hàngg --}}
                    <form id="filterForm" class="mb-4">
                        @csrf
                        <div class="row">
                            {{-- lọc theo ngày --}}
                            <div class="col-md-3">
                                <label for="start_date">Ngày bắt đầu</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date">Ngày kết thúc</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
                            </div>
                    
                            {{-- trạng thái --}}
                            <div class="col-md-3">
                                <label for="status_id">Trạng thái</label>
                                <select name="status_id" id="status_id" class="form-control">
                                    <option value="">Tất cả trạng thái</option>
                                    @foreach ($revenueByStatus as $status)
                                        <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            {{-- phương thức thanh toán --}}
                            <div class="col-md-3">
                                <label for="payment_method_id">Phương thức thanh toán</label>
                                <select name="payment_method_id" id="payment_method_id" class="form-control">
                                    <option value="">Tất cả phương thức</option>
                                    @foreach ($revenueByPaymentMethod as $paymentMethod)
                                        <option value="{{ $paymentMethod->id }}" {{ request('payment_method_id') == $paymentMethod->id ? 'selected' : '' }}>
                                            {{ $paymentMethod->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            {{-- mã giảm giá --}}
                            <div class="col-md-3">
                                <label for="coupon_id">Mã giảm giá</label>
                                <select name="coupon_id" id="coupon_id" class="form-control">
                                    <option value="">Tất cả mã giảm giá</option>
                                    @foreach ($revenueByCoupon as $coupon)
                                        <option value="{{ $coupon->id }}" {{ request('coupon_id') == $coupon->id ? 'selected' : '' }}>
                                            {{ $coupon->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">Lọc</button>
                            </div>
                        </div>
                    </form>
                    
                    {{-- kết quả lọc --}}
                    <div class="row" id="statistics">
                        <div class="col-md-3">
                            <h4>Tổng doanh thu</h4>
                            <p id="totalRevenue">{{ number_format($totalRevenue, 2) }} VND</p>
                        </div>
                        <div class="col-md-3">
                            <h4>Tổng số đơn hàng</h4>
                            <p id="totalOrders">{{ $totalOrders }}</p>
                        </div>
                    </div>      
                            {{--  Sử lý ajacx--}}
                            <script>
                                $(document).ready(function() {
                                $('#filterForm').on('submit', function(e) {
                                    e.preventDefault();  // ngừng load tang
                                    
                                    var formData = $(this).serialize();  // lấy dữ liệu từ form

                                    $.ajax({
                                        url: '{{ route('dashboard') }}',  // địa chỉ URL của route gửi request
                                        method: 'GET',  
                                        data: formData, 
                                        success: function(response) {
                                            // Cập nhật dữ liệu thống kê
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

                    {{-- bieu đồ 1 --}}
                    <h3>Biểu đồ doanh thu theo ngày trong tháng</h3>
                    
                    <!-- Biểu đồ -->
                    <canvas id="revenueChart" width="400" height="200"></canvas>
                    
                    <!-- script cho biểu đồ -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        // lấy dữ liệu từ php và chuyển thành json cho JavaScript
                        var dates = @json($dates);  //  ngày lấy bên kiaod
                        var totals = @json($totals);  // doanh thu
                
                        // Vẽ biểu đồ với Chart.js
                        var ctx = document.getElementById('revenueChart').getContext('2d');
                        var revenueChart = new Chart(ctx, {
                            type: 'line',  // Loại biểu đồ (line chart)
                            data: {
                                labels: dates,  // Các ngày (label)
                                datasets: [{
                                    label: 'Doanh thu (VND)',  // Tiêu đề biểu đồ
                                    data: totals,  // Dữ liệu doanh thu
                                    tension: 0.4, 
                                    borderColor: 'rgba(75, 192, 192, 1)',  // Màu sắc đường biều đồ
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Màu nền (mờ)
                                    fill: true,  // Để lấp đầy dưới đường biểu đồ
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,  // Bắt đầu trục y từ 0
                                        ticks: {
                                            callback: function(value) {
                                                // Định dạng giá trị trục y là VND
                                                return value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                                            }
                                        }
                                    }
                                },
                                responsive: true,  // Biểu đồ sẽ thay đổi kích thước linh hoạt
                            }
                        });
                    </script>
                </div>
                <div class="container">
                    <h3>Biểu đồ trạng thái đơn hàng</h3>
                    
                    <!-- Biểu đồ tròn -->
                    <canvas id="orderStatusChart" width="400" height="200"></canvas>
                    
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        // Lấy dữ liệu từ PHP và chuyển thành JSON cho JavaScript
                        var statuses = @json($statuses);  // Danh sách trạng thái
                        var statusCounts = @json($orderStatusCounts);  // Số lượng đơn hàng theo trạng thái
                
                        // Dữ liệu cho biểu đồ tròn
                        var labels = [];
                        var data = [];
                        
                        // Lấy tên trạng thái và số lượng tương ứng
                        statuses.forEach(function(status) {
                            labels.push(status.name);
                            var statusCount = statusCounts.find(count => count.status_id === status.id);
                            data.push(statusCount ? statusCount.count : 0);
                        });
                
                        // Vẽ biểu đồ tròn với Chart.js
                        var ctx = document.getElementById('orderStatusChart').getContext('2d');
                        var orderStatusChart = new Chart(ctx, {
                            type: 'pie',  // Loại biểu đồ tròn
                            data: {
                                labels: labels,  // Các tên trạng thái
                                datasets: [{
                                    label: 'Trạng thái đơn hàng',
                                    data: data,  // Số lượng đơn hàng theo trạng thái
                                    backgroundColor: [
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 99, 132, 0.2)'
                                    ],  // Màu sắc cho từng phần của biểu đồ
                                    borderColor: [
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 99, 132, 1)'
                                    ],  // Màu sắc viền của từng phần
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,  // Biểu đồ có thể thay đổi kích thước linh hoạt
                                plugins: {
                                    legend: {
                                        position: 'top',  // Vị trí của legend
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                // Tùy chỉnh tooltip để hiển thị số lượng và trạng thái
                                                return tooltipItem.label + ': ' + tooltipItem.raw + ' đơn hàng';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                </div>







                 <!-- Danh sách đơn hàng mới đc mua-->
    <h3>Danh sách đơn hàng mới</h3>
    <table class="table table-bordered">
        <thead>
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

  
    <h3>Top 5 Sản phẩm bán chạy</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng bán</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topProducts as $item)
                <tr>
                    {{-- {{dd($topProducts)
                    }} --}}
                    <td>{{ $item->productVariant->product ? $item->productVariant->product->name : 'N/A' }}</td>
                    <td>{{ $item->total_sold }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    

        <!-- Main content -->
  
        <!-- /.content -->
    </div>
@endsection
