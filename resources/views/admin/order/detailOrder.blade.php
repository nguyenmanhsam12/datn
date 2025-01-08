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

            <a href="{{route('admin.order.index')}}" class="btn btn-secondary mb-3">Danh sách đơn hàng</a>

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
                            <p><strong>Ghi chú:</strong> 
                                @if($order->note)
                                    {{ $order->note }}
                                @else
                                    Không có ghi chú
                                @endif
                            </p>
                            <p><strong>Trạng thái đơn hàng:</strong>
                                @switch($order->orderStatus->name)
                                        @case('Đang chờ xử lý')
                                            <span class="badge badge-warning text-white">
                                                Đang chờ xử lý
                                            </span>
                                        @break

                                        @case('Đã xác nhận')
                                            <span class="badge badge-primary text-white">
                                                Đã xác nhận
                                            </span>
                                        @break

                                        @case('Đang vận chuyển')
                                            <span class="badge badge-primary text-white">
                                                Đang vận chuyển
                                            </span>
                                        @break

                                        @case('Đã giao hàng')
                                            <span class="badge badge-success text-white">
                                                Đã giao hàng
                                            </span>
                                        @break

                                        @case('Hoàn tất')
                                            <span class="badge badge-success text-white">
                                                Hoàn tất
                                            </span>
                                        @break

                                        @case('Đã hủy')
                                            <span class="badge badge-danger text-white">
                                                Đã hủy
                                            </span>
                                        @break

                                        @default
                                            Không rõ trạng thái
                                    @endswitch
                            </p>
                            <p><strong>Trạng thái thanh toán:</strong>
                                
                                    @switch($order->payment_status)
                                        @case('pending')
                                            <span class="badge badge-warning text-white">
                                                Đang chờ thanh toán
                                            </span>
                                        @break

                                        @case('paid')
                                            <span class="badge badge-success text-white">
                                                Đã thanh toán
                                            </span>
                                        @break

                                        @case('canceled')
                                            <span class="badge badge-danger text-white">
                                                Thanh toán bị hủy bỏ
                                            </span>
                                        @break

                                        @case('refund_pending')
                                            <span class="badge badge-warning text-white">
                                                Chờ hoàn tiền
                                            </span>
                                        @break

                                        @case('refund')
                                            <span class="badge badge-success text-white">
                                                Đã hoàn tiền
                                            </span>
                                        @break

                                        @default
                                            Không rõ trạng thái
                                    @endswitch
                                
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
                                {{ number_format($order->shipping_fee, 0, ',', '.') . ' VNĐ' }}
                            </p>
                            @if ($order->discount_amount > 0)
                                <p><strong>Giảm giá:</strong>
                                    {{ number_format($order->discount_amount, 0, ',', '.') . ' VNĐ' }}
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
                                    <td>{{ number_format($sp->price,0,',','.') }} VNĐ</td>
                                    <td>{{ number_format($sp->price * $sp->quantity, 0, ',', '.') . ' VNĐ' }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="3" class="text-right"><strong>Tổng cộng</strong></td>
                                <td><strong>{{ number_format($finalTotal, 0, ',', '.') . ' VNĐ' }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($order->transaction)
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Chi tiết thanh toán</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Mã giao dịch</th>
                                    <th>Trạng thái thanh toán</th>
                                    <th>Ngày thanh toán</th>
                                    <th>Tổng tiền đã thanh toán</th>
                                    <th>Ngân hàng thanh toán</th>
                                    <th>Nội dung thanh toán</th>
                                    <th>Ngày thanh toán</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>
                                        {{ $order->transaction->transaction_id }}
                                    </td>
                                    <td>
                                        @if ($order->transaction->status == 'pending')
                                            Đang chờ thanh toán
                                        @elseif($order->transaction->status == 'success')
                                            Đã thanh toán
                                        @elseif($order->transaction->status == 'canceled')
                                            Thanh toán bị hủy bỏ
                                        @endif
                                    </td>
                                    <td>{{ $order->transaction->payment_date }}</td>
                                    <td>{{ number_format($order->transaction->amount,0,',','.') }} VNĐ</td>
                                    <td>{{ $order->transaction->bank_code }}</td>
                                    <td>{{ $order->transaction->description }}</td>
                                    <td>{{ $order->transaction->created_at }}</td>
                                </tr>



                            </tbody>
                        </table>

                         <!-- Form cập nhật trạng thái thanh toán -->
                         <form action="{{ route('admin.order.updatePaymentStatus',['orderId'=>$order->id]) }}" method="POST" class="col-md-3 mt-3">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="payment_status"><strong>Cập nhật trạng thái thanh toán:</strong></label>
                                <select name="payment_status" id="payment_status" class="form-control">
                                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Đang chờ thanh toán</option>
                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                    <option value="canceled" {{ $order->payment_status == 'canceled' ? 'selected' : '' }}>Thanh toán bị hủy bỏ</option>
                                    <option value="refund_pending" {{ $order->payment_status == 'refund_pending' ? 'selected' : '' }}>Chờ hoàn tiền</option>
                                    <option value="refund" {{ $order->payment_status == 'refund' ? 'selected' : '' }}>Đã hoàn tiền</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật trạng thái thanh toán</button>
                        </form>
                    </div>
                </div>
            @endif
        </section>  
    </div>
@endsection
