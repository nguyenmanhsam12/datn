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
            background: #fff;
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

        label {
            color: #333;
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
                                                    <h4 class="title-1 title-border text-uppercase mb-30">Thông tin thanh
                                                        toán</h4>
                                                    <div class="form-group">

                                                        <label for="">Tên người nhận</label>
                                                        <input type="text" placeholder="Tên của bạn..."
                                                            value="{{ $user->name }}" name="recipient_name"
                                                            id="recipient_name">
                                                        <div id="recipient_name_error" class="text-danger error-message" style="display: none;"></div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="email" placeholder="Email của bạn..."
                                                            value="{{ $user->email }}" name="recipient_email"
                                                            id="recipient_email">
                                                            <div id="recipient_email_error" class="text-danger error-message" style="display: none;"></div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Số điện thoại</label>
                                                        <input type="tel" placeholder="Số điện thoại..."
                                                            value="{{ $user->phone_number }}" name="phone_number"
                                                            id="phone_number">
                                                            <div id="recipient_phone_number_error" class="text-danger error-message" style="display: none;"></div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Tỉnh/Thành phố</label>
                                                        <select class="custom-select mb-15 province choose" name="province"
                                                            id="province">
                                                            <option value = "">Tỉnh / Thành phố</option>
                                                            @foreach ($province as $pro)
                                                                <option data-id = "{{ $pro->matinh }}"
                                                                    value="{{ $pro->name }}">{{ $pro->name }}

                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div id="recipient_province_error" class="text-danger error-message" style="display: none;"></div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Quận / Huyện</label>
                                                        <select class="custom-select mb-15 city choose" name="city"
                                                            id="city">
                                                            <option value="">Quận / Huyện</option>

                                                        </select>
                                                        <div id="recipient_city_error" class="text-danger error-message" style="display: none;"></div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Xã / Phường</label>
                                                        <select class="custom-select mb-15" name="ward" id="ward">
                                                            <option value="">Xã / Phường</option>
                                                        </select>
                                                        <div id="recipient_ward_error" class="text-danger error-message" style="display: none;"></div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Địa chỉ</label>
                                                        <textarea class="custom-textarea" name="address_order" id="address_order" placeholder="Địa chỉ của bạn..."></textarea>
                                                        <div id="recipient_address_order_error" class="text-danger error-message" style="display: none;"></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="our-order payment-details pr-20">
                                                    <h4 class="title-1 title-border text-uppercase mb-30">Đơn hàng của tôi</h4>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th><strong>Sản phẩm</strong></th>
                                                                <th class="text-right"><strong>Thành tiền</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($cartItems)
                                                                @foreach ($cartItems as $item)
                                                                    <tr>
                                                                        <td
                                                                            style="display: flex;gap: 5px;align-items: center; ">
                                                                            <img style="width: 10%;"
                                                                                src="{{ $item['image'] }}" alt="">
                                                                            {{ $item['name'] }} x {{ $item['quantity'] }}
                                                                        </td>
                                                                        <td class="text-right" style="white-space: nowrap">
                                                                            {{ number_format($item['total_price'], 0, ',', '.') . ' VNĐ' }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <p>Giỏ hàng đang chưa có sản phẩm nào</p>
                                                            @endif

                                                            
                                                            <tr>
                                                                <td>Giảm giá</td>
                                                                <td class="text-right" id="text-discount" style="white-space: nowrap">
                                                                    {{ number_format(session('discount', 0), 0, ',', '.') . ' VNĐ' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Phí vận chuyển</td>
                                                                <td class="text-right" style="white-space: nowrap">
                                                                    {{ number_format($shipping, 0, ',', '.') . ' VNĐ' }}</td>
                                                            </tr>
                                                            @if (!session()->has('coupon_id'))
                                                                <tr>
                                                                    <td >
                                                                        <label for="discount_code" style="white-space: nowrap">Mã giảm giá (nếu có)</label>
                                                                        <input class="border" type="text" id="discount_code" name="discount_code" style="width: 100%;" placeholder="Nhập mã giảm giá">
                                                                    </td>
                                                                    <td>
                                                                        <button class="border p-2 text-white" id="button-coupon" style="background-color:#434343;" type="button">Áp dụng</button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td>Tổng đơn hàng</td>
                                                                <td class="text-right" style="white-space: nowrap"
                                                                    name="total_amount" id="total_amount">
                                                                    {{ number_format($newTotal, 0, ',', '.') . ' VNĐ' }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                                <div class="payment-method mt-60 pl-20">
                                                    <h4 class="title-1 title-border text-uppercase mb-30">Phương thức thanh
                                                        toán</h4>
            
                                                    <div class="form-group">
                                                        <select name="payment_method" class="form-control"
                                                            id="payment_method">
                                                            <option value="">Chọn hình thức thanh toán</option>
                                                            @foreach ($payment as $pay)
                                                                <option value="{{ $pay->id }}">{{ $pay->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div id="recipient_payment_method_error" class="text-danger error-message" style="display: none;"></div>

                                                    </div>
                                                    <button class="submit-button button-one mt-15 col-12"
                                                        data-text="Thanh Toán" type="submit">Thanh
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
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const selectedProvince = provinceSelect.selectedOptions[0];
                const provinceId = selectedProvince ? selectedProvince.dataset.id : ''; // Lấy ID từ data-id
                const formattedProvinceId = provinceId.padStart(2,
                '0'); // Đảm bảo provinceId có ít nhất 2 chữ số





                // Xóa tất cả tùy chọn trong citySelect và wardSelect
                citySelect.innerHTML = '<option value = "" >Quận / Huyện</option>';
                wardSelect.innerHTML = '<option value = "" >Xã / Phường</option>';

                if (province) {
                    // Gọi API để lấy danh sách thành phố dựa vào tỉnh
                    fetch('{{ route('selectProvince') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                province: formattedProvinceId,
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            data.citys.forEach(city => {
                                const option = document.createElement('option');
                                option.dataset.id = city.macity;
                                option.value = city.name;
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
                const selectedCity = citySelect.selectedOptions[0]; // Lấy tùy chọn đã chọn
                const cityId = selectedCity ? selectedCity.dataset.id : ''; // Lấy ID từ data-id
                const fomatCityId = cityId.padStart(3, '0');
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
                                city: fomatCityId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            data.wards.forEach(ward => {
                                const option = document.createElement('option');
                                option.dataset.id = ward.phuongid;
                                option.value = ward.name;
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

            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach((message) => message.style.display = 'none' );

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
                        'Accept': 'application/json', // Thêm dòng này
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        recipient_name: recipient_name,
                        recipient_email: recipient_email,
                        phone_number: phone_number,
                        province: province,
                        city: city,
                        ward: ward,
                        address_order: address_order,
                        payment_method: payment_method,
                    }),
                })
                .then(response => {
                    if(!response.ok){
                        return response.json();
                    }
                    return response.json(); // Nếu phản hồi thành công, tiếp tục với dữ liệu JSON
                })
                .then(data => {

                    // xử lí lỗi
                      // Kiểm tra nếu có lỗi
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            console.log(field);
                            
                            const errorElement = document.getElementById(`recipient_${field}_error`);
                            if (errorElement) {
                                errorElement.innerText = data.errors[field][0];
                                errorElement.style.display = 'block';
                            }else{
                                errorElement.style.display = 'none';
                            }
                        });
                        Swal.fire({
                            title: 'Đặt hàng thất bại',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else if (data.vnpay) {
                        // Nếu có đường dẫn vnpay, chuyển hướng đến đó
                        window.location.href = data.vnpay;
                    } else if (data.momo) {
                        // Nếu có đường dẫn momo, chuyển hướng đến đó
                        window.location.href = data.momo;
                    } else {
                        // Nếu không có lỗi, đặt hàng thành công
                        Swal.fire({
                            title: 'Đặt hàng thành công!',
                            text: 'Đơn hàng của bạn đã được tạo thành công.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            setTimeout(() => {
                                window.location.href = '{{ route('thankyou') }}';
                            }, 3000);
                        });
                    }

            
                })
                .catch(error => {
                    
                        // Xử lý các lỗi khác
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Đặt hàng thất bại',
                            text: 'Đã có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    
                });
        });
    </script>   

    {{-- mã giảm giá trong trang thanh toán--}}
    <script>
        document.addEventListener('DOMContentLoaded',function(){

            function formatPrice(price) {
                // Chuyển giá trị thành chuỗi và loại bỏ các ký tự không phải là số
                let formattedPrice = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                // Thêm đuôi "VNĐ"
                return formattedPrice + " VNĐ";
            }

            document.getElementById('button-coupon').addEventListener('click',function(){
                var coupon = document.getElementById('discount_code').value;

                if (coupon) {
                    // Gửi mã giảm giá đến backend thông qua AJAX
                    fetch('{{ route('applyCoupon') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                code: coupon
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Cập nhật thông báo và tổng tiền sau giảm giá
                                document.getElementById('text-discount').textContent = formatPrice(data.discount);
                                document.getElementById('total_amount').textContent = formatPrice(data.new_total); 
                                location.reload();

                            } else {
                                // Hiển thị lỗi nếu mã giảm giá không hợp lệ
                                // document.getElementById('couponCode').value = '';
                                // coupon_message.textContent = data.error;
                                // coupon_message.classList.remove('text-success');
                                // coupon_message.classList.add('text-danger');
                                // coupon_message.style.display = 'block';
                                alert('Lỗi');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    console.error('Vui lòng nhập mã giảm giá');
                }
            });
        });

        
    </script>
@endpush
