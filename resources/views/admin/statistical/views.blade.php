@extends('admin.layout.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold">Thống kê   </h1>
                </div>
            </div>
        </div>
    </section>
                   
    <!-- Main content -->
    <section class="content">
        <!-- Bộ lọc -->
        {{-- <form action="{{ route('admin.statistical.index') }}" method="get" class="mb-4 p-4 shadow-sm rounded bg-light">
            @csrf
            <h5 class="font-weight-bold mb-3">Bộ lọc thống kê</h5>
            <div class="row">
                <!-- Lọc theo ngày -->
                <div class="col-md-4 mb-2">
                    <label for="start_date" class="form-label">Ngày bắt đầu</label>
                    <input type="date" name="start_date"  id="start_date" class="form-control form-control-sm" value="{{ $startDate->format('Y-m-d') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="end_date"class="form-label">Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ $endDate->format('Y-m-d') }}">
                </div>

                <!-- Trạng thái -->
                <div class="col-md-4 mb-2">
                    <label for="status_id"class="form-label">Trạng thái</label>
                    <select name="status_id" id="status_id" class="form-control form-control-sm">
                        <option value="">Tất cả trạng thái</option>
                        @foreach ($revenueByStatus as $status)
                            <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Phương thức thanh toán -->
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
                {{--  mã giảm giá --}}
                            {{-- <div class="col-md-4 mb-2">
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
        </form> --}}
        
        <!-- Kết quả lọc -->
            {{-- <div class="row justify-content-center">
                <!-- Tổng doanh thu -->
                <div class="col-md-4 mb-4">
                    <div class="card text-center border-light shadow-sm p-3" style="border-radius: 20px;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-dollar-sign fa-2x text-primary"></i>
                                <h5 class="card-title ml-3">Tổng doanh thu</h5>
                            </div>
                            <hr>
                            <p class="badge badge-primary badge-pill px-4 py-2 mt-3" style="font-size: 1.5rem;">{{ number_format($totalRevenue, 2) }} VND</p>
                        </div>
                    </div>
                </div>
                <!-- Tổng số đơn hàng -->
                <div class="col-md-4 mb-4">
                    <div class="card text-center border-light shadow-sm p-3" style="border-radius: 20px;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-shopping-cart fa-2x text-success"></i>
                                <h5 class="card-title ml-3">Tổng số đơn hàng</h5>
                            </div>
                            <hr>
                            <p class="badge badge-success badge-pill px-4 py-2 mt-3" style="font-size: 1.5rem;">{{ $totalOrders }}</p>
                        </div>
                    </div>
                </div>
            </div> --}}


        {{-- <!-- Revenue by Payment Method -->
        <h4 class="mt-5 font-weight-bold text-center text-primary">Doanh thu theo phương thức thanh toán</h4>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered mt-3 shadow-sm">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">Phương thức thanh toán</th>
                        <th class="text-center">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($revenueByPaymentMethod as $paymentMethod)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $paymentMethod->name }}</td>
                            <td class="text-center font-weight-bold">
                                {{ number_format($paymentMethod->orders_sum_total_amount, 2) }} VND
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}

        <!-- Revenue by Order Status -->
        <h4 class="mt-5 font-weight-bold text-center text-primary">Doanh thu theo trạng thái đơn hàng</h4>
        <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered mt-3 shadow-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($revenueByStatus as $status)
                    <tr>
                        <td class="text-center font-weight-bold">{{ $status->name }}</td>
                        @php
                            
                        @endphp
                        <td class="text-center font-weight-bold">{{ number_format($status->orders_sum_total_amount, 2) }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <h3 class="mt-5 font-weight-bold text-center text-primary">Doanh thu theo mã giảm giá</h3>
        <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered mt-3 shadow-sm">
            <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center">Mã giảm giá</th>
                                <th class="text-center">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($revenueByCoupon as $coupon)
                                <tr>
                                    <td class="text-center font-weight-bold">{{ $coupon->code }}</td>
                                    <td class="text-center font-weight-bold">{{ number_format($coupon->orders_sum_total_amount, 2) }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
        </div>

        <!-- Order List -->
        <h4 class="mt-5 font-weight-bold text-center text-primary">Danh sách đơn hàng</h4>
        <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered mt-3 shadow-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">Mã đơn hàng</th>
                    <th class="text-center">Tên khách hàng</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Mã giảm giá</th>
                    <th class="text-center">Giảm giá</th>
                    <th class="text-center">Phí vận chuyển</th>
                    <th class="text-center">Tổng tiền</th>
                    <th class="text-center">Ngày đặt hàng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="text-center font-weight-bold">{{ $order->id }}</td>
                        <td class="text-center font-weight-bold">{{ $order->user ? $order->user->name : 'N/A' }}</td>
                        <td class="text-center font-weight-bold">{{ $order->orderStatus ? $order->orderStatus->name : 'N/A' }}</td>
                        <td class="text-center font-weight-bold">{{ $order->coupon ? $order->coupon->code : 'Không có' }}</td>
                        <td class="text-center font-weight-bold">{{ number_format($order->discount_amount, 2) }} VND</td>
                        <td class="text-center font-weight-bold">{{ number_format($order->shipping_fee, 2) }} VND</td>
                        <td class="text-center font-weight-bold">{{ number_format($order->total_amount, 2) }} VND</td>
                        <td class="text-center font-weight-bold">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i:s') : 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    
</div>
@endsection
