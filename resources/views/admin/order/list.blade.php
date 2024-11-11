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
            <table class="table table-bordered mt-4">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Khách Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Hình thức thanh toán</th>
                        <th>Ngày Đặt</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Mẫu đơn hàng -->
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ number_format($order->total_amount, 0, ',', '.') . ' VNĐ' }}</td>
                            <td>{{ $order->payment->name }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                <select class="form-control update-status" data-order-id="{{ $order->id }}">
                                    @foreach ($order_status as $status)
                                        <option value="{{ $status->id }}"
                                            {{ $order->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <a href="{{ route('admin.order.detail', ['id' => $order->id]) }}"
                                    class="btn btn-success btn-sm">Xem Chi Tiết</a>
                                <button class="btn btn-danger btn-sm">Xóa</button>
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
                        if (data.message) {
                            alert(data.message); // Hiển thị thông báo thành công
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