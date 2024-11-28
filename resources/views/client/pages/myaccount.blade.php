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
            width: 80px;
            height: 80px;
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
        }

        .order__left {
            display: flex;
            align-items: center;
            flex : 2
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
            font-size: 14px;
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
                                <li><a href="">Trang Chủ</a></li>
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
                    <button class="btn btn-primary">Chỉnh Sửa</button>
                </div>

                <!-- Order List Section -->
                <div class="order-list" id="orderList" style="display: none;">
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
                        @foreach ($order as $or)
                            <div class="order-card" data-status="{{ $or->status_id }}" data-order-id={{ $or->id }}>
                                <div class="order-header">
                                    <h6 class="order-id">Đơn Hàng #{{ $or->id }}
                                    </h6>
                                    
                                    <div>
                                            <p class="order-status" data-status= "{{ $or->status_id }}">
                                            {{ $or->orderStatus->name }}</p>    
                                    </div>
                                    
                                        
                                </div>
                                <div class="order-body">
                                    @foreach ($or->cartItems as $item)
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
                                                    $or->total_amount - $or->discount_amount + $or->shipping_fee;
                                            @endphp
                                            <p><strong>Tổng
                                                    Tiền:</strong>{{ number_format($newTotal, 0, ',', '.') . ' VNĐ' }}
                                            </p>
                                            <div class="button-group">

                                                <!-- Nút Hủy cho trạng thái "Chờ xử lý" -->
                                                @if ($or->status_id == 1)
                                                    <button
                                                        class="btn btn-danger cancel-order"data-order-id="{{ $or->id }}"
                                                        data-status={{ $or->status_id }}>Hủy</button>
                                                    <button class="btn btn-success" 
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#orderModal{{ $or->id }}">Xem Chi
                                                        Tiết</button>
                                                    @if ($or->payment_status == 'pending' && $or->payment_method_id == 2)
                                                        <button class="btn btn-secondary retry-payment-btn" data-order-id="{{ $or->id }}">Thanh toán lại</button>                                                        
                                                    @endif

                                                    @if ($or->payment_status == 'pending' && $or->payment_method_id == 3)
                                                        <button class="btn btn-secondary retry-payment-btn" data-order-id="{{ $or->id }}">Thanh toán lại</button>                                                        
                                                    @endif
                                                @endif

                                                @if ($or->status_id == 2)
                                                    <button
                                                        class="btn btn-danger cancel-order"data-order-id="{{ $or->id }}"
                                                        data-status={{ $or->status_id }}>Hủy</button>
                                                    <button class="btn btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $or->id }}"
                                                    >Xem Chi Tiết</button>
                                                @endif

                                                @if ($or->status_id == 3)
                                                    <button class="btn btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $or->id }}"
                                                    >Xem Chi Tiết</button>
                                                @endif


                                                <!-- Nút xác nhận đơn hàng cho trạng thái "Đã giao" -->
                                                @if ($or->status_id == 4)
                                                    <button class="btn btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $or->id }}"
                                                    >Xem Chi Tiết</button>
                                                    @if ($or->complaint)
                                                        <a class="btn btn-warning" href="{{ route('complaintsDetail',['orderId'=> $or->id ]) }}">Xem khiếu nại</a>    
                                                    @else
                                                        <a class="btn btn-warning" href="{{ route('complaints',['orderId'=> $or->id ]) }}">Khiếu Nại</a>    
                                                    @endif    
                                                    <button class="btn btn-primary confirm-order"
                                                        data-order-id="{{ $or->id }}"
                                                        data-status={{ $or->status_id }}>Xác nhận đơn hàng</button>
                                                @endif

                                                <!-- Nút Khiếu nại cho trạng thái "Hoàn tất" -->
                                                @if ($or->status_id == 5)
                                            
                                                        <button class="btn btn-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#orderModal{{ $or->id }}"
                                                        >Xem Chi Tiết</button>
                                          
                                                @endif  

                                                @if ($or->status_id == 6)
                                                    <button class="btn btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $or->id }}"
                                                    >Xem Chi Tiết</button>
                                                    
                                                @endif


                                            </div>
                                        </div>
                                        <!-- Modal cho từng đơn hàng , chi tiết đơn hàng -->
                                        <div class="modal fade" id="orderModal{{ $or->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="orderModalLabel{{ $or->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="orderModalLabel{{ $or->id }}">Chi
                                                            tiết đơn hàng #{{ $or->id }}</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body d-flex justify-content-between">
                                                        <div>
                                                            <ul>
                                                               
                                                                @foreach ($or->cartItems as $item)
                                                                   
                                                                    <li>
                                                                        <strong>Sản phẩm:</strong>
                                                                        {{ $item->product_name }}<br>
                                                                        <strong>Kích cỡ:</strong> {{ $item->size }}<br>
                                                                        <strong>Số lượng:</strong> {{ $item->quantity }}<br>
                                                                        <strong>Giá tiền:</strong> {{ number_format($item->price,0,',','.').' VNĐ' }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <p><strong>Phí vận chuyển:</strong>
                                                            {{ number_format($or->shipping_fee, 0, ',', '.') }} VNĐ</p>
                                                            
                                                                <div class="payment-status">
                                                                    Trạng thái thanh toán
                                                                    @switch($or->payment_status)
                                                                        @case('pending')
                                                                            <span class="badge bg-warning">Đang chờ thanh toán</span>
                                                                            @break
                                                                        @case('paid')
                                                                            <span class="badge bg-success">Đã thanh toán</span>
                                                                            @break
                                                                        @case('canceled')
                                                                            <span class="badge bg-danger">Thanh toán thất bại</span>
                                                                            @break
                                                                        @default
                                                                            <span class="badge bg-secondary">Không rõ trạng thái</span>
                                                                    @endswitch
                                                                </div>
                                                        
                                                            
                                                                <div class="payment-method">
                                                                    Phương thức thanh toán:
                                                                    <span class="badge bg-secondary">{{ $or->payment->name }}</span>
                                                                </div>
                                                           
                                                            
                                                            <p><strong>Tổng tiền:</strong>
                                                                {{ number_format($newTotal, 0, ',', '.') }} VNĐ</p>
                                                        </div>
                                                        <div>
                                                            <ul>
                                                                    <li>
                                                                        <strong>Tên người nhận:</strong>
                                                                        {{ $or->orderAddress->recipient_name }}<br>
                                                                        <strong>Email người nhận:</strong>{{ $or->orderAddress->recipient_email }}<br>
                                                                        <strong>Địa chỉ:</strong>{{ $or->orderAddress->address_order }},
                                                                        {{ $or->orderAddress->ward }},
                                                                        {{ $or->orderAddress->city }},
                                                                        {{ $or->orderAddress->province }}<br>
                                                                        <strong>Số điện thoại:</strong>
                                                                        {{ $or->orderAddress->phone_number }}
                                                                    </li>
                                                            </ul>
                        
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('script')
    <script type="module">
        // Switching between Account and Orders sections
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

        // Switching tabs for Order Status
        document.querySelectorAll('.tab-link').forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.tab-link').forEach(function(t) {
                    t.classList.remove('active');
                });
                tab.classList.add('active');

                const status = tab.getAttribute('data-status');
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
        document.querySelectorAll('.confirm-order').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Lấy ID đơn hàng từ thuộc tính data-order-id
                const orderId = this.getAttribute('data-order-id');
                const currentStatus = this.getAttribute(
                    'data-status'); // Lấy trạng thái hiện tại của đơn hàng

                // Các tham số cần truyền qua body, bao gồm ID của đơn hàng
                const dataToSend = {
                    orderId: orderId,
                    currentStatus: currentStatus // Thêm thông tin trạng thái hiện tại nếu cần
                };

                // Gửi yêu cầu POST mà không cần ID trong URL
                fetch('{{ route('confirmOrder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: JSON.stringify(dataToSend) // Truyền tất cả tham số qua body
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {

                            // Cập nhật giao diện khi xác nhận thành công
                            const orderCard = this.closest('.order-card');
                            orderCard.setAttribute('data-status', data.newStatus);
                            // tên trạng thái
                            const orderStatus = orderCard.querySelector('.order-status');
                            // Cập nhật trạng thái hiển thị trong giao diện
                            orderStatus.textContent = data.statusName;
                            orderStatus.setAttribute('data-status', data
                                .newStatus); // Cập nhật mã trạng thái từ server

                             // Ẩn hoặc thay đổi các nút sau khi đơn hàng đã hoàn tất
                                const confirmButton = orderCard.querySelector('.confirm-order');
                                if (confirmButton) {
                                    confirmButton.style.display = 'none'; // Ẩn nút "Xác nhận đơn hàng"
                                }

                                const complaintButton = orderCard.querySelector('a.btn-warning');
                                if (complaintButton) {
                                    complaintButton.style.display = 'none'; // Ẩn nút "Khiếu Nại"
                                }

                            // Chuyển đơn hàng sang tab "Hoàn tất" nếu trạng thái mới là hoàn tất
                            if (data.newStatus === 5) {
                                // Tìm tab "Hoàn tất" và chuyển đến đó
                                const completedTab = document.querySelector(
                                    `.tab-link[data-status="${data.newStatus}"]`);
                                if (completedTab) {
                                    // Chuyển sang tab "Hoàn tất"
                                    document.querySelectorAll('.tab-link').forEach(function(tab) {
                                        tab.classList.remove('active');
                                    });
                                    completedTab.classList.add('active');

                                    // Ẩn/hiện các đơn hàng theo trạng thái
                                    const orders = document.querySelectorAll('.order-card');
                                    orders.forEach(function(order) {
                                        if (order.getAttribute('data-status') === '5') {
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
                            alert('Có lỗi xảy ra');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra trong quá trình xác nhận');
                    });
            });
        });

        // nút hủy bỏ đơn hàng
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
                                                    document.querySelectorAll('.retry-payment-btn').forEach(
                                                        function(bt){
                                                            bt.style.display = 'none';
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

        // nút thanh toán lại
        document.addEventListener("DOMContentLoaded", () => {
            const retryButtons = document.querySelectorAll(".retry-payment-btn");

            retryButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const orderId = this.getAttribute('data-order-id');
                    

                    fetch('{{ route('retryPayment') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ order_id: orderId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.vnpay) {
                            // Điều hướng đến URL thanh toán VNPAY
                            window.location.href = data.vnpay;
                        } else if(data.momo){
                            // Điều hướng đến URL thanh toán VNPAY
                            window.location.href = data.momo;
                        }else {
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

        // nút khiếu lại
        

    </script>

    <script type="module">
        // Lắng nghe sự kiện từ Laravel Echo

        const orderElement = document.querySelectorAll('.order-card')
        
        orderElement.forEach( order => {
            const orderId = order.getAttribute('data-order-id'); // lấy ra id của từng đơn hàng
            console.log(orderId);
            Echo.private(`order.${orderId}`)
                .listen('OrderStatusUpdatedEvent', (e) => {
                    console.log(e); // Kiểm tra dữ liệu sự kiện nhận được

                    // Lấy thông tin từ sự kiện
                    const orderId = e.order.id;
                    const newStatus = e.order.order_status.name;
                    const newStatusId = e.order.status_id;


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

                        // Thêm nút dựa vào trạng thái mới
                        if (newStatusId === 1) { // Trạng thái "Chờ xử lý"
                            buttonGroup.innerHTML =
                                `<button class="btn btn-danger ">Hủy
                                </button><button class="btn btn-success"
                                data-bs-toggle="modal"data-bs-target="#orderModal${orderId}">
                                Xem chi tiết</button>`;
                                                            
                        } else if (newStatusId === 2) {
                            buttonGroup.innerHTML =
                                `<button class="btn btn-danger">Hủy</button>
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
                                <a class="btn btn-warning" href="{{ route('complaints',['orderId'=> $or->id ]) }}">Khiếu Nại</a>
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
                        } else if(newStatusId === 6){
                            buttonGroup.innerHTML = `<button class="btn btn-success"
                            data-bs-toggle="modal" data-bs-target="#orderModal${orderId}"
                            >Xem chi tiết</button>`;
                        }

                        // Gắn lại sự kiện click cho nút 'Xác nhận đơn hàng'
                        document.querySelectorAll('.confirm-order').forEach(button => {
                            button.addEventListener('click', function(e) {
                                e.preventDefault();

                                // Lấy ID đơn hàng từ thuộc tính data-order-id
                                const orderId = this.getAttribute('data-order-id');
                                const currentStatus = this.getAttribute(
                                    'data-status'); // Lấy trạng thái hiện tại của đơn hàng

                                // Các tham số cần truyền qua body, bao gồm ID của đơn hàng
                                const dataToSend = {
                                    orderId: orderId,
                                    currentStatus: currentStatus // Thêm thông tin trạng thái hiện tại nếu cần
                                };

                                console.log(dataToSend);
                                

                                // Gửi yêu cầu POST mà không cần ID trong URL
                                fetch('{{ route('confirmOrder') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                .getAttribute('content'),
                                        },
                                        body: JSON.stringify(dataToSend) // Truyền tất cả tham số qua body
                                    })
                                    .then(response => {
                                        // Kiểm tra nếu response không phải là JSON hợp lệ
                                        if (response.ok) {
                                            return response.json();  // Chỉ phân tích JSON nếu phản hồi hợp lệ
                                        } else {
                                            throw new Error('Network response was not ok');
                                        }
                                    })
                                    .then(data => {
                                        if (data.status === 'success') {
                                                console.log(data);
                                            // Cập nhật giao diện khi xác nhận thành công
                                            const orderCard = this.closest('.order-card');
                                            orderCard.setAttribute('data-status', data.newStatus);
                                            // tên trạng thái
                                            const orderStatus = orderCard.querySelector('.order-status');
                                            // Cập nhật trạng thái hiển thị trong giao diện
                                            orderStatus.textContent = data.statusName;
                                            orderStatus.setAttribute('data-status', data
                                                .newStatus); // Cập nhật mã trạng thái từ server

                                            // Chuyển đơn hàng sang tab "Hoàn tất" nếu trạng thái mới là hoàn tất
                                            if (data.newStatus === 5) {

                                                const button = this; // Lấy chính nút đang được click
                                                button.textContent = 'Khiếu nại'; // Đổi nội dung nút
                                                button.classList.remove('confirm-order'); // Xóa class "confirm-order"
                                                button.classList.add('btn', 'btn-warning');
                                                button.setAttribute('data-status', data
                                                    .newStatus); // Cập nhật trạng thái nút

                                                // Tìm tab "Hoàn tất" và chuyển đến đó
                                                const completedTab = document.querySelector(
                                                    `.tab-link[data-status="${data.newStatus}"]`);
                                                if (completedTab) {
                                                    // Chuyển sang tab "Hoàn tất"
                                                    document.querySelectorAll('.tab-link').forEach(function(tab) {
                                                        tab.classList.remove('active');
                                                    });
                                                    completedTab.classList.add('active');

                                                    // Ẩn/hiện các đơn hàng theo trạng thái
                                                    const orders = document.querySelectorAll('.order-card');
                                                    orders.forEach(function(order) {
                                                        if (order.getAttribute('data-status') === '5') {
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
                                            alert('Có lỗi xảy ra');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        // alert('Có lỗi xảy ra trong quá trình xác nhận');
                                    });
                        },{once:true}); //sự kiện này chỉ được gọi một lần duy nhất
                    });


                    // Lọc và hiển thị đơn hàng theo tab trạng thái hiện tại
                    const activeStatus = document.querySelector('.tab-link.active').getAttribute('data-status');
                    if (activeStatus !== 'all' && activeStatus !== newStatusId.toString()) {
                        orderElement.style.display = 'none';
                    } else {
                        orderElement.style.display = 'block';
                    }
                }
            });

        })

        
    </script>



@endpush
