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
                                                        <strong>Kích cỡ:</strong>
                                                        {{ $item->size }}<br>
                                                        <strong>Số lượng:</strong>
                                                        {{ $item->quantity }}<br>
                                                        <strong>Giá tiền:</strong>
                                                        {{ number_format($item->price, 0, ',', '.') . ' VNĐ' }}<br>
                                                        <strong>Giá tiền giảm:</strong>
                                                        {{ number_format($or->discount_amount, 0, ',', '.') . ' VNĐ' }}<br>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <p><strong>Phí vận chuyển:</strong>
                                                {{ number_format($or->shipping_fee, 0, ',', '.') }} VNĐ
                                            </p>
                                            

                                            <div class="payment-status">
                                                Trạng thái thanh toán
                                                @switch($or->payment_status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">Đang chờ thanh
                                                            toán</span>
                                                    @break

                                                    @case('paid')
                                                        <span class="badge bg-success">Đã thanh toán</span>
                                                    @break

                                                    @case('canceled')
                                                        <span class="badge bg-danger">Thanh toán thất
                                                            bại</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-secondary">Không rõ trạng
                                                            thái</span>
                                                @endswitch
                                            </div>


                                            <div class="payment-method">
                                                Phương thức thanh toán:
                                                <span
                                                    class="badge bg-secondary">{{ $or->payment->name }}</span>
                                            </div>


                                            <p><strong>Tổng tiền:</strong>
                                                {{ number_format($newTotal, 0, ',', '.') }} VNĐ</p>
                                        </div>
                                        <div>
                                            <ul>
                                                <li>
                                                    <strong>Tên người nhận:</strong>
                                                    {{ $or->orderAddress->recipient_name }}<br>
                                                    <strong>Email người
                                                        nhận:</strong>{{ $or->orderAddress->recipient_email }}<br>
                                                    <strong>Địa
                                                        chỉ:</strong>{{ $or->orderAddress->address_order }},
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

        <!-- Hiển thị các nút chuyển trang -->
        <div class="custom-pagination">
            {{ $order->links() }}
        </div>
    @endif
    
</div>


