@extends('client.components.default')

@push('styles')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .shopping__notice {
            display: block;
            text-align: center;
            border: 1px dotted #333;
            padding: 20px;
            background-color: rgba(129, 185, 242, 0.1)
        }

        .notice__subtitle {
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }








        .coupon-section,
        .payment-details {
            background-color: #ffffff;
            /* Màu nền trắng cho phần giảm giá và thanh toán */
            border-radius: 10px;
            /* Bo góc */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Đổ bóng nhẹ cho phần */
        }

        .coupon-section h4,
        .payment-details h4 {
            font-size: 1.25rem;
            /* Kích thước font cho tiêu đề */
            color: #333;
            /* Màu chữ */
            font-weight: bold;
            /* Chữ đậm */
            margin-bottom: 15px;
            /* Khoảng cách dưới tiêu đề */
        }

        .table-bordered th,
        .table-bordered td {
            vertical-align: middle;
            /* Căn giữa cho ô */
        }



        .payment-details .table tr td {
            padding: 8px 0;
            /* Padding cho ô trong bảng thanh toán */
        }

        .payment-details .table tr:last-child td {
            font-weight: bold;
            /* Chữ đậm cho dòng tổng đơn hàng */
            color: #3F51B5;
            /* Màu sắc cho tổng đơn hàng */
        }

        .btn-primary {
            background-color: #007bff;
            /* Màu nền cho nút chính */
            border: none;
            /* Bỏ viền */
            color: #fff;
            /* Màu chữ */
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Màu nền khi hover */
        }

        .btn-success {
            background-color: #28a745;
            /* Màu nền cho nút thành công */
            border: none;
            /* Bỏ viền */
            color: #fff;
            /* Màu chữ */
        }

        .btn-success:hover {
            background-color: #218838;
            /* Màu nền khi hover */
        }

        .text-danger i {
            font-size: 1.25rem;
            /* Kích thước biểu tượng cảnh báo */
            color: #dc3545;
            /* Màu đỏ cho biểu tượng cảnh báo */
        }

        .mt-4 {
            margin-top: 1.5rem;
            /* Khoảng cách trên */
        }

        .mt-5 {
            margin-top: 3rem;
            /* Khoảng cách trên */
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
                            <h2>Giỏ Hàng</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="">Trang Chủ</a></li>
                                <li>Giỏ Hàng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="shopping-cart-area pb-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shopping-cart">
                        <!-- Continue Shopping Link -->
                        <div class="shopping__notice mt-4 mb-4">
                            <h6 class="notice__title">
                                <p>Chỉ cần thêm <strong>200.000 VND</strong> nữa để được miễn phí vận chuyển!</p>
                            </h6>
                            <a class="notice__subtitle" href="">
                                <div>Tiếp tục mua sắm</div>
                                <div><i class="zmdi zmdi-arrow-right"></i></div>
                            </a>
                        </div>

                        <!-- Cart Table -->
                        <div class="shop-cart-table">
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">Sản Phẩm</th>
                                            <th class="product-price">Giá tiền</th>
                                            <th class="product-quantity">Số lượng</th>
                                            <th class="product-subtotal">Thành tiền</th>
                                            <th class="product-remove"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($cart->cartItem as $item)
                                            <tr>
                                                <td class="product-thumbnail  text-start">
                                                    <!-- Single-product start -->
                                                    <div class="single-product">
                                                        <div class="product-img">
                                                            <img src="{{ asset($item->product_image) }}" alt="">
                                                        </div>
                                                        <div class="product-info">
                                                            <h4 class="post-title"><a class="text-light-black"
                                                                    href="#">{{ $item->product_name }}</a></h4>
                                                            <p class="mb-0">{{ $item->size }}</p>
                                                        </div>
                                                    </div>
                                                    <!-- Single-product end -->
                                                </td>
                                                <td class="product-price">
                                                    {{ number_format($item->product_price, 0, ',', '.') . ' VNĐ' }}</td>
                                                <td class="product-quantity">
                                                    <div>
                                                        <button type="button" class="dec qtybutton">-</button>
                                                        <input type="text" value="{{ $item->quantity }}" name="qtybutton"
                                                            class="cart-plus-minus-box" data-id="{{ $item->id }}"
                                                            data-product_variant_id="{{ $item->product_variant_id }}">
                                                        <button type="button" class="inc qtybutton">+</button>
                                                    </div>
                                                </td>
                                                <td class="product-subtotal">
                                                    {{ number_format($item->product_price * $item->quantity, 0, ',', '.') . ' VNĐ' }}
                                                </td>
                                                <td class="product-remove">
                                                    <a href="#" class="remove-from-cart"
                                                        data-cart-item-id="{{ $item->id }}">
                                                        <i class="zmdi zmdi-close"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Coupon and Payment Details -->
                        <div class="row mt-5">
                            <!-- Coupon Section -->
                            <div class="col-md-6">
                                <div class="coupon-section p-4 border">
                                    <h4>Mã Giảm Giá</h4>
                                    <p>Nhập mã giảm giá của bạn nếu có:</p>
                                    <input type="text" class="form-control mb-3" placeholder="Mã giảm giá">
                                    <button class="btn btn-primary">Áp dụng</button>
                                </div>
                            </div>

                            <!-- Payment Details -->
                            <div class="col-md-6">
                                <div class="payment-details p-4 border">
                                    <h4>Chi Tiết Thanh Toán</h4>
                                    <table class="table">
                                        <tr>
                                            <td>Tổng tiền</td>
                                            <td class="total-amount">{{ number_format($totalAmount, 0, ',', '.') . ' VNĐ' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Giảm giá</td>
                                            <td class="text-end">0</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tổng đơn hàng</strong></td>
                                            <td class="total-items">
                                                <strong>{{ number_format($totalAmount, 0, ',', '.') . ' VNĐ' }}</strong>
                                            </td>
                                        </tr>
                                    </table>


                                    <a href="{{ route('checkout') }}" class="btn btn-success w-100 mt-3">Thanh Toán</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qtyButtons = document.querySelectorAll('.qtybutton');

            qtyButtons.forEach(button => {
                button.addEventListener('click', handleQtyButtonClick);
            });


            function handleQtyButtonClick() {
                const cartPlusMinus = this.closest('.product-quantity');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const inputField = cartPlusMinus.querySelector('.cart-plus-minus-box');

                // Debugging: log the input field and its current value
                console.log('Input field:', inputField);
                let quantity = parseInt(inputField.value);
                console.log('Current quantity:', quantity);

                if (isNaN(quantity)) quantity = 0;

                const cartItemId = inputField.getAttribute('data-id');
                const productVariantId = inputField.getAttribute('data-product_variant_id');

                if (this.classList.contains('inc')) {
                    quantity++;
                } else if (this.classList.contains('dec')) {
                    if (quantity > 1) {
                        quantity--;
                    } else {
                        alert('Số lượng không được giảm dưới 1');
                        return;
                    }
                }

                inputField.value = quantity;

                // Debugging: log the new quantity before updating the input field
                console.log('New quantity:', quantity);
                inputField.value = quantity; // Cập nhật giá trị input

                // Gọi API để cập nhật số lượng
                fetch('{{ route('updateCartQuantity') }}', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            cart_item_id: cartItemId,
                            product_variant_id: productVariantId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const subtotal = data.subtotal;
                            this.closest('tr').querySelector('.product-subtotal').innerText = subtotal;
                            updateCartIconQuantity(data.newQuantityCart);
                        } else {
                            alert('Cập nhật số lượng không thành công');
                        }
                    })
                    .catch(error => {
                        console.error('Có lỗi xảy ra:', error);
                    });
            }
        });

        // Hàm cập nhật số lượng trên biểu tượng giỏ hàng
        // Hàm cập nhật số lượng trên biểu tượng giỏ hàng
        function updateCartIconQuantity(newQuantity) {
            const cartIcon = document.querySelector('.zmdi-shopping-cart'); // Thay đổi class nếu cần

            const quantityDisplay = document.querySelector('.cart-count');

            if (quantityDisplay) {
                quantityDisplay.innerText = parseInt(newQuantity); // Cập nhật số lượng
                return newQuantity; // Trả về newQuantity
            } else {
                console.error('Quantity display not found');
                return null; // Trả về null nếu không tìm thấy
            }
        }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const removeButtons = document.querySelectorAll('.remove-from-cart');

        removeButtons.forEach(button => {
            button.addEventListener('click', handleRemoveFromCart);
        });

        function handleRemoveFromCart(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

            const cartItemId = this.getAttribute('data-cart-item-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Xác nhận xóa sản phẩm
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: "Bạn sẽ không thể khôi phục lại sản phẩm này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, xóa nó!',
                cancelButtonText: 'Không, hủy!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gọi API để xóa sản phẩm
                    fetch('{{ route('removeFromCart') }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            cart_item_id: cartItemId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật giao diện: xóa sản phẩm khỏi bảng
                            this.closest('tr').remove(); // Xóa hàng khỏi bảng
                            updateCartIconQuantity(data.newQuantityCart); // Cập nhật số lượng trên biểu tượng giỏ hàng
                            // Cập nhật tổng tiền và tổng số đơn hàng
                            updateTotals(data.cartTotal, data.cartTotal);
                            // Hiển thị thông báo thành công
                            Swal.fire(
                                'Đã xóa!',
                                'Sản phẩm đã được xóa khỏi giỏ hàng.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Lỗi!',
                                'Không thể xóa sản phẩm khỏi giỏ hàng.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Có lỗi xảy ra:', error);
                        Swal.fire(
                            'Lỗi!',
                            'Có lỗi xảy ra. Vui lòng thử lại.',
                            'error'
                        );
                    });
                }
            });
        }

        function updateTotals(newTotalAmount, newTotalItems) {
            // Cập nhật tổng tiền
            const totalAmountElement = document.querySelector('.total-amount');
            totalAmountElement.textContent = newTotalAmount.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });

            // Cập nhật tổng số đơn hàng
            const totalItemsElement = document.querySelector('.total-items');
            
            totalItemsElement.textContent = newTotalItems.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });;
        }
    });
</script>

@endpush
