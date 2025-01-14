@extends('client.components.default')

@push('styles')
    <style>
        .sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .sidebar a {
            display: block;
            padding: 10px 0;
            color: #333;
            text-decoration: none;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        .sidebar a:hover {
            background-color: #e9ecef;
        }

        .sidebar a.active {
            font-weight: bold;
            color: #E03550;
        }

        .account-info,
        .order-list {
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .order-status {
            font-size: 14px;
            font-weight: bold;
        }

        .order__left img {
            max-width: 150px;
            /* height: 80px; */
            object-fit: cover;
        }

        .order__right {
            text-align: right;
        }

        .tab-links a {
            display: inline-block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .tab-links a.active {
            background-color: #E03550;
            color: white;
        }

        .order-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            max-width: 100%;
        }

        .order__left {
            display: flex;
            align-items: center;
            flex: 2
        }

        .order__left .image {
            margin-right: 10px;
        }

        .order-details p {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
            font-size: 16px;
            line-height: 37px;
        }

        .order__right {
            text-align: right;
        }


        .order-status[data-status="1"] {
            color: #FFC107;
        }

        .order-status[data-status="2"] {
            color: #17A2B8;
        }

        .order-status[data-status="3"] {
            color: #007BFF;
        }

        .order-status[data-status="4"] {
            color: #28A745;
        }

        .order-status[data-status="5"] {
            color: #28A745;
        }

        .order-status[data-status="6"] {
            color: #DC3545;

        }

        .button-group button {
            margin-right: 2px;
            /* Thay đổi giá trị theo ý muốn */
        }
    </style>

    <style>
        .pagination {
            display: flex;
            list-style: none;
            justify-content: center;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 10px 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
            text-decoration: none;
        }

        .pagination li.active span {
            background-color: #E03550;
            color: #fff;
            border: 1px solid #E03550;
        }

        .pagination li a:hover {
            background-color: #e9ecef;
        }
        /* modal */
        .modal-body {
            font-size: 1rem; 
        }
    </style>
@endpush

@section('content')
    <div class="heading-banner-area overlay-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-banner">
                        <div class="heading-banner-title">
                            <h2>Tài Khoản Của Tôi</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                                <li>Tài Khoản Của Tôi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h4 class="mb-4">{{ Auth()->user()->name }}</h4>
                    <div class="sidebar-nav">
                        <a href="#" id="accountLink" class="active">Quản Lý Tài Khoản</a>
                        <a href="#" id="ordersLink">Đơn Mua</a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Account Information Section -->
                <div class="account-info" id="accountInfo">
                    <h5>Thông Tin Tài Khoản</h5>
                    <p>Họ và Tên: <strong>{{ $user->name }}</strong></p>
                    <p>Email: <strong>{{ $user->email }}</strong></p>
                    <p>Số Điện Thoại: <strong>{{ $user->phone_number }}</strong></p>
                    <p>Địa chỉ: <strong>{{ $user->address ?? 'Không có' }},
                            {{ $user->ward->name ?? 'Không có ' }},
                            {{ $user->city->name ?? 'Không có' }},
                            {{ $user->province->name ?? 'Không có' }}
                        </strong></p>
                    <button class="btn btn-primary" id="editButton">Chỉnh Sửa</button>
                </div>

                <!-- Order List Section -->
                <div class="order-list" id="orderList"style="display:none;">
                    <h5>Danh Sách Đơn Mua</h5>

                    <!-- Tab Links for Order Status -->
                    <div class="tab-links">
                        <a href="#" class="tab-link active" data-status="all">Tất Cả</a>
                        @foreach ($status as $st)
                            <a href="#" class="tab-link" data-status="{{ $st->id }}">{{ $st->name }}</a>
                        @endforeach
                    </div>

                    <!-- Order Cards -->
                    <div id="ordersContainer">
                        @if ($order)
                            @foreach ($order as $or)
                                <div class="order-card" data-status="{{ $or->status_id }}"
                                    data-order-id={{ $or->id }}>
                                    <div class="order-header">
                                        <h6 class="order-id">Đơn Hàng #{{ $or->id }}
                                        </h6>

                                        <div>
                                            <p class="order-status" data-status= "{{ $or->status_id }}">
                                                {{ $or->orderStatus->name }}</p>
                                        </div>


                                    </div>
                                    <div>
                                        @foreach ($or->cartItems as $item)
                                            <div class="order-body">
                                                <div class="order__left">
                                                    <div class="image">
                                                        <img src="{{ $item->product_image }}" alt="product image"
                                                            class="img-fluid">
                                                    </div>
                                                    <div class="order-details">
                                                        <p><strong>Sản Phẩm:</strong>{{ $item->product_name }}</p>
                                                        <p><strong>Kích Cỡ:</strong>{{ $item->size }}</p>
                                                        <p><strong>Số Lượng:</strong>{{ $item->quantity }}</p>
                                                    </div>
                                                </div>
                                                <div class="order__right">
                                                    @php
                                                        $newTotal = 0;
                                                        $newTotal =
                                                            $or->total_amount -
                                                            $or->discount_amount +
                                                            $or->shipping_fee;
                                                    @endphp

                                                    


                                                </div>
                                                <!-- Modal cho từng đơn hàng , chi tiết đơn hàng -->
                                                <div class="modal fade" id="orderModal{{ $or->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="orderModalLabel{{ $or->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="orderModalLabel{{ $or->id }}">Chi
                                                                    tiết đơn hàng #{{ $or->id }}</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Sản phẩm</th>
                                                                                <th>Kích cỡ</th>
                                                                                <th>Số lượng</th>
                                                                                <th>Giá tiền</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($or->cartItems as $item)
                                                                                <tr>
                                                                                    <td>{{ $item->product_name }}</td>
                                                                                    <td>{{ $item->size }}</td>
                                                                                    <td>{{ $item->quantity }}</td>
                                                                                    <td>{{ number_format($item->price, 0, ',', '.') . ' VNĐ' }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                
                                                                <p><strong>Giá tiền giảm:</strong> {{ number_format($or->discount_amount, 0, ',', '.') }} VNĐ</p>

                                                                <p><strong>Phí vận chuyển:</strong> {{ number_format($or->shipping_fee, 0, ',', '.') }} VNĐ</p>
                                                            
                                                                <div class="payment-status">
                                                                    <p>Trạng thái thanh toán: 
                                                                        @switch($or->payment_status)
                                                                            @case('pending')
                                                                                <span class="badge bg-warning">Đang chờ thanh toán</span>
                                                                                @break
                                                                            @case('paid')
                                                                                <span class="badge bg-success">Đã thanh toán</span>
                                                                                @break
                                                                            @case('canceled')
                                                                                <span class="badge bg-danger">Thanh toán bị hủy bỏ</span>
                                                                                @break
                                                                            @case('refund_pending')
                                                                                <span class="badge bg-warning">Chờ hoàn tiền</span>
                                                                                @break
                                                                            @case('refund')
                                                                                <span class="badge bg-success">Đã hoàn tiền</span>
                                                                                @break
                                                                            @default
                                                                                <span class="badge bg-secondary">Không rõ trạng thái</span>
                                                                        @endswitch
                                                                    </p>
                                                                </div>
                                                            
                                                                <div class="payment-method">
                                                                    <p>Phương thức thanh toán: <span class="badge bg-secondary">{{ $or->payment->name }}</span></p>
                                                                </div>
                                                            
                                                                <p><strong>Tổng tiền:</strong> {{ number_format($newTotal, 0, ',', '.') }} VNĐ</p>
                                                            
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Tên người nhận</th>
                                                                                <th>Email</th>
                                                                                <th>Địa chỉ</th>
                                                                                <th>Số điện thoại</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>{{ $or->orderAddress->recipient_name }}</td>
                                                                                <td>{{ $or->orderAddress->recipient_email }}</td>
                                                                                <td>{{ $or->orderAddress->address_order }}, {{ $or->orderAddress->ward }}, {{ $or->orderAddress->city }}, {{ $or->orderAddress->province }}</td>
                                                                                <td>{{ $or->orderAddress->phone_number }}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <p class="text-end"><strong>Tổng
                                                Tiền:</strong>{{ number_format($newTotal, 0, ',', '.') . ' VNĐ' }}
                                        </p>
                                        <div class="button-group text-end">

                                            <!-- Nút Hủy cho trạng thái "Chờ xử lý" -->
                                            @if ($or->status_id == 1)
                                                <button
                                                    class="btn btn-danger cancel-order"data-order-id="{{ $or->id }}"
                                                    data-status={{ $or->status_id }}>Hủy</button>
                                                <button class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $or->id }}">Xem Chi
                                                    Tiết</button>
                                                @if ($or->payment_status == 'pending' && $or->payment_method_id == 2)
                                                    <button class="btn btn-secondary retry-payment-btn"
                                                        data-order-id="{{ $or->id }}">Thanh toán lại</button>
                                                @endif

                                                @if ($or->payment_status == 'pending' && $or->payment_method_id == 3)
                                                    <button class="btn btn-secondary retry-payment-btn"
                                                        data-order-id="{{ $or->id }}">Thanh toán lại</button>
                                                @endif
                                            @endif

                                            @if ($or->status_id == 2)
                                                <button
                                                    class="btn btn-danger cancel-order"data-order-id="{{ $or->id }}"
                                                    data-status={{ $or->status_id }}>Hủy</button>
                                                <button class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $or->id }}">Xem Chi
                                                    Tiết</button>
                                            @endif

                                            @if ($or->status_id == 3)
                                                <button class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $or->id }}">Xem Chi
                                                    Tiết</button>
                                            @endif


                                            <!-- Nút xác nhận đơn hàng cho trạng thái "Đã giao" -->
                                            @if ($or->status_id == 4)
                                                <button class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $or->id }}">Xem Chi
                                                    Tiết</button>
                                                @if ($or->complaint)
                                                    <a class="btn btn-warning"
                                                        href="{{ route('complaintsDetail', ['orderId' => $or->id]) }}">Xem
                                                        khiếu nại</a>
                                                @else
                                                    <a class="btn btn-warning"
                                                        href="{{ route('complaints', ['orderId' => $or->id]) }}">Khiếu
                                                        Nại</a>
                                                @endif
                                                <button class="btn btn-primary confirm-order"
                                                    data-order-id="{{ $or->id }}"
                                                    data-status={{ $or->status_id }}>Xác nhận đơn hàng</button>
                                            @endif

                                            <!-- Nút Khiếu nại cho trạng thái "Hoàn tất" -->
                                            @if ($or->status_id == 5)
                                                <button class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $or->id }}">Xem Chi
                                                    Tiết</button>
                                            @endif

                                            @if ($or->status_id == 6)
                                                <button class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $or->id }}">Xem Chi
                                                    Tiết</button>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        // xử lí khi chọn quản lí tài khoản hoặc đơn mua
        document.getElementById('accountLink').addEventListener('click', function() {
            document.getElementById('accountInfo').style.display = 'block';
            document.getElementById('orderList').style.display = 'none';
            document.getElementById('accountLink').classList.add('active');
            document.getElementById('ordersLink').classList.remove('active');
        });

        document.getElementById('ordersLink').addEventListener('click', function() {
            document.getElementById('accountInfo').style.display = 'none';
            document.getElementById('orderList').style.display = 'block';
            document.getElementById('ordersLink').classList.add('active');
            document.getElementById('accountLink').classList.remove('active');
        });

        // các tab trạng thái đơn hàng : code cũ
        document.querySelectorAll('.tab-link').forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.tab-link').forEach(function(t) {
                    t.classList.remove('active');
                });
                tab.classList.add('active');

                const status = tab.getAttribute('data-status'); // id của trạng thái
                const orders = document.querySelectorAll('.order-card');
                orders.forEach(function(order) {
                    if (status === 'all' || order.getAttribute('data-status') === status) {
                        order.style.display = 'block';
                    } else {
                        order.style.display = 'none';
                    }
                });
            });
        });

        // nút xác nhận đơn hàng  
        window.confirmOrder = function(){
            document.querySelectorAll('.confirm-order').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Lấy ID đơn hàng và trạng thái hiện tại
                    const orderId = this.getAttribute('data-order-id');
                    const currentStatus = this.getAttribute('data-status');

                    // Sử dụng SweetAlert để hỏi người dùng xác nhận
                    Swal.fire({
                        title: 'Xác nhận xác nhận đơn hàng',
                        text: "Bạn có chắc chắn muốn xác nhận đơn hàng này?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy bỏ',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Nếu người dùng chọn xác nhận, tiến hành gửi yêu cầu
                            const dataToSend = {
                                orderId: orderId,
                                currentStatus: currentStatus
                            };

                            // Gửi yêu cầu POST
                            fetch('{{ route('confirmOrder') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')
                                            .getAttribute('content'),
                                    },
                                    body: JSON.stringify(dataToSend)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        // Cập nhật giao diện khi xác nhận thành công
                                        const orderCard = this.closest('.order-card');
                                        orderCard.setAttribute('data-status', data.newStatus);

                                        const orderStatus = orderCard.querySelector(
                                        '.order-status');

                                        orderStatus.textContent = data.statusName;
                                        orderStatus.setAttribute('data-status', data.newStatus);

                                        const paymentStatus = orderCard.querySelector(
                                            '.payment-status span');
                                        if (data.newpaymentStatus == 'paid') {
                                            paymentStatus.classList.remove('bg-warning')
                                            paymentStatus.classList.add('bg-success')
                                            paymentStatus.textContent = 'Đã thanh toán'
                                        }

                                        // Ẩn hoặc thay đổi các nút sau khi đơn hàng đã hoàn tất
                                        const confirmButton = orderCard.querySelector(
                                            '.confirm-order');
                                        if (confirmButton) {
                                            confirmButton.style.display = 'none';
                                        }

                                        const complaintButton = orderCard.querySelector(
                                            'a.btn-warning');
                                        if (complaintButton) {
                                            complaintButton.style.display = 'none';
                                        }

                                        // Chuyển đơn hàng sang tab "Hoàn tất" nếu trạng thái mới là hoàn tất
                                        if (data.newStatus === 5) {
                                            const completedTab = document.querySelector(
                                                `.tab-link[data-status="${data.newStatus}"]`);
                                            if (completedTab) {
                                                document.querySelectorAll('.tab-link').forEach(
                                                    function(tab) {
                                                        tab.classList.remove('active');
                                                    });
                                                completedTab.classList.add('active');
                                                const orders = document.querySelectorAll(
                                                    '.order-card');
                                                orders.forEach(function(order) {
                                                    if (order.getAttribute(
                                                        'data-status') === '5') {
                                                        order.style.display = 'block';
                                                    } else {
                                                        order.style.display = 'none';
                                                    }
                                                });
                                            }
                                        }

                                        // Hiển thị thông báo SweetAlert
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Thành công',
                                            text: 'Đơn hàng đã được xác nhận và chuyển sang trạng thái hoàn tất!',
                                            confirmButtonText: 'OK'
                                        });
                                        
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Lỗi',
                                            text: data.error,
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Có lỗi xảy ra trong quá trình xác nhận');
                                });
                        } else {
                            // Người dùng hủy bỏ, có thể thêm một thông báo nếu muốn
                            Swal.fire('Hành động đã bị hủy bỏ', '', 'info');
                        }
                    });
                });
            });
        }
        confirmOrder();
        // nút hủy bỏ đơn hàng
        window.cancelOrder = function(){
            document.querySelectorAll('.cancel-order').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const orderId = this.getAttribute('data-order-id');
                    // trạng thái hiện tại
                    const currentStatus = this.getAttribute('data-status');

                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn hủy đơn hàng?',
                        text: "Hành động này không thể hoàn tác!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Hủy đơn hàng',
                        cancelButtonText: 'Không'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Gửi yêu cầu hủy đơn hàng
                            fetch('{{ route('cancelOrder') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute('content'),
                                    },
                                    body: JSON.stringify({
                                        orderId: orderId,
                                        currentStatus: currentStatus,
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {

                                        Swal.fire(
                                            'Đã hủy!',
                                            'Đơn hàng của bạn đã được hủy thành công.',
                                            'success'
                                        );

                                        // cập nhập trạng thái thanh toán trên nút modal
                                        const paymentStatusElement = document.querySelector(
                                            `#orderModal${orderId} .payment-status span`);
                                        if (paymentStatusElement) {
                                            if (data.newPaymentStatus === 'canceled') {
                                                paymentStatusElement.className = 'badge bg-danger';
                                                paymentStatusElement.textContent = 'Thanh toán bị hủy bỏ';
                                            } else if (data.newPaymentStatus === 'refund_pending') {
                                                paymentStatusElement.className = 'badge bg-warning';
                                                paymentStatusElement.textContent = 'Chờ hoàn tiền';
                                            }
                                        }


                                        // Cập nhật giao diện khi xác nhận thành công
                                        const orderCard = this.closest('.order-card');
                                        orderCard.setAttribute('data-status', data.newStatus);

                                        // tên trạng thái
                                        const orderStatus = orderCard.querySelector(
                                            '.order-status');
                                        // Cập nhật trạng thái hiển thị trong giao diện
                                        orderStatus.textContent = data.statusName;
                                        orderStatus.setAttribute('data-status', data
                                            .newStatus); // Cập nhật mã trạng thái từ server



                                        // Chuyển đơn hàng sang tab "Hoàn tất" nếu trạng thái mới là hoàn tất
                                        if (data.newStatus === 6) {

                                            const button = this; // Lấy chính nút đang được click
                                            button.style.display = 'none';

                                            // Tìm tab "Hoàn tất" và chuyển đến đó
                                            const completedTab = document.querySelector(
                                                `.tab-link[data-status="${data.newStatus}"]`);
                                            if (completedTab) {
                                                // Chuyển sang tab "Hoàn tất"
                                                document.querySelectorAll('.tab-link').forEach(
                                                    function(tab) {
                                                        tab.classList.remove('active');
                                                    });
                                                completedTab.classList.add('active');

                                                // Ẩn/hiện các đơn hàng theo trạng thái
                                                const orders = document.querySelectorAll(
                                                    '.order-card');


                                                orders.forEach(function(order) {
                                                    if (order.getAttribute(
                                                            'data-status') === '6') {
                                                        order.style.display = 'block';
                                                        document.querySelectorAll(
                                                                '.retry-payment-btn')
                                                            .forEach(
                                                                function(bt) {
                                                                    bt.style.display =
                                                                        'none';
                                                                }
                                                            )
                                                    } else {
                                                        order.style.display = 'none';
                                                    }
                                                });
                                            }
                                        }
                                    } else {
                                        Swal.fire(
                                            'Lỗi!',
                                            'Có lỗi xảy ra khi hủy đơn hàng.',
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire(
                                        'Lỗi!',
                                        'Không thể kết nối đến máy chủ.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });
        }
        cancelOrder();

        // nút thanh toán lại
        document.addEventListener("DOMContentLoaded", () => {
            const retryButtons = document.querySelectorAll(".retry-payment-btn");

            retryButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const orderId = this.getAttribute('data-order-id');


                    fetch('{{ route('retryPayment') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                order_id: orderId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.vnpay) {
                                // Điều hướng đến URL thanh toán VNPAY
                                window.location.href = data.vnpay;
                            } else if (data.momo) {
                                // Điều hướng đến URL thanh toán VNPAY
                                window.location.href = data.momo;
                            } else {
                                alert(data.message || "Đã xảy ra lỗi, vui lòng thử lại.");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Không thể thực hiện thanh toán lại, vui lòng thử lại.");
                        });
                });
            });
        });


        // Lắng nghe sự kiện từ Laravel Echo
        const orderElement = document.querySelectorAll('.order-card')
        orderElement.forEach(order => {
            const orderId = order.getAttribute('data-order-id'); // lấy ra id của từng đơn hàng
            Echo.private(`order.${orderId}`)
                .listen('OrderStatusUpdatedEvent', (e) => {
                    console.log(e); // Kiểm tra dữ liệu sự kiện nhận được

                    // Lấy thông tin từ sự kiện
                    const orderId = e.order.id;
                    const newStatus = e.order.order_status.name;
                    const newStatusId = e.order.status_id;
                    const newPaymentStatus = e.order.payment_status; //Trạng thái thanh toán



                    const complaintsRoute = "{{ route('complaints', ['orderId' => ':orderId']) }}";

                    // Tìm đơn hàng trong DOM theo `data-order-id`
                    const orderElement = document.querySelector(`.order-card[data-order-id="${orderId}"]`);

                    if (orderElement) {
                        // Cập nhật tên trạng thái đơn hàng
                        const statusElement = orderElement.querySelector('.order-status');

                        statusElement.textContent = newStatus;
                        statusElement.setAttribute('data-status', newStatusId); // Cập nhật data-status


                        // Cập nhật `data-status` với trạng thái mới
                        orderElement.setAttribute('data-status', newStatusId);

                        // Hiển thị và ẩn các nút button theo `newStatusId`
                        const buttonGroup = orderElement.querySelector('.button-group');
                        buttonGroup.innerHTML = ''; // Xóa các nút hiện có

                        const paymentStatusElement = orderElement.querySelector('.payment-status span');
                        if (newPaymentStatus == 'pending') {
                            paymentStatusElement.textContent = 'Đang chờ thanh toán';
                        }

                        if (newPaymentStatus == 'paid') {
                            paymentStatusElement.textContent = 'Đã thanh toán';
                        }

                        if (newPaymentStatus == 'canceled') {
                            paymentStatusElement.textContent = 'Thanh toán bị hủy bỏ';
                        }


                        // thế router
                        const dynamicComplaintUrl = complaintsRoute.replace(':orderId', orderId);


                        // Thêm nút dựa vào trạng thái mới
                        if (newStatusId === 2) {
                            buttonGroup.innerHTML =
                                `<button
                                class="btn btn-danger cancel-order"data-order-id="${orderId}"
                                data-status="${e.order.status_id}">Hủy</button>
                                <button class="btn btn-success"
                                data-bs-toggle="modal" data-bs-target="#orderModal${orderId}"
                                >Xem chi tiết</button>`;
                        } else if (newStatusId === 3) {
                            buttonGroup.innerHTML = `<button class="btn btn-success"
                            data-bs-toggle="modal" data-bs-target="#orderModal${orderId}"
                            >Xem chi tiết</button>`;
                        } else if (newStatusId === 4) {
                            buttonGroup.innerHTML =
                                `<button class="btn btn-success"
                                data-bs-toggle="modal" data-bs-target="#orderModal${orderId}"
                                >Xem chi tiết</button>
                                <a class="btn btn-warning" href="${dynamicComplaintUrl}">Khiếu Nại</a>
                                <button class="btn btn-primary confirm-order"
                                data-order-id=${orderId}
                                data-status=${newStatusId}>Xác nhận đơn hàng</button>
                                `;
                        } else if (newStatusId === 5) {
                            buttonGroup.innerHTML =
                                `<button class="btn btn-success"
                                data-bs-toggle="modal" data-bs-target="#orderModal${orderId}"
                                >Xem chi tiết</button>
                                
                                `;
                        } else if (newStatusId === 6) {
                            buttonGroup.innerHTML = `<button class="btn btn-success"
                            data-bs-toggle="modal" data-bs-target="#orderModal${orderId}"
                            >Xem chi tiết</button>`;
                        }

                        // Gắn lại sự kiện click cho nút 'Xác nhận đơn hàng'
                        confirmOrder();
                        cancelOrder();

                        
                        // Lọc và hiển thị đơn hàng theo tab trạng thái hiện tại
                        const activeStatus = document.querySelector('.tab-link.active').getAttribute(
                            'data-status');
                        if (activeStatus !== 'all' && activeStatus !== newStatusId.toString()) {
                            orderElement.style.display = 'none';
                        } else {
                            orderElement.style.display = 'block';
                        }
                    }
                });

        })

    </script>

   

    <script>
        // đoạn code xử lí thông tin người dùng
        document.getElementById('editButton').addEventListener('click', function() {
            const accountInfo = document.getElementById('accountInfo');


            // Tạo HTML của form
            const formHTML = `
                <h5>Chỉnh sửa Thông Tin Tài Khoản</h5>
                <form id="editForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và Tên:</label>
                        <input type="text" class="form-control" id="name" value="{{ $user->name }}">
                        <div id="recipient_name_error" class="text-danger mb-3 error-message" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" value="{{ $user->email }}">
                        <div id="recipient_email_error" class="text-danger mb-3 error-message" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số Điện Thoại:</label>
                        <input type="text" class="form-control" id="phone_number" value="{{ $user->phone_number }}">
                        <div id="recipient_phone_number_error" class="text-danger mb-3 error-message" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Tỉnh/Thành phố</label>
                        <select class="form-control province choose" name="province" id="province_id">
                            <option value = "">Tỉnh / Thành phố</option>
                            @foreach ($list_provice as $province)
                                <option value="{{ $province->matinh }}"
                                    {{ $user->province_id == $province->matinh ? 'selected' : '' }}    
                                >{{ $province->name }}</option>
                            @endforeach
                        </select>
                        <div id="recipient_province_id_error" class="text-danger mb-3 error-message" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Quận/huyện</label>
                        <select class="form-control" name="city" id="city_id">
                            <option value = "">Quận/huyện</option>                                               
                        </select>
                        <div id="recipient_city_id_error" class="text-danger mb-3 error-message" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Xã/Phường</label>
                        <select class="form-control" name="ward" id="ward_id">
                            <option value = "">Xã/Phường</option>                                               
                        </select>
                        <div id="recipient_ward_id_error" class="text-danger mb-3 error-message" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Địa chỉ</label>
                        <textarea class="form-control" name="address" id="address" placeholder="Địa chỉ của bạn...">{{ $user->address }}</textarea>
                        <div id="recipient_address_error" class="text-danger mb-3 error-message" style="display: none;"></div>
                    </div>
                    <button type="button" class="btn btn-success" id="saveButton">Lưu thay đổi</button>
                    <button type="button" class="btn btn-secondary" id="cancelButton">Hủy</button>
                </form>
            `;

            // Chèn form vào nội dung của accountInfo
            accountInfo.innerHTML = formHTML;

            const provinceSelect = document.getElementById('province_id');
            const citySelect = document.getElementById('city_id');
            const wardSelect = document.getElementById('ward_id');

            let provinceOld = {!! json_encode($user->province_id ?? null) !!};
            let cityIdOld = {!! json_encode($user->city_id ?? null) !!};
            let wardIdOld = {!! json_encode($user->ward_id ?? null) !!};

            // load dữ liệu nếu như tỉnh , thành phố , phường đã lưu
            if (provinceOld) {
                fetchCities(provinceOld, cityIdOld);
            }

            // Gọi API lấy danh sách ward nếu có city_id
            if (cityIdOld) {
                fetchWards(cityIdOld, wardIdOld);
            }


            // Khi người dùng chọn tỉnh/thành phố
            provinceSelect.addEventListener('change', function() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const selectedProvince = this.value;


                // Xóa tất cả tùy chọn trong citySelect và wardSelect
                citySelect.innerHTML = '<option value = "" >Quận / Huyện</option>';
                wardSelect.innerHTML = '<option value = "" >Xã / Phường</option>';

                if (selectedProvince) {
                    fetchCities(selectedProvince);
                }


            });


            // Khi người dùng chọn thành phố
            citySelect.addEventListener('change', function() {
                const selectedCity = this.value // Lấy tùy chọn đã chọn


                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                // Xóa tất cả tùy chọn trong wardSelect
                wardSelect.innerHTML = '<option value="">Xã / Phường</option>'; // Đặt lại tùy chọn phường

                if (selectedCity) {
                    fetchWards(selectedCity);
                }
            });

            // Hàm fetch danh sách city theo province_id
            function fetchCities(provinceId, selectedCityId = '') {
                fetch('{{ route('selectProvince') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            province: provinceId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        data.citys.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.macity;
                            option.textContent = city.name;
                            if (selectedCityId && city.macity === selectedCityId) {
                                option.selected = true;
                            }
                            citySelect.appendChild(option);
                        });
                    });
            }

            // Hàm fetch danh sách ward theo city_id
            function fetchWards(cityId, selectedWardId = '') {
                fetch('{{ route('selectCity') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            city: cityId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        data.wards.forEach(ward => {
                            const option = document.createElement('option');
                            option.value = ward.phuongid;
                            option.textContent = ward.name;
                            if (selectedWardId && ward.phuongid === selectedWardId) {
                                option.selected = true;
                            }
                            wardSelect.appendChild(option);
                        });
                    });
            }

            // Xử lý sự kiện nút Lưu
            document.getElementById('saveButton').addEventListener('click', function() {

                const errorMessages = document.querySelectorAll('.error-message');
                errorMessages.forEach((message) => message.style.display = 'none');

                let newName = document.getElementById('name').value;
                let newEmail = document.getElementById('email').value;
                let newPhone = document.getElementById('phone_number').value;
                let newProvince = document.getElementById('province_id').value;
                let newCity = document.getElementById('city_id').value;
                let newWard = document.getElementById('ward_id').value;
                let newAddress = document.getElementById('address').value;
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Gửi dữ liệu đến server
                fetch('{{ route('updateProfile') }}', {
                        method: 'POST', // Hoặc PUT tùy theo RESTful API
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json', // Thêm dòng này
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            name: newName,
                            email: newEmail,
                            phone_number: newPhone,
                            province_id: newProvince,
                            city_id: newCity,
                            ward_id: newWard,
                            address: newAddress
                        })
                    })
                    .then(response => response.json())
                    .then(data => {



                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: 'Cập nhập thông tin thành công',
                                confirmButtonText: 'OK'
                            });
                            // location.reload(); 
                        } else if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                console.log(field);
                                const errorElement = document.getElementById(
                                    `recipient_${field}_error`);
                                if (errorElement) {
                                    errorElement.innerText = data.errors[field][0];
                                    errorElement.style.display = 'block';
                                } else {
                                    errorElement.style.display = 'none';
                                }
                            });
                            Swal.fire({
                                title: 'Cập nhập thất bại',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi cập nhật thông tin:', error);
                        alert('Đã xảy ra lỗi, vui lòng thử lại!');
                    });
            });

            // Xử lý sự kiện nút Hủy
            document.getElementById('cancelButton').addEventListener('click', function() {
                location.reload(); // Hoặc khôi phục lại nội dung ban đầu
            });

            // đoạn code xử lí khi chọn thì tắt lỗi
            document.querySelectorAll('input, select, textarea').forEach((input) => {
                input.addEventListener('input', function() {
                    const errorElement = document.getElementById(`recipient_${input.id}_error`);
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
