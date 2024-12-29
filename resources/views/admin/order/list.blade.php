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
                        <tr data-order-id="{{ $order->id }}">
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td class="payment_status">
                                @switch($order->payment_status)
                                    @case('pending')
                                        Đang chờ thanh toán
                                    @break

                                    @case('paid')
                                        Đã thanh toán
                                    @break

                                    @case('canceled')
                                        Thanh toán bị hủy bỏ
                                    @break

                                    @case('refund_pending')
                                        Chờ hoàn tiền
                                    @break

                                    @case('refund')
                                        Đã hoàn tiền
                                    @break

                                    @default
                                        Không rõ trạng thái
                                @endswitch
                            </td>
                            <td>{{ number_format($finalTotal, 0, ',', '.') . ' VNĐ' }}</td>
                            <td>{{ $order->payment->name }}</td>
                            {{-- <td>{{ $order->created_at }}</td> --}}
                            <td>
                                <select class="form-control update-status" data-order-id="{{ $order->id }}">
                                    @foreach ($order_status as $status)
                                        <option value="{{ $status->id }}"
                                            {{ $order->status_id == $status->id ? 'selected' : '' }}
                                            {{ $order->status_id > $status->id ? 'disabled' : '' }}>{{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                @can('view', App\Models\Order::class)
                                    <a href="{{ route('admin.order.detail', ['id' => $order->id]) }}"
                                        class="btn btn-success btn-sm">Xem Chi Tiết</a>
                                @endcan
                                {{-- @can('delete', App\Models\Order::class)
                                    <a href="{{ route('admin.order.deleteOrder',['id'=>$order->id]) }}" class="btn btn-danger btn-sm"
                                    onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))"
                                    >Xóa</a>
                                @endcan --}}
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

                let previousSelectedStatus = dropdown.value; // Lưu lại trạng thái đã chọn trước đó


                dropdown.addEventListener('change', function() {
                    const orderId = this.getAttribute('data-order-id');
                    const newStatus = this.value;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

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

                                if (data.message) {
                                    alert(data.message); // Hiển thị thông báo thành công

                                    previousSelectedStatus = newStatus;

                                    dropdown.querySelectorAll('option').forEach(option => {
                                        option.disabled = parseInt(option.value) <
                                            newStatus;
                                    });

                                }
                                if (data.error) {
                                    alert(data.error);
                                    dropdown.value =
                                    previousSelectedStatus; // Quay về trạng thái đã chọn ban đầu
                                }
                            } else {
                                alert('Cập nhật thất bại: ' + result.message); // Thông báo lỗi
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert(
                            'Đã xảy ra lỗi. Vui lòng thử lại sau.'); // Thông báo khi có lỗi
                        });
                });
            });
        });
    </script>

    {{-- dataabel --}}
    <script>
        let table = new DataTable('#list_order', {
            order: [
                [0, 'desc']
            ] // Sắp xếp theo cột đầu tiên (Mã đơn hàng) theo thứ tự giảm dần
        });
    </script>


    <script type="module">
        document.addEventListener('DOMContentLoaded', () => {
            // Lắng nghe sự kiện OrderCanceled
            Echo.private('order-canceled')
                .listen('OrderCanceled', (event) => {

                    console.log(event);

                    // Lấy ID của đơn hàng bị hủy
                    const orderId = event.order.id;
                    const newStatusName = event.order.order_status.name;

                    console.log(newStatusName);
                    

                    // Tìm hàng chứa đơn hàng bị hủy
                    const orderRow = document.querySelector(`tr[data-order-id="${orderId}"]`);

                    if (orderRow) {
                        // Cập nhật trạng thái trong dropdown
                        const statusDropdown = orderRow.querySelector('.update-status');
                        const paymentStatus = orderRow.querySelector('.payment_status');

                        if(paymentStatus){
                            if(event.order.payment_status == 'canceled'){
                                paymentStatus.textContent = 'Thanh toán bị hủy bỏ'
                            }else if(event.order.payment_status == 'refund_pending'){
                                paymentStatus.textContent = 'Chờ hoàn tiền'
                            }                            
                        }

                        if (statusDropdown) {
                            // Tìm và chọn trạng thái mới
                            statusDropdown.querySelectorAll('option').forEach(option => {
                                if (option.textContent.trim() === newStatusName) {
                                    option.selected = true;
                                }
                            });

                            // Vô hiệu hóa các trạng thái trước đó
                            statusDropdown.querySelectorAll('option').forEach(option => {
                                option.disabled = parseInt(option.value) < parseInt(event.order.status_id);
                            });
                        }

                        // Hiển thị thông báo hoặc thay đổi giao diện nếu cần
                        alert(`Đơn hàng ${orderId} đã được hủy bởi khách hàng.`);
                    }

            });

            Echo.private('order-confirm')
                .listen('OrderConfirm', (event) => {

                    console.log(event);

                    // Lấy ID của đơn hàng đã xác nhận đơn hàng
                    const orderId = event.order.id;
                    const newStatusName = event.order.order_status.name;

                    console.log(newStatusName);
                    

                    // Tìm hàng chứa đơn hàng đã xác nhận
                    const orderRow = document.querySelector(`tr[data-order-id="${orderId}"]`);

                    if (orderRow) {
                        // Cập nhật trạng thái trong dropdown
                        const statusDropdown = orderRow.querySelector('.update-status');
                        const paymentStatus = orderRow.querySelector('.payment_status');

                        if(paymentStatus){
                            if(event.order.payment_status == 'paid'){
                                paymentStatus.textContent = 'Đã thanh toán'
                            }                         
                        }

                        if (statusDropdown) {
                            // Tìm và chọn trạng thái mới
                            statusDropdown.querySelectorAll('option').forEach(option => {
                                if (option.textContent.trim() === newStatusName) {
                                    option.selected = true;
                                }
                            });

                            // Vô hiệu hóa các trạng thái trước đó
                            statusDropdown.querySelectorAll('option').forEach(option => {
                                option.disabled = parseInt(option.value) < parseInt(event.order.status_id);
                            });
                        }

                        // Hiển thị thông báo hoặc thay đổi giao diện nếu cần
                        alert(`Đơn hàng ${orderId} đã được xác nhận bởi khách hàng.`);
                    }
            });
        });
    </script>
@endpush
