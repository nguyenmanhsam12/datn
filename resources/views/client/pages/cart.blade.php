@extends('client.components.default')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        input[type="text"] {
            background: #f6f6f6;
            border: medium none;
        }

        .shopping__notice {
            display: block;
            text-align: center;
            border: 1px dotted #333;
            padding: 20px;
            background-color: rgba(129, 185, 242, 0.1);
        }

        .notice__subtitle {
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .text-light-black {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .coupon-section,
        .payment-details {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .coupon-section h4,
        .payment-details h4 {
            font-size: 1.25rem;
            color: #333;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .table-bordered th,
        .table-bordered td {
            vertical-align: middle;
        }

        .payment-details .table tr td {
            padding: 8px 0;
            text-align: right;
            vertical-align: middle;
        }

        .payment-details .table tr:first-child td {
            font-weight: 500;
        }

        .payment-details .table tr:last-child td {
            font-weight: bold;
            color: #3F51B5;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .text-danger i {
            font-size: 1.25rem;
            color: #dc3545;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .mt-5 {
            margin-top: 3rem;
        }

        .cart-item {
            display: flex;
            align-items: center;
            border: 1px solid #d6d6d6;
            justify-content: center;
            gap: 5px;
        }

        .cart-item button,
        .cart-item input {
            line-height: 36px;
            padding: 0 10px;
            font-size: 14px;
        }

        .cart-item button {
            cursor: pointer;
        }


        .cart-item input {
            width: 40px;
            text-align: center;
            background-color: #fff;
            border-left: 1px solid #d6d6d6;
            border-right: 1px solid #d6d6d6;
        }

        .error-message {
            position: absolute;
            top: 100%;
            left: 0;
            color: red;
            font-size: 12px;
            margin-top: 4px;
            display: none;
            white-space: nowrap;
        }

        .error-mess {
            position: absolute;
            top: 100%;
            left: 0;
            color: red;
            font-size: 12px;
            margin-top: 4px;
            display: none;
            white-space: nowrap;
        }

        .payment-details .table tr td:first-child {
            text-align: left;
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

                                        @foreach ($cartItems as $item)
                                            <tr>
                                                <td class="product-thumbnail product-cart text-start">
                                                    <!-- Single-product start -->
                                                    <div class="single-product">
                                                        <div class="product-img">
                                                            <img src="{{ $item['image'] }}" alt="">
                                                        </div>
                                                        <div class="product-info">
                                                            <h4 class="post-title"><a class="text-light-black"
                                                                    href="#">{{ $item['name'] }}</a></h4>
                                                            <p class="mb-0">Size:{{ $item['size'] }}</p>
                                                        </div>
                                                    </div>
                                                    <!-- Single-product end -->
                                                </td>
                                                <td class="product-price">
                                                    {{ number_format($item['price'], 0, ',', '.') . ' VNĐ' }}</td>
                                                <td class="product-quantity">
                                                    <div class="cart-item" data-id="{{ $item['id'] }}"
                                                        style="position: relative;">
                                                        <button type="button" class="decrease-quantity">-</button>
                                                        <input type="text" value="{{ $item['quantity'] }}"
                                                            class="cart-plus-minus-box" min="1">
                                                        <span class="error-message"></span>
                                                        <span class="error-mess"></span>
                                                        <button type="button" class="increase-quantity">+</button>
                                                    </div>
                                                </td>
                                                <td class="total-price-{{ $item['id'] }}"
                                                    data-price="{{ $item['price'] }}">
                                                    {{ number_format($item['total_price'], 0, ',', '.') . ' VNĐ' }}
                                                </td>
                                                <td class="product-remove">
                                                    <a href="#" class="remove-from-cart"
                                                        data-cart-item-id="{{ $item['id'] }}">
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
                                    <input type="text" class="form-control mb-3" id="couponCode" placeholder="Mã giảm giá" 
                                           style="{{ session()->has('coupon_id') ? 'display:none;' : '' }}">
                                    <button id="applyCoupon" class="submit-button button-one" data-text="Áp dụng" 
                                            style="{{ session()->has('coupon_id') ? 'display:none;' : '' }}">Áp dụng</button>
                                    <button id="cancelCoupon" class="submit-button button-one mt-2" data-text="Hủy mã giảm giá" 
                                            style="{{ session()->has('coupon_id') ? '' : 'display:none;' }}">Hủy mã giảm giá</button>
                                    <span id="coupon_message" class="mt-3" style="display: none;"></span>
                                </div>                                
                            </div>

                            <!-- Payment Details -->
                            <div class="col-md-6">
                                <div class="payment-details p-4 border">
                                    <h4>Chi Tiết Thanh Toán</h4>
                                    <table class="table">
                                        <tr>
                                            <td>Tổng tiền</td>
                                            <td class="total-amount">
                                                {{ number_format(session('totalAmount', 0), 0, ',', '.').' VNĐ' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Giảm giá</td>
                                            <td class="text-end">{{ number_format(session('discount', 0), 0, ',', '.').' VNĐ' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tổng đơn hàng</strong></td>
                                            <td>
                                        
                                                    <strong
                                                        class="total-items">
                                                        @if(session()->has('newTotal'))
                                                            {{ number_format(session('newTotal', 0), 0, ',', '.').' VNĐ' }}
                                                        @else
                                                            0VNĐ
                                                        @endif
                                                    </strong>
                                                    
                                            </td>
                                        </tr>
                                    </table>


                                    <a href="" id="check_out"
                                        class="submit-button button-one text-center w-100 mt-3 check"
                                        data-text="Thanh Toán">Thanh Toán</a>
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
    {{-- cập nhập số lượng trong giỏ hàng --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // hàm cập nhập số lượng giỏ hàng trên icon
            function updateCartIconQuantity(newQuantityCart) {
                const cartCount = document.querySelector('.cart-count');
                cartCount.textContent = newQuantityCart
            }
            // Format lại giá tiền
            function formatPrice(price) {
                // Chuyển giá trị thành chuỗi và loại bỏ các ký tự không phải là số
                let formattedPrice = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                // Thêm đuôi "VNĐ"
                return formattedPrice + " VNĐ";
            }

            function convertToVND(amount) {
                return new Intl.NumberFormat('vi-VN', { style: 'decimal' }).format(amount) + ' VNĐ';
            }

            // Xử lý tăng số lượng
            document.querySelectorAll('.increase-quantity').forEach(function(button) {
                button.addEventListener('click', function() {
                    const cartItem = this.closest('.cart-item');
                    const cartItemId = cartItem.getAttribute('data-id');
                    let quantity = cartItem.querySelector('.cart-plus-minus-box');
                    let itemTotalPrice = document.querySelector(`.total-price-${cartItemId}`);

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    const errorMessage = cartItem.querySelector(
                            '.error-message'); // Thẻ hiển thị lỗi  
                    // Xóa lỗi nếu giá trị hợp lệ
                    errorMessage.style.display = 'none';
                    errorMessage.innerText = '';

                    let totalAmount = document.querySelector('.total-amount');
                    let totalItems = document.querySelector('.total-items');            

                    fetch('{{ route('increaseQuantity') }}', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                cart_item_id: cartItemId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                // Hiển thị thông báo lỗi từ server
                                alert(data.error);
                            } else {
                                quantity.value = data.quantity;
                                itemTotalPrice.innerText = formatPrice(data.totalPrice);
                                updateCartIconQuantity(data.quantityCartIcon);
                                totalAmount.textContent = formatPrice(data.total);
                                totalItems.textContent = formatPrice(data.totalCartPrice);
                                document.querySelector('.text-end').textContent = convertToVND(data.discount);

                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            // Xử lý giảm số lượng
            document.querySelectorAll('.decrease-quantity').forEach(function(button) {

                button.addEventListener('click', function() {

                    const cartItem = this.closest('.cart-item');
                    const cartItemId = cartItem.getAttribute('data-id');
                    let quantity = cartItem.querySelector('.cart-plus-minus-box');
                    let itemTotalPrice = document.querySelector(`.total-price-${cartItemId}`);

                    let totalAmount = document.querySelector('.total-amount');
                    let totalItems = document.querySelector('.total-items');


                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                
                    fetch('{{ route('decreaseQuantity') }}', {
                            method: 'PUT',
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
                            if (data.error) {
                                alert(data.error);
                            } else {
                                quantity.value = data.quantity;
                                itemTotalPrice.innerText = formatPrice(data.totalPrice);
                                updateCartIconQuantity(data.quantityCartIcon);
                                totalAmount.textContent = formatPrice(data.total);
                                totalItems.textContent = formatPrice(data.totalCartPrice);
                                document.querySelector('.text-end').textContent = convertToVND(data.discount);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
            // focus ô input
            // Lắng nghe thay đổi số lượng từ ô input
            document.querySelectorAll('.cart-plus-minus-box').forEach(function(input) {
                input.addEventListener('input', function() {

                    // 
                    const cartItem = this.closest('.cart-item');
                    const cartItemId = cartItem.getAttribute('data-id');
                    let totalAmount = document.querySelector('.total-amount');
                    let totalItems = document.querySelector('.total-items');

                    // số lượng
                    const quantityInput = this;
                    // lấy ra từng thành của tiền của 1 sản phẩm
                    let itemTotalPrice = document.querySelector(`.total-price-${cartItemId}`);

                    const errorMessage = cartItem.querySelector(
                        '.error-message'); // Thẻ hiển thị lỗi  

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    // Xóa lỗi nếu giá trị hợp lệ
                    errorMessage.style.display = 'none';
                    errorMessage.innerText = '';

                    // Kiểm tra nếu ô nhập trống
                    if (quantityInput.value === "") {
                        errorMessage.innerText = 'Số lượng không được để trống.';
                        errorMessage.style.display = 'block';
                        itemTotalPrice.innerText = formatPrice(
                        0); // Cập nhật lại thành tiền thành 0
                        return;
                    }

                    // Kiểm tra nếu giá trị nhập vào không phải là số
                    const quantity = parseInt(quantityInput.value);
                    if (isNaN(quantity)) {
                        errorMessage.innerText = 'Số lượng phải là một số.';
                        errorMessage.style.display = 'block';
                        itemTotalPrice.innerText = formatPrice(
                            0); // Cập nhật lại thành tiền thành 0
                        return;
                    }

                    // Kiểm tra nếu số lượng nhỏ hơn 1
                    if (quantity < 1) {
                        errorMessage.innerText = 'Số lượng phải lớn hơn 0.';
                        errorMessage.style.display = 'block';
                        itemTotalPrice.innerText = formatPrice(
                            0); // Cập nhật lại thành tiền thành 0
                        return;
                    }

                    // Gửi yêu cầu cập nhật số lượng lên server
                    fetch('{{ route('updateQuantity') }}', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                cart_item_id: cartItemId,
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                // Hiển thị thông báo lỗi từ server
                                errorMessage.innerText = data.error;
                                errorMessage.style.display = 'block';
                            } else {
                                // Cập nhật số lượng và tổng tiền nếu thành công
                                itemTotalPrice.innerText = formatPrice(data.totalPrice);
                                updateCartIconQuantity(data.quantityCartIcon);
                                totalAmount.textContent = formatPrice(data.total);
                                totalItems.textContent = formatPrice(data.totalCartPrice);
                                document.querySelector('.text-end').textContent = convertToVND(data.discount);

                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            errorMessage.innerText = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
                            errorMessage.style.display = 'block';
                        });

                });
            });

            // kiểm tra lỗi trước khi sang trang thanh toán
            document.getElementById('check_out').addEventListener('click', function(event) {
                event.preventDefault(); // Ngừng việc chuyển trang để kiểm tra lỗi

                const errorMessages = document.querySelectorAll(
                '.error-message'); // Lấy tất cả các thông báo lỗi
                let hasError = false;

                // Kiểm tra nếu có bất kỳ thông báo lỗi nào hiển thị
                errorMessages.forEach(function(errorMessage) {
                    if (errorMessage.style.display === 'block') {
                        hasError = true; // Nếu có lỗi, gán hasError thành true
                    }
                });

                // Nếu không có lỗi, chuyển sang trang thanh toán
                if (!hasError) {
                    // Chuyển trang đến trang thanh toán
                    window.location.href =
                    '{{ route('checkout') }}'; // Hoặc sử dụng phương thức chuyển hướng khác
                } else {
                    // Nếu có lỗi, không thực hiện chuyển trang
                    console.log('Có lỗi cần sửa trước khi thanh toán!');
                }

            });
        });
    </script>

    {{-- áp mã và xóa mã giảm giá --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
                const applyButton = document.getElementById("applyCoupon");
                const cancelButton = document.getElementById("cancelCoupon");
                const couponInput = document.getElementById("couponCode");
                const couponMessage = document.getElementById("coupon_message");
                const discountDisplay = document.querySelector(".text-end");
                const totalDisplay = document.querySelector(".total-items");

                // Format giá tiền
                function formatPrice(price) {
                    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " VNĐ";
                }

                function convertToVND(amount) {
                    return new Intl.NumberFormat('vi-VN', { style: 'decimal' }).format(amount) + ' VNĐ';
                }

                // Áp dụng mã giảm giá
                applyButton?.addEventListener("click", function () {
                    const couponCode = couponInput.value;

                    if (couponCode) {
                        fetch("{{ route('applyCoupon') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            },
                            body: JSON.stringify({ code: couponCode }),
                        })
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.success) {
                                    // Cập nhật giao diện khi mã giảm giá hợp lệ
                                    couponMessage.innerText = data.message;
                                    couponMessage.classList.remove("text-danger");
                                    couponMessage.classList.add("text-success");
                                    couponMessage.style.display = "block";

                                    // Cập nhật số tiền giảm giá và tổng đơn hàng
                                    discountDisplay.textContent = convertToVND(data.discount);
                                    totalDisplay.textContent = formatPrice(data.new_total);

                                    // Ẩn nút áp dụng, hiện nút hủy mã giảm giá
                                    applyButton.style.display = "none";
                                    couponInput.style.display = "none";
                                    cancelButton.style.display = "inline-block";
                                } else {
                                    // Hiển thị lỗi nếu mã giảm giá không hợp lệ
                                    couponInput.value = "";
                                    couponMessage.textContent = data.error;
                                    couponMessage.classList.remove("text-success");
                                    couponMessage.classList.add("text-danger");
                                    couponMessage.style.display = "block";
                                }
                            })
                            .catch((error) => console.error("Error:", error));
                    }
                });

                // Hủy mã giảm giá
                cancelButton?.addEventListener("click", function () {
                    fetch("{{ route('removeCoupon') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        },
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                // Cập nhật giao diện sau khi hủy mã giảm giá
                                couponMessage.innerText = "Mã giảm giá đã được hủy!";
                                couponMessage.classList.remove("text-danger");
                                couponMessage.classList.add("text-success");
                                couponMessage.style.display = "block";

                                // Khôi phục lại số tiền ban đầu
                                discountDisplay.textContent = "0 VNĐ";
                                totalDisplay.textContent = formatPrice(data.original_total);

                                // Hiển thị lại nút áp dụng và ô nhập mã giảm giá
                                applyButton.style.display = "inline-block";
                                couponInput.value = '';
                                couponInput.style.display = "block";
                                cancelButton.style.display = "none";
                            }
                        })
                        .catch((error) => console.error("Error:", error));
                });
        });
    </script>

    {{-- xóa giỏ 1 sp trong giỏ hàng --}}
    <script>

            function formatPrice(price) {
                // Chuyển giá trị thành chuỗi và loại bỏ các ký tự không phải là số
                let formattedPrice = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                // Thêm đuôi "VNĐ"
                return formattedPrice + " VNĐ";
            }

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
                                        
                                        // dom của tổng tiền
                                        document.querySelector('.total-amount').textContent = formatPrice(data.newTotalAmount);
                                        // dom của tổng đơn hàng
                                        document.querySelector('.total-items').textContent = formatPrice(data.finalTotal);
                                        // dom của giảm giá
                                        document.querySelector('.text-end').textContent = formatPrice(data.discount);

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

                function updateCartIconQuantity(newQuantityCart) {
                    const cartCount = document.querySelector('.cart-count');
                    cartCount.textContent = newQuantityCart
                }

                
            });
    </script>
@endpush
