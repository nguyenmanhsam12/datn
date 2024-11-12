@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thống kê doanh thu</h1>
                    </div>
                </div>
                </div><!-- /.container-fluid -->
                </section>
                   
                <section class="content">
                    
                   
                    {{-- bộ lọc --}}
                    <form action="{{ route('admin.statistical.index') }}" method="get" class="mb-4">
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
                
                           {{-- pttt --}}
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
                
                           {{--  mã giảm giá --}}
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
                    {{-- end lọc --}}
                
                    {{-- kết quả lọc --}}
                    <h3>Thống kê tổng quan</h3>
                    <div class="row">
                        <div class="col-md-3">
                            <h4>Tổng doanh thu</h4>
                            <p>{{ number_format($totalRevenue, 2) }} VND</p>
                        </div>
                        <div class="col-md-3">
                            <h4>Tổng số đơn hàng</h4>
                            <p>{{ $totalOrders }}</p>
                        </div>
                    </div>
                {{-- ..... --}}
                    
                    <h3>Doanh thu theo phương thức thanh toán</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Phương thức thanh toán</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($revenueByPaymentMethod as $paymentMethod)
                                <tr>
                                    <td>{{ $paymentMethod->name }}</td>
                                    <td>{{ number_format($paymentMethod->orders_sum_total_amount, 2) }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                   
                    <h3>Doanh thu theo trạng thái đơn hàng</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Trạng thái</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($revenueByStatus as $status)
                                <tr>
                                    <td>{{ $status->name }}</td>
                                    <td>{{ number_format($status->orders_sum_total_amount, 2) }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                    
                    <h3>Doanh thu theo mã giảm giá</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã giảm giá</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($revenueByCoupon as $coupon)
                                <tr>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ number_format($coupon->orders_sum_total_amount, 2) }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                    
                    <h3>Danh sách đơn hàng</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Tên khách hàng</th>
                                <th>Trạng thái</th>
                                <th>Mã giảm giá</th>
                                <th>Giảm giá</th>
                                <th>Phí vận chuyển</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                    <td>{{ $order->orderStatus ? $order->orderStatus->name : 'N/A' }}</td>
                                    <td>{{ $order->coupon ? $order->coupon->code : 'Không có' }}</td>
                                    <td>{{ number_format($order->discount_amount, 2) }} VND</td>
                                    <td>{{ number_format($order->shipping_fee, 2) }} VND</td>
                                    <td>{{ number_format($order->total_amount, 2) }} VND</td>
                                    <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i:s') : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
                
            
        

        <!-- Main content -->
  
        <!-- /.content -->
    </div>
@endsection
