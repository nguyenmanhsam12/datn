@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="mb-4">Chi tiết Đơn hàng # {{ $order->id }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chi Tiết Đơn Hàng</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Thông tin Đơn hàng</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã Đơn hàng:</strong> #{{ $order->id }}</p>
                            <p><strong>Ngày Đặt hàng:</strong> {{ $order->created_at }}</p>
                            <p><strong>Hình Thức Thanh Toán:</strong> {{ $order->payment->name }}</p>
                            <p><strong>Trạng thái đơn hàng:</strong>
                                <span class="badge badge-warning text-white">{{ $order->orderStatus->name }}</span>
                            </p>
                            <p><strong>Trạng thái thanh toán:</strong>
                                <span class="badge badge-warning text-white">
                                    @if ($order->payment_status == 'pending')
                                    Chưa thanh toán
                                    @elseif($order->payment_status == 'paid')
                                        Đã thanh toán
                                    @elseif($order->payment_status == 'failed')
                                        Thanh toán thất bại
                                    @elseif($order->payment_status == 'canceled')
                                        Thanh toán bị hủy bỏ
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tên Người Nhận:</strong>{{ $order->orderAddress->recipient_name }}</p>
                            <p><strong>Email:</strong>{{ $order->orderAddress->recipient_email }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $order->orderAddress->phone_number }}</p>
                            <p><strong>Địa Chỉ:</strong> 
                                {{ $order->orderAddress->address_order }},
                                {{ $order->orderAddress->ward }},
                                {{ $order->orderAddress->city }},
                                {{ $order->orderAddress->province }}
                            </p>
                            <p><strong>Phí ship:</strong> 
                                {{ number_format($order->shipping_fee,0,',','.').' VNĐ' }}
                            </p>
                            @if ($order->discount_amount > 0)
                                <p><strong>Giảm giá:</strong> 
                                    {{ number_format($order->discount_amount,0,',','.').' VNĐ' }}
                                </p>
                            @endif
                        
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách sản phẩm trong đơn hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Thông tin sản phẩm đã đặt</strong>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->cartItems as $key => $sp)  
                                <tr>
                                    <td>
                                        <img src="{{ $sp->product_image }}" alt="" width="100"height="100">
                                    </td>
                                    <td>{{ $sp->product_name }}</td>
                                    <td>{{ $sp->quantity }}</td>
                                    <td>{{ $sp->price }}</td>
                                    <td>{{ number_format($sp->price * $sp->quantity,0,',','.').' VNĐ' }}</td>
                                </tr>
                            @endforeach
                        
                            <tr>
                                <td colspan="3" class="text-right"><strong>Tổng cộng</strong></td>
                                <td><strong>{{ number_format($finalTotal,0,',','.').' VNĐ' }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cập nhật trạng thái đơn hàng -->
            {{-- <div class="card mb-4">
                <div class="card-header">
                    <strong>Cập nhật Trạng thái Đơn hàng</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.order.updateOrder') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="orderStatus">Trạng thái</label>
                            <input type="hidden" name="orderId" value="{{ $order->id }}" />
                            <select id="orderStatus" class="form-control" name="status_id">
                                @foreach ($order_status as $status)
                                        <option value="{{ $status->id }}" {{ $order->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>                                        
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div> --}}
        </section>
    </div>
@endsection
