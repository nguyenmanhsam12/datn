@extends('client.components.default')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <style>
        .size-option {
            display: inline-block;
            width: 100px;
            height: 60px;
            line-height: 60px;
            text-align: center;
            border: 2px solid #ddd;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .size-option:hover {
            background-color: #f0f0f0;
            color: #E03550 !important;
            /* Màu nền khi hover */
        }

        .size-option.active {
            background-color: #E03550;
            /* Màu nền khi ô được chọn */
            color: white !important;
            /* Màu chữ khi ô được chọn */
        }

        .size-option.active:hover {
            background-color: #f0f0f0;
            /* Màu nền khi ô được chọn */
            color: #E03550 !important;
            /* Màu chữ khi ô được chọn */
        }

        .btn__1 {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        /* Đặt các style chung cho button */
        .btn__addCart {
            display: flex;
            align-items: center;
            gap: 8px;
            height: 40px;
            border: 1px solid #6c757d;
            background-color: transparent;
            color: #6c757d;
            cursor: pointer;
            border-radius: 5px;
        }

        .icon-group__icon {
            font-size: 20px;

        }

        .btn__addCart:hover {
            color: ##fff;
            border-color: ##fff;
        }

        .btn__addCart:hover .icon-group__icon {
            color: ##fff;

        }

        .cart__plus-minus {
            border: 1px solid #999;
            border-radius: 5px;
            width: 25%;
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
                            <h2>Chi tiết sản phẩm</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li>Chi tiết sản phẩm</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- PRODUCT-AREA START -->
    <div class="product-area single-pro-area pt-80 pb-80 product-style-2">
        <div class="container">
            <div class="row shop-list single-pro-info no-sidebar">
                <!-- Single-product start -->
                <div class="col-12">
                    <div class="single-product clearfix">
                        <!-- Single-pro-slider Big-photo start -->
                        <div class="single-pro-slider single-big-photo view-lightbox slider-for">
                            @foreach ($productDetail->gallary as $key => $gala)
                                <div>
                                    <img src="{{ asset($gala) }}" alt="" />
                                    <a class="view-full-screen" href="{{ asset($gala) }}" data-lightbox="roadtrip"
                                        data-title="My caption">
                                        <i class="zmdi zmdi-zoom-in"></i>
                                    </a>
                                </div>
                            @endforeach

                        </div>
                        <!-- Single-pro-slider Big-photo end -->
                        <div class="product-info">
                            <div class="fix">
                                <h4 class="post-title floatleft">{{ $productDetail->name }}</h4>
                            </div>
                            <div class="fix mb-20">
                                <span class="pro-price">{{ number_format($minPrice, 0, ',', '.') . ' VNĐ' }}</span>
                            </div>
                            <div class="product-description">
                                <p>{!! $productDetail->description !!}</p>
                            </div>
                            <div class="product-stock">

                            </div>

                            <!-- Size start -->
                            <div class="size-filter single-pro-size mb-35 clearfix">
                                <ul>
                                    <li><span class="color-title text-capitalize p-1">size</span></li>
                                    @foreach ($productDetail->variants as $variant)
                                        <li>
                                            <a href="#" class="size-option p-1" data-variant-id="{{ $variant->id }}"
                                                data-price = "{{ $variant->price }}" data-stock = "{{ $variant->stock }}">
                                                {{ $variant->size->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- Size end -->
                            <div class="clearfix btn__1">
                                <div class="cart-plus-minus cart__plus-minus">
                                    <input type="text" value="1" min="1" name="qtybutton"
                                        class="cart-plus-minus-box">
                                </div>
                                <button class="btn btn-outline-secondary btn__addCart icon-group">
                                    <i class="zmdi zmdi-shopping-cart-plus icon-group__icon"></i>
                                    <span class="btn__title">ADD TO CART</span>
                                </button>
                            </div>
                            <!-- Single-pro-slider Small-photo start -->
                            <div class="single-pro-slider single-sml-photo slider-nav">
                                @foreach ($productDetail->gallary as $item)
                                    <div>
                                        <img src="{{ asset($item) }}" alt="{{ $productDetail->name }}" />
                                    </div>
                                @endforeach

                            </div>
                            <!-- Single-pro-slider Small-photo end -->
                        </div>
                    </div>
                </div>
                <!-- Single-product end -->
            </div>

            <!-- single-product-tab start -->
            <div class="single-pro-tab">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <!-- Nav tabs -->
                        <ul class="single-pro-tab-menu  nav">
                            <li class="nav-item"><button class="nav-link" data-bs-target="#description"
                                    data-bs-toggle="tab">Mô tả</button></li>
                            <li class="nav-item"><button class="nav-link active" data-bs-target="#reviews"
                                    data-bs-toggle="tab">Đánh giá</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-target="#information"
                                    data-bs-toggle="tab">Thông tin</button></li>

                        </ul>
                    </div>
                    <div class="col-md-9 col-12">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane" id="description">
                                <div class="pro-tab-info pro-description">
                                    <h3 class="tab-title title-border mb-30">dummy Product name</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas
                                        elese ifend. Phasellus a felis at est bibendum feugiat ut eget eni Praesent et
                                        messages in con sectetur posuere dolor non.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas
                                        elese ifend. Phasellus a felis at est bibendum feugiat ut eget eni Praesent et
                                        messages in con sectetur posuere dolor non.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas
                                        elese ifend. Phasellus a felis at est bibendum feugiat ut eget eni Praesent et
                                        messages in con sectetur posuere dolor non.</p>
                                </div>
                            </div>
                            <div class="tab-pane active" id="reviews">
                                <div class="pro-tab-info pro-reviews">
                                    <div class="customer-review mb-60">
                                        <h3 class="tab-title title-border mb-30">Đánh giá của khách hàng</h3>
                                        <ul class="product-comments clearfix">
                                            <li class="mb-30">
                                                <div class="pro-reviewer">
                                                    <img src="{{ asset('img/reviewer/1.webp') }}" alt="" />
                                                </div>
                                                <div class="pro-reviewer-comment">
                                                    <div class="fix">
                                                        <div class="floatleft mbl-center">
                                                            <h5 class="text-uppercase mb-0"><strong>Gerald Barnes</strong>
                                                            </h5>
                                                            <p class="reply-date">27 Jun, 2022 at 2:30pm</p>
                                                        </div>
                                                        <div class="comment-reply floatright">
                                                            <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                                                            <a href="#"><i class="zmdi zmdi-close"></i></a>
                                                        </div>
                                                    </div>
                                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                        elit. Integer accumsan egestas elese ifend. Phasellus a felis at est
                                                        bibendum feugiat ut eget eni Praesent et messages in con sectetur
                                                        posuere dolor non.</p>
                                                </div>
                                            </li>
                                            <li class="threaded-comments">
                                                <div class="pro-reviewer">
                                                    <img src="{{ asset('img/reviewer/2.webp') }}" alt="" />
                                                </div>
                                                <div class="pro-reviewer-comment">
                                                    <div class="fix">
                                                        <div class="floatleft mbl-center">
                                                            <h5 class="text-uppercase mb-0"><strong>Jane Doe</strong></h5>
                                                            <p class="reply-date">28 Jun, 2022 at 3:45pm</p>
                                                        </div>
                                                        <div class="comment-reply floatright">
                                                            <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                                                            <a href="#"><i class="zmdi zmdi-close"></i></a>
                                                        </div>
                                                    </div>
                                                    <p class="mb-0">Phasellus a felis at est bibendum feugiat ut eget
                                                        eni. Praesent et messages in consectetur posuere dolor non.</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="leave-review">
                                        <h3 class="tab-title title-border mb-30">Để lại đánh giá của bạn</h3>
                                        <div class="your-rating mb-30">
                                            <p class="mb-10"><strong>Đánh giá của bạn</strong></p>
                                            <span>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                            </span>
                                            <span class="separator">|</span>
                                            <span>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                            </span>
                                            <span class="separator">|</span>
                                            <span>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                            </span>
                                            <span class="separator">|</span>
                                            <span>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                            </span>
                                            <span class="separator">|</span>
                                            <span>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                            </span>
                                        </div>
                                        <div class="reply-box">
                                            <form method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" placeholder="Tên của bạn..." name="name"
                                                            required />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" placeholder="Chủ đề..." name="subject"
                                                            required />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <textarea class="custom-textarea" name="message" placeholder="Đánh giá của bạn..." required></textarea>
                                                        <button type="submit" class="button-one submit-button mt-20">Gửi
                                                            đánh giá</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="information">
                                <div class="pro-tab-info pro-information">
                                    <h3 class="tab-title title-border mb-30">Product information</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas
                                        elese ifend. Phasellus a felis at est bibendum feugiat ut eget eni Praesent et
                                        messages in con sectetur posuere dolor non.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas
                                        elese ifend. Phasellus a felis at est bibendum feugiat ut eget eni Praesent et
                                        messages in con sectetur posuere dolor non.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas
                                        elese ifend. Phasellus a felis at est bibendum feugiat ut eget eni Praesent et
                                        messages in con sectetur posuere dolor non.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- single-product-tab end -->
            <!-- Related Products Start -->


        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy tất cả các nút size
            const sizeOptions = document.querySelectorAll('.size-option');
            const priceElement = document.querySelector('.pro-price');
            const stockElement = document.querySelector('.product-stock');

            // Biến lưu variantId hiện tại để tránh đăng ký kênh lặp
            let currentVariantId = null;

            // Kiểm tra sự tồn tại của sizeOptions và priceElement
            if (!sizeOptions.length || !priceElement) {
                return; // Dừng lại nếu không có phần tử nào
            }

            // Hàm format giá tiền sang định dạng VND
            function formatPrice(price) {
                return new Intl.NumberFormat('vi-VN').format(price) + ' VNĐ';
            }

            // Hàm cập nhật giá tiền
            function updatePrice(price) {
                priceElement.textContent = formatPrice(price);
            }

            // Hàm xử lý khi click vào size
            function handleSizeClick(e) {
                e.preventDefault();

                // Xóa active class từ tất cả các nút
                sizeOptions.forEach(option => {
                    option.classList.remove('active');
                });

                // Thêm active class vào nút được click
                this.classList.add('active');

                // Lấy giá từ data attribute và cập nhật
                const price = this.getAttribute('data-price');
                updatePrice(price);
                const stock = this.getAttribute('data-stock');
                stockElement.textContent = `Số lượng : ${stock}`
                const variantId = this.getAttribute('data-variant-id');

                // Kiểm tra nếu có variantId và xử lý lắng nghe sự kiện
                if (variantId) {
                    // Nếu variantId thay đổi, hủy đăng ký kênh cũ và đăng ký kênh mới
                    if (currentVariantId !== variantId) {
                        // Hủy kênh cũ nếu đã đăng ký
                        if (currentVariantId) {
                            Echo.leave(`product-${currentVariantId}`);
                        }

                        // Cập nhật variantId hiện tại
                        currentVariantId = variantId;
                        

                        // Đăng ký kênh mới để lắng nghe sự kiện
                        Echo.channel(`product-${currentVariantId}`)
                            .listen('ProductStockUpdated', (event) => {
                                console.log('Stock update received: ', event);

                                // Cập nhật số lượng tồn kho nếu sự kiện trùng variant
                                if (event.variantId == currentVariantId) {
                                    stockElement.textContent = `Số lượng: ${event.stock}`;
                                    console.log(stockElement);
                                }
                            });
                    }
                }


            }

            // Thêm event listener cho tất cả các nút size
            sizeOptions.forEach(option => {
                option.addEventListener('click', handleSizeClick);
            });

        });
    </script>   

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButton = document.querySelector('.btn__addCart');
            const quantityInput = document.querySelector('input[name="qtybutton"]');
            const cartCountElement = document.querySelector('.cart-count'); // Phần tử hiển thị số lượng sản phẩm

            // Cấu hình Toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };


            addToCartButton.addEventListener('click', function(e) {

                e.preventDefault();
                const selectedOption = document.querySelector('.size-option.active');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                if (!selectedOption) {
                    alert('Vui lòng chọn size sản phẩm.');
                    return;
                }

                const variantId = selectedOption.getAttribute('data-variant-id');
                const quantity = parseInt(quantityInput.value);
                if (quantity < 1) {
                    alert('Số lượng phải lớn hơn 0');
                    return;
                }


                fetch("{{ route('addToCart') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({
                            variant_id: variantId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {

                        console.log(data);


                        if (data.error) {
                            toastr.error(data.error); // Hiển thị lỗi yêu cầu đăng nhập bằng toastr
                            return;
                        }

                        if (data.message) {
                            Swal.fire({
                                title: 'Thêm vào giỏ hàng thành công!',
                                text: data.message,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Đi đến giỏ hàng',
                                cancelButtonText: 'Xem tiếp sản phẩm'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Điều hướng đến giỏ hàng
                                    window.location.href =
                                        "{{ route('cart') }}"; // Đường dẫn đến giỏ hàng
                                } else {
                                    // Người dùng chọn xem tiếp sản phẩm
                                    console.log('Người dùng chọn xem tiếp sản phẩm');
                                }
                            });
                            // Cập nhật số lượng sản phẩm trên thanh header
                            // Cập nhật số lượng sản phẩm trên thanh header bằng dữ liệu từ server
                            if (data.cartItemCount !== undefined) {
                                cartCountElement.textContent = data.cartItemCount;
                            }
                        }

                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                    });
            });
        });
    </script>

    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            // Lắng nghe sự kiện từ kênh 'product-{id}'
            const stockElement = document.querySelector('.product-stock');
            const variantId = stockElement.getAttribute('data-variant-id'); // Lấy variantId của sản phẩm hiện tại

            if (variantId) {
                Echo.channel(`product-${variantId}`)
                    .listen('ProductStockUpdated', (event) => {
                        console.log('Stock update received: ', event);

                        // Cập nhật số lượng tồn kho
                        stockElement.textContent = `Số lượng: ${event.stock}`;
                    });
            }
        });
    </script>
@endpush
