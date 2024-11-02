@extends('client.components.default')

@push('styles')
    <style>
        .shopping__notice{
            display: block;
            text-align: center;
            border: 1px dotted #333;
            padding: 20px;
            background-color: rgba(129, 185, 242, 0.1)
        }
        .notice__subtitle{
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }








.coupon-section,
.payment-details {
    background-color: #ffffff; /* Màu nền trắng cho phần giảm giá và thanh toán */
    border-radius: 10px; /* Bo góc */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ cho phần */
}

.coupon-section h4,
.payment-details h4 {
    font-size: 1.25rem; /* Kích thước font cho tiêu đề */
    color: #333; /* Màu chữ */
    font-weight: bold; /* Chữ đậm */
    margin-bottom: 15px; /* Khoảng cách dưới tiêu đề */
}

.table-bordered th,
.table-bordered td {
    vertical-align: middle; /* Căn giữa cho ô */
}



.payment-details .table tr td {
    padding: 8px 0; /* Padding cho ô trong bảng thanh toán */
}

.payment-details .table tr:last-child td {
    font-weight: bold; /* Chữ đậm cho dòng tổng đơn hàng */
    color: #3F51B5; /* Màu sắc cho tổng đơn hàng */
}

.btn-primary {
    background-color: #007bff; /* Màu nền cho nút chính */
    border: none; /* Bỏ viền */
    color: #fff; /* Màu chữ */
}

.btn-primary:hover {
    background-color: #0056b3; /* Màu nền khi hover */
}

.btn-success {
    background-color: #28a745; /* Màu nền cho nút thành công */
    border: none; /* Bỏ viền */
    color: #fff; /* Màu chữ */
}

.btn-success:hover {
    background-color: #218838; /* Màu nền khi hover */
}

.text-danger i {
    font-size: 1.25rem; /* Kích thước biểu tượng cảnh báo */
    color: #dc3545; /* Màu đỏ cho biểu tượng cảnh báo */
}

.mt-4 {
    margin-top: 1.5rem; /* Khoảng cách trên */
}

.mt-5 {
    margin-top: 3rem; /* Khoảng cách trên */
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
                                            <th class="product-subtotal">Tổng</th>
                                            <th class="product-remove"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="product-thumbnail  text-start">
                                                <!-- Single-product start -->
                                                <div class="single-product">
                                                    <div class="product-img">
                                                        <a href="single-product.html"><img src="img/product/2.webp" alt=""></a>
                                                    </div>
                                                    <div class="product-info">
                                                        <h4 class="post-title"><a class="text-light-black" href="#">dummy product name</a></h4>
                                                        <p class="mb-0">Size :     SL</p>
                                                    </div>
                                                </div>
                                                <!-- Single-product end -->												
                                            </td>
                                            <td class="product-price">$56.00</td>
                                            <td class="product-quantity">
                                                <div class="cart-plus-minus">
                                                    <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                                    <div class="inc qtybutton">+</div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">$112.00</td>
                                            <td class="product-remove">
                                                <a href="#"><i class="zmdi zmdi-close"></i></a>
                                            </td>
                                        </tr>
                                       
                                        
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
                                            <td class="text-end">$155.00</td>
                                        </tr>
                                        <tr>
                                            <td>Giảm giá</td>
                                            <td class="text-end">$15.00</td>
                                        </tr>
                                        <tr>
                                            <td>Thuế</td>
                                            <td class="text-end">$0.00</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Thành tiền</strong></td>
                                            <td class="text-end"><strong>$170.00</strong></td>
                                        </tr>
                                    </table>
                                    <button class="btn btn-success w-100 mt-3">Thanh Toán</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
