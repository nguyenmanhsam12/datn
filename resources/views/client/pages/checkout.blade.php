@extends('client.components.default')

@push('styles')
    <style>
        .shop-cart-table {
            background: #ffffff;
            /* Nền trắng */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .row {
            display: flex;
            /* Sử dụng Flexbox */
        }

        .col-md-6 {
            flex: 1;
            /* Đặt chiều rộng bằng nhau cho cả hai cột */
        }

        .title-1 {
            color: #343a40;
            /* Màu xám đậm */
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
            border: 1px solid #ced4da;
            /* Viền xám */
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        .billing-details input:focus,
        .custom-select:focus,
        .custom-textarea:focus {
            border-color: #007bff;
            /* Viền xanh dương khi focus */
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
            background-color: #007bff;
            /* Nền xanh dương */
            color: white;
        }

        .payment-method {
            background: #f8f9fa;
            /* Nền xám nhạt */
            padding: 20px;
            border-radius: 10px;
        }

        .payment-accordion-toggle {
            cursor: pointer;
            background-color: #007bff;
            /* Nền xanh dương */
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }







        .payment-method {
            background-color: #f9f9f9;
            /* Màu nền nhẹ */
            padding: 20px;
            /* Khoảng cách bên trong */
            border-radius: 8px;
            /* Bo góc */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Đổ bóng */
            margin-top: 20px;
            /* Khoảng cách trên */
        }

        .title-1 {
            font-size: 1.5rem;
            /* Kích thước chữ tiêu đề */
            color: #333;
            /* Màu chữ tiêu đề */
        }

        .payment-accordion {
            margin-bottom: 20px;
            /* Khoảng cách dưới cùng */
        }

        .payment-option {
            display: flex;
            /* Dùng flexbox để canh chỉnh */
            align-items: center;
            /* Căn giữa dọc */
            margin-bottom: 15px;
            /* Khoảng cách giữa các lựa chọn */
        }

        .payment-option input[type="radio"] {
            margin-right: 10px;
            /* Khoảng cách giữa radio và label */
            cursor: pointer;
            /* Con trỏ chuột khi hover */
        }

        .payment-option label {
            font-size: 1rem;
            /* Kích thước chữ cho label */
            color: #555;
            /* Màu chữ cho label */
            cursor: pointer;
            /* Con trỏ chuột khi hover */
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
                                <form action="#"id="orderForm">
                                    <div class="shop-cart-table check-out-wrap">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="billing-details pr-20">
                                                    <h4 class="title-1 title-border text-uppercase mb-30">Chi tiết thanh
                                                        toán</h4>
                                                    <div class="form-group">

                                                        <label for="">Tên người nhận</label>
                                                        <input type="text" placeholder="Tên của bạn..."
                                                            value="{{ $user->name }}" name="recipient_name"
                                                            id="recipient_name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="email" placeholder="Email của bạn..."
                                                            value="{{ $user->email }}" name="recipient_email"
                                                            id="recipient_email">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Số điện thoại</label>
                                                        <input type="tel" placeholder="Số điện thoại..."
                                                            value="{{ $user->phone_number }}" name="phone_number"
                                                            id="phone_number">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Tỉnh/Thành phố</label>
                                                        <select class="custom-select mb-15 province choose" name="province"
                                                            id="province">
                                                            <option value = "">Tỉnh / Thành phố</option>
                                                            @foreach ($province as $pro)
                                                                <option value="{{ $pro->matinh }}">{{ $pro->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Quận / Huyện</label>
                                                        <select class="custom-select mb-15 city choose" name="city"
                                                            id="city">
                                                            <option>Quận / Huyện</option>

                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Xã / Phường</label>
                                                        <select class="custom-select mb-15" name="ward" id="ward">
                                                            <option>Xã / Phường</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Địa chỉ</label>
                                                        <textarea class="custom-textarea" name="address_order" id="address_order" placeholder="Địa chỉ của bạn..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="our-order payment-details pr-20">
                                                    <h4 class="title-1 title-border text-uppercase mb-30">Đơn hàng của tôi
                                                    </h4>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th><strong>Sản phẩm</strong></th>
                                                                <th class="text-right"><strong>Thành tiền</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($cart)
                                                                @foreach ($cart->cartItem as $item)
                                                                <tr>
                                                                    <td style="display: flex;gap: 5px;align-items: center;">
                                                                        <img style="width: 10%;"
                                                                            src="{{ $item->product_image }}" alt="">
                                                                        {{ $item->product_name }} x {{ $item->quantity }}
                                                                    </td>
                                                                    <td class="text-right">
                                                                        {{ number_format($item->product_price * $item->quantity, 0, ',', '.') . ' VNĐ' }}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            @else
                                                                <p>Giỏ hàng đang chưa có sản phẩm nào</p>
                                                            @endif
                                                            
                                                            <tr>
                                                                <td>Giảm giá</td>
                                                                <td class="text-right">0 VNĐ</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Phí vận chuyển</td>
                                                                <td class="text-right">0 VNĐ</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Tổng đơn hàng</td>
                                                                <td class="text-right" name="total_amount"
                                                                    id="total_amount">
                                                                    {{ number_format($totalAmount, 0, ',', '.') . ' VNĐ' }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="payment-method mt-60 pl-20">
                                                    <h4 class="title-1 title-border text-uppercase mb-30">Phương thức thanh
                                                        toán</h4>
                                                    {{-- <div class="payment-accordion">
                                                        <div class="payment-option">
                                                            <input type="radio" id="online-payment" name="payment-method"
                                                                value="online" checked>
                                                            <label for="online-payment">Thanh toán online</label>
                                                        </div>
                                                        <div class="payment-option">
                                                            <input type="radio" id="cash-on-delivery"
                                                                name="payment-method" value="cash">
                                                            <label for="cash-on-delivery">Thanh toán khi nhận hàng</label>
                                                        </div>
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <select name="payment_method" class="form-control"
                                                            id="payment_method">
                                                            <option value="">Chọn hình thức thanh toán</option>
                                                            @foreach ($payment as $pay)
                                                                <option value="{{ $pay->id }}">{{ $pay->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button class="submit-button mt-15 col-12" type="submit">Thanh
                                                        Toán</button>
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


@push('script')
    {{-- đoạn code xử lí thông tin chuyển --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const wardSelect = document.getElementById('ward');

            // Khi người dùng chọn tỉnh/thành phố
            provinceSelect.addEventListener('change', function() {
                let province = provinceSelect.value;
                province = province.padStart(2, '0'); // Chuyển đổi giá trị thành chuỗi có số 0 đứng đầu
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Xóa tất cả tùy chọn trong citySelect và wardSelect
                citySelect.innerHTML = '<option value="">Quận / Huyện</option>';
                wardSelect.innerHTML = '<option value="">Xã / Phường</option>'; // Đặt lại tùy chọn phường

                if (province) {
                    // Gọi API để lấy danh sách thành phố dựa vào tỉnh
                    fetch('{{ route('selectProvince') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                province: province,
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            data.citys.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.macity;
                                option.textContent = city.name;
                                citySelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching cities:', error);
                        });
                }
            });

            // Khi người dùng chọn thành phố
            citySelect.addEventListener('change', function() {
                let city = citySelect.value;
                city = city.padStart(3, '0')
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                // Xóa tất cả tùy chọn trong wardSelect
                wardSelect.innerHTML = '<option value="">Xã / Phường</option>'; // Đặt lại tùy chọn phường
                if (city) {
                    // Gọi API để lấy danh sách xã/phường dựa vào thành phố
                    fetch('{{ route('selectCity') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                city: city
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            data.wards.forEach(ward => {
                                const option = document.createElement('option');
                                option.value = ward.phuongid;
                                option.textContent = ward.name;
                                wardSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching wards:', error);
                        });
                }
            });
        });
    </script>

    {{-- đặt hàng --}}
    <script>
        document.getElementById('orderForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Ngăn chặn việc gửi form mặc định


            const recipient_name = document.getElementById('recipient_name').value;
            const recipient_email = document.getElementById('recipient_email').value;
            const phone_number = document.getElementById('phone_number').value;
            const province = document.getElementById('province').value;
            const city = document.getElementById('city').value;
            const ward = document.getElementById('ward').value;
            const address_order = document.getElementById('address_order').value;
            const payment_method = document.getElementById('payment_method').value;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            fetch('{{ route('placeOrder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        recipient_name : recipient_name,
                        recipient_email : recipient_email,
                        phone_number : phone_number,
                        province : province,
                        city : city,
                        ward : ward,
                        address_order : address_order,
                        payment_method : payment_method,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if(data.message){
                        Swal.fire({
                            title: 'Đặt hàng thành công!',
                            text: 'Đơn hàng của bạn đã được tạo thành công.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then( () => {
                            setTimeout(() => {
                            window.location.href = '{{ route('home') }}';
                        }, 5000); // Thay đổi 2000 thành số milliseconds mà bạn muốn
                        });
                    };
                    // Xử lý dữ liệu trả về
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Hiển thị thông báo lỗi SweetAlert
                    Swal.fire({
                    title: 'Đặt hàng thất bại',
                    text: 'Đã có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    });
                });
        });
    </script>
@endpush
