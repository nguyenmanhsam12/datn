@extends('client.components.default')

@push('styles')
    <style>

.shop-cart-table {
    background: #ffffff; /* Nền trắng */
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

.row {
    display: flex; /* Sử dụng Flexbox */
}

.col-md-6 {
    flex: 1; /* Đặt chiều rộng bằng nhau cho cả hai cột */
}

.title-1 {
    color: #343a40; /* Màu xám đậm */
    margin-bottom: 20px;
    font-size: 24px;
    text-align: center;
}

.billing-details {
    margin-bottom: 30px;
}

.billing-details input,
.custom-select,
.custom-textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ced4da; /* Viền xám */
    border-radius: 5px;
    transition: border-color 0.3s;
}

.billing-details input:focus,
.custom-select:focus,
.custom-textarea:focus {
    border-color: #007bff; /* Viền xanh dương khi focus */
    outline: none;
}

.custom-select {
    height: 45px;
}

.custom-textarea {
    height: 100px;
}

table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

table th,
table td {
    padding: 10px;
    text-align: left;
}

table th {
    background-color: #007bff; /* Nền xanh dương */
    color: white;
}

.payment-method {
    background: #f8f9fa; /* Nền xám nhạt */
    padding: 20px;
    border-radius: 10px;
}

.payment-accordion-toggle {
    cursor: pointer;
    background-color: #007bff; /* Nền xanh dương */
    color: white;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 10px;
    transition: background-color 0.3s;
}







.payment-method {
    background-color: #f9f9f9; /* Màu nền nhẹ */
    padding: 20px; /* Khoảng cách bên trong */
    border-radius: 8px; /* Bo góc */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Đổ bóng */
    margin-top: 20px; /* Khoảng cách trên */
}

.title-1 {
    font-size: 1.5rem; /* Kích thước chữ tiêu đề */
    color: #333; /* Màu chữ tiêu đề */
}

.payment-accordion {
    margin-bottom: 20px; /* Khoảng cách dưới cùng */
}

.payment-option {
    display: flex; /* Dùng flexbox để canh chỉnh */
    align-items: center; /* Căn giữa dọc */
    margin-bottom: 15px; /* Khoảng cách giữa các lựa chọn */
}

.payment-option input[type="radio"] {
    margin-right: 10px; /* Khoảng cách giữa radio và label */
    cursor: pointer; /* Con trỏ chuột khi hover */
}

.payment-option label {
    font-size: 1rem; /* Kích thước chữ cho label */
    color: #555; /* Màu chữ cho label */
    cursor: pointer; /* Con trỏ chuột khi hover */
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
                        <h2>Thanh Toán</h2>
                    </div>
                    <div class="breadcumbs pb-15">
                        <ul>
                            <li><a href="index.html">Trang Chủ</a></li>
                            <li>Thanh Toán</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- HEADING-BANNER END -->
<!-- CHECKOUT-AREA START -->
<div class="shopping-cart-area  pt-80 pb-80">
    <div class="container">	
        <div class="row">
            <div class="col-12">
                <div class="shopping-cart">

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- check-out start -->
                        <div class="tab-pane active" id="check-out">
                            <form action="#">
                                <div class="shop-cart-table check-out-wrap">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="billing-details pr-20">
                                                <h4 class="title-1 title-border text-uppercase mb-30">Chi tiết thanh toán</h4>
                                                <input type="text" placeholder="Tên của bạn...">
                                                <input type="email" placeholder="Email của bạn...">
                                                <input type="tel" placeholder="Số điện thoại...">
                                                <select class="custom-select mb-15">
                                                    <option>Tỉnh / Thành phố</option>
                                                    <option>Dhaka</option>
                                                    <option>New York</option>
                                                    <option>London</option>
                                                    <option>Melbourne</option>
                                                    <option>Ottawa</option>
                                                </select>
                                                <select class="custom-select mb-15">
                                                    <option>Quận / Huyện</option>
                                                    <option>Dhaka</option>
                                                    <option>New York</option>
                                                    <option>London</option>
                                                    <option>Melbourne</option>
                                                    <option>Ottawa</option>
                                                </select>
                                                <select class="custom-select mb-15">
                                                    <option>Xã / Phường</option>
                                                    <option>Dhaka</option>
                                                    <option>New York</option>
                                                    <option>London</option>
                                                    <option>Melbourne</option>
                                                    <option>Ottawa</option>
                                                </select>
                                                <textarea class="custom-textarea" placeholder="Địa chỉ của bạn..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="our-order payment-details pr-20">
                                                <h4 class="title-1 title-border text-uppercase mb-30">Đơn hàng của chúng tôi</h4>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th><strong>Sản phẩm</strong></th>
                                                            <th class="text-right"><strong>Tổng cộng</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="display: flex;gap: 5px;align-items: center;">
                                                                <img style="width: 10%;" src="img/product/2.webp" alt="">
                                                                Dummy Product Name x 2
                                                            </td>
                                                            <td class="text-right">$86.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="display: flex;gap: 5px;align-items: center;">
                                                                <img style="width: 10%;" src="img/product/2.webp" alt="">
                                                                Dummy Product Name x 2
                                                            </td>
                                                            <td class="text-right">$86.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tổng phụ</td>
                                                            <td class="text-right">$155.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Vận chuyển và xử lý</td>
                                                            <td class="text-right">$15.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Thuế VAT</td>
                                                            <td class="text-right">$00.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tổng đơn hàng</td>
                                                            <td class="text-right">$170.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="payment-method mt-60 pl-20">
                                                <h4 class="title-1 title-border text-uppercase mb-30">Phương thức thanh toán</h4>
                                                <div class="payment-accordion">
                                                    <div class="payment-option">
                                                        <input type="radio" id="online-payment" name="payment-method" value="online" checked>
                                                        <label for="online-payment">Thanh toán online</label>
                                                    </div>
                                                    <div class="payment-option">
                                                        <input type="radio" id="cash-on-delivery" name="payment-method" value="cash">
                                                        <label for="cash-on-delivery">Thanh toán khi nhận hàng</label>
                                                    </div>
                                                </div>
                                                <button class="submit-button mt-15 col-12"  type="submit">Thanh Toán</button>			
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                                                            
                        </div>
                        <!-- check-out end -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
