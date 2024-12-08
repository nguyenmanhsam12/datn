@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Quản Lý Đơn Hàng</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Quản Lý Đơn Hàng</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Bảng đơn hàng -->
            <table class="table table-bordered mt-4" id="list_order">
                <thead class="thead-light">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách Hàng</th>
                        <th>Trạng thái thanh toán</th>
                        <th>Tổng Tiền</th>
                        <th>Hình thức thanh toán</th>
                        {{-- <th>Ngày Đặt</th> --}}
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Mẫu đơn hàng -->
                    @foreach ($orders as $key => $order)
                        @php
                            $finalTotal = $order->total_amount + $order->shipping_fee - $order->discount_amount;
                        @endphp
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>
                                @if ($order->payment_status == 'pending')
                                    Chưa thanh toán
                                @elseif($order->payment_status == 'paid')
                                    Đã thanh toán
                                @elseif($order->payment_status == 'failed')
                                    Thanh toán thất bại
                                @elseif($order->payment_status == 'canceled')
                                    Thanh toán bị hủy bỏ
                                @endif
                            </td>
                            <td>{{ number_format($finalTotal, 0, ',', '.') . ' VNĐ' }}</td>
                            <td>{{ $order->payment->name }}</td>
                            {{-- <td>{{ $order->created_at }}</td> --}}
                            <td>
                                <select class="form-control update-status" data-order-id="{{ $order->id }}">
                                    @foreach ($order_status as $status)
                                        <option value="{{ $status->id }}"
                                            {{ $order->status_id == $status->id ? 'selected' : '' }}
                                            {{ $order->status_id > $status->id ? 'disabled' : '' }}
                                            >{{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <a href="{{ route('admin.order.detail', ['id' => $order->id]) }}"
                                    class="btn btn-success btn-sm">Xem Chi Tiết</a>
                                <a href="{{ route('admin.order.deleteOrder',['id'=>$order->id]) }}" class="btn btn-danger btn-sm"
                                onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))"
                                >Xóa</a>
                            </td>
                        </tr>
                    @endforeach

                    <!-- Thêm đơn hàng khác tại đây -->
                </tbody>
            </table>

        </section>
        <!-- /.content -->
    </div>
@endsection


@push('script')

    {{-- cập nhật trạng thái đơn hàng --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const statusDropdowns = document.querySelectorAll('.update-status');

            statusDropdowns.forEach(function(dropdown) {

                let previousSelectedStatus = dropdown.value;  // Lưu lại trạng thái đã chọn trước đó


                dropdown.addEventListener('change', function() {
                    const orderId = this.getAttribute('data-order-id');
                    const newStatus = this.value;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch('{{ route('admin.order.updateStatus') }}', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            status_id: newStatus,
                            orderId: orderId,
                        })
                    })
                    .then(response => response.json()) // Giải mã JSON từ response
                    .then(data => {
                        if (data) {

                            if(data.message){
                                alert(data.message); // Hiển thị thông báo thành công
                                dropdown.querySelectorAll('option').forEach(option => {
                                    option.disabled = parseInt(option.value) < newStatus;
                                });
                            }
                            if(data.error){
                                alert(data.error);
                                dropdown.value = previousSelectedStatus; // Quay về trạng thái đã chọn ban đầu
                            }
                        } else {
                            alert('Cập nhật thất bại: ' + result.message); // Thông báo lỗi
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.'); // Thông báo khi có lỗi
                    });
                });
            });
        });
    </script>
@endpush

@push('script')
    <script>
        let table = new DataTable('#list_order',{
            order: [[0, 'desc']] // Sắp xếp theo cột đầu tiên (Mã đơn hàng) theo thứ tự giảm dần
        });
    </script>
@endpush