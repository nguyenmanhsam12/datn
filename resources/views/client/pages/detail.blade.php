@extends('client.components.default')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <style>
        .post-title a {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        input[type="text"] {
            background: #f6f6f6;
            border: medium none;
        }

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


        .cart__plus-minus {
            border: 1px solid #999;
            border-radius: 5px;
            width: 25%;
        }

        /* comment */
        .pro-reviewer img {
            border-radius: 50%;
            border: 1px solid #6c757d;
        }

        .flash-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            /* Màu xanh cho thành công */
            color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            display: none;
        }

        .flash-message.error {
            background-color: #dc3545;
            /* Màu đỏ cho lỗi */
        }
        form button i{
            color: #666;
        }
        form button i:hover{
            color: #d63384;
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
                            <div class="product-stock mb-3">

                            </div>

                            <!-- Size start -->
                            <div class="size-filter single-pro-size mb-35 clearfix">
                                <ul>
                                    <li><span class="color-title text-capitalize p-1">size :</span></li>
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
                                <button class="submit-button button-one btn__addCart icon-group" data-text="Thêm giỏ hàng">
                                    Thêm Giỏ Hàng
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
                            <li class="nav-item"><button class="nav-link active" data-bs-target="#description"
                                    data-bs-toggle="tab">Mô tả</button></li>
                            <li class="nav-item"><button class="nav-link " data-bs-target="#reviews"
                                    data-bs-toggle="tab">Đánh giá</button></li>
                        </ul>
                    </div>
                    <div class="col-md-9 col-12">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="description">
                                <div class="pro-tab-info pro-description">
                                    <h3 class="tab-title title-border mb-30">Mô tả sản phẩm</h3>
                                    <div>{!! $productDetail->description_text !!}</div>
                                </div>
                            </div>
                            <div class="tab-pane" id="reviews">
                                <div class="pro-tab-info pro-reviews">
                                    <div class="customer-review mb-60">
                                        <h3 class="tab-title title-border mb-30">Đánh giá của khách hàng</h3>
                                        <ul class="product-comments clearfix" id="reviews-list">
                                            @foreach ($reviews as $review)
                                                <!-- Hiển thị các đánh giá từ cơ sở dữ liệu -->
                                                <li class="mb-30">
                                                    <div class="pro-reviewer">
                                                        <img src="{{ asset('img/reviewer/1.webp') }}" alt="" />
                                                    </div>

                                                    <div class="pro-reviewer-comment">
                                                        <div class="fix">
                                                            <div class="floatleft mbl-center">
                                                                <h5 class="text-uppercase mb-0">
                                                                    <strong>{{ $review->user->name }}</strong></h5>
                                                                <p class="reply-date">
                                                                    {{ $review->created_at->format('d M, Y \a\t H:i') }}
                                                                </p>
                                                            </div>
                                                            <div class="comment-reply floatright">
                                                                <!-- Optional Reply / Delete Buttons -->
                                                                @if (auth()->id() == $review->user_id)
                                                                    <!-- Nếu là người dùng đang đăng nhập -->
                                                                    <form method="POST"
                                                                        action="{{ route('deleteReview', $review->id) }}"
                                                                        class="delete-review-form" style="display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn-delete"
                                                                            title="Xóa đánh giá">
                                                                            <i class="zmdi zmdi-close"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="stars">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="zmdi {{ $i <= $review->rating ? 'zmdi-star' : 'zmdi-star-outline' }}"></i>
                                                            @endfor
                                                        </div>
                                                        <p class="mb-0">{{ $review->message }}</p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- Phần tử thông báo -->
                                    <div id="flash-message" style="display: none;" class="flash-message">
                                        <p id="flash-message-text"></p>
                                    </div>


                                    @if ($userHasPurchased)
                                        <div class="leave-review">
                                            <h3 class="tab-title title-border mb-30">Để lại đánh giá của bạn</h3>
                                            <div class="your-rating mb-30">
                                                <p class="mb-10"><strong>Đánh giá của bạn</strong></p>
                                                <span class="stars">
                                                    <a href="javascript:void(0);" class="star" data-star="1"><i
                                                            class="zmdi zmdi-star-outline"></i></a>
                                                    <a href="javascript:void(0);" class="star" data-star="2"><i
                                                            class="zmdi zmdi-star-outline"></i></a>
                                                    <a href="javascript:void(0);" class="star" data-star="3"><i
                                                            class="zmdi zmdi-star-outline"></i></a>
                                                    <a href="javascript:void(0);" class="star" data-star="4"><i
                                                            class="zmdi zmdi-star-outline"></i></a>
                                                    <a href="javascript:void(0);" class="star" data-star="5"><i
                                                            class="zmdi zmdi-star-outline"></i></a>
                                                </span>
                                            </div>
                                            <div class="reply-box">
                                                <form id="review-form" method="POST"
                                                    action="{{ route('submitReview', ['slug' => $product->slug]) }}">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="rating" id="rating" value="">
                                                    <!-- Giữ giá trị sao chọn -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p id="error-message" style="color: red; display: none;"></p>
                                                            <textarea class="custom-textarea" name="message" placeholder="Đánh giá của bạn..."></textarea>
                                                            <button type="submit" data-text="Gửi đánh giá"
                                                                class="button-one submit-button mt-20">Gửi đánh
                                                                giá</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                    @endif

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- single-product-tab end -->
            <!-- Related Products Start -->

            {{-- sản phẩm liên quan --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title-border">Sản phẩm liên quan</h2>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-12">
                    <div class="product-slider arrow-left-right">
                        <!-- Single-product start -->

                        @foreach ($relatedProduct as $pr)
                            <div class="single-product">
                                <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">
                                    <div class="product-img">
                                        <span class="pro-label new-label">new</span>
                                        <a class="pro-price-2">
                                            <button type="submit" class="wishlist-btn" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Wishlist" data-id="{{$pr->id}}">  
                                                    <i class="zmdi zmdi-favorite-outline"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}"><img
                                                src="{{ $pr->image }}" alt="" /></a>
                                    </div>
                                    <div class="product-info clearfix">
                                        <div class="fix">
                                            <h4 class="post-title floatleft"><a
                                                    href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">{{ $pr->name }}</a>
                                            </h4>
                                        </div>
                                        <div class="fix">
                                            <span
                                                class="pro-price floatleft">{{ number_format($pr->mainVariant->price, 0, ',', '.') . ' ' . 'VNĐ' }}</span>
                                            <span class="pro-rating floatright">
                                                <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            {{-- modal --}}
                        @endforeach

                        <!-- Single-product end -->

                    </div>
                </div>
            </div>

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
                            Echo.leave(`variant-update-${currentVariantId}`);
                        }

                        // Cập nhật variantId hiện tại
                        currentVariantId = variantId;


                        // khi đặt hàng sẽ lắng nghe sự kiện này
                        Echo.channel(`product-${currentVariantId}`)
                            .listen('ProductStockUpdated', (event) => {
                                // Cập nhật số lượng tồn kho nếu sự kiện trùng variant
                                if (event.variantId == currentVariantId) {
                                    stockElement.textContent = `Số lượng: ${event.stock}`;
                                    console.log(stockElement);
                                }
                            });
                        // cập nhập số lượng và giá trong trang quản trị
                        Echo.channel(`variant-update-${currentVariantId}`)
                            .listen('VariantUpdated',(event) => {
                                if (event.id == currentVariantId) {
                                    stockElement.textContent = `Số lượng: ${event.stock}`;
                                    updatePrice(event.price); // Cập nhật giá từ sự kiện
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

                        if (data.error) {
                            alert(data.error);
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
                                    window.location.href =
                                        "{{ route('shop') }}"; 
                                }
                            });
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
        $(document).ready(function() {
            // Xử lý sự kiện click khi chọn sao đánh giá
            $('.star').click(function() {
                var starValue = $(this).data('star');
                $('#rating').val(starValue); // Cập nhật giá trị hidden input rating
                // Cập nhật giao diện sao đã chọn
                $('.star').each(function(index) {
                    if (index < starValue) {
                        $(this).find('i').removeClass('zmdi-star-outline').addClass('zmdi-star');
                    } else {
                        $(this).find('i').removeClass('zmdi-star').addClass('zmdi-star-outline');
                    }
                });
            });

            $('#review-form').submit(function(e) {
                e.preventDefault(); // Ngừng hành động mặc định của form (tải lại trang)

                var form = $(this); // Lấy form hiện tại
                var url = form.attr('action'); // Lấy URL action của form
                var data = form.serialize(); // Lấy tất cả dữ liệu trong form

                        // **Validate phía client**
        var rating = $('#rating').val();
        var message = $('textarea[name="message"]').val().trim();
        var errorMessage = $('#error-message');

        if (!rating || rating < 1 || rating > 5) {
            errorMessage.text('Vui lòng chọn số sao hợp lệ (1 đến 5).').show();
            return;
        }

        if (!message || message.length =="") {
            errorMessage.text('Vui lòng nhập nội dung đánh giá.').show();
            return;
        }
        errorMessage.hide();



                // Gửi yêu cầu AJAX để gửi đánh giá
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data, // Dữ liệu gửi đi
                    success: function(response) {
                        if (response.status === 'success') {
                            // Hiển thị thông báo thành công
                            showFlashMessage(response.message, 'success');
                            // Làm sạch textarea sau khi gửi thành công
                            $('textarea[name="message"]').val('');
                            // Reset sao đánh giá
                            $('.star i').removeClass('zmdi-star').addClass('zmdi-star-outline');

                            // Thêm đánh giá mới vào danh sách
                            var newReview = `
                    <li class="mb-30" id="review-${response.id}">
                         <div class="pro-reviewer">
                                                        <img src="{{ asset('img/reviewer/1.webp') }}" alt="" />
                                                    </div>
                        <div class="pro-reviewer-comment">
                            <div class="fix">
                                <div class="floatleft mbl-center">
                                    <h5 class="text-uppercase mb-0"><strong>${response.user_name}</strong></h5>
                                    <p class="reply-date">${response.date}</p>
                                </div>
                                <div class="comment-reply floatright">
                                    
                                    <form method="POST" action="/delete-review/${response.id}" class="delete-review-form" style="display: inline;">
                                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                         
                                     <input type="hidden" name="_method" value="DELETE"> <!-- Dùng để báo Laravel đây là yêu cầu DELETE -->
                                        <button type="submit" class="btn-delete" title="Xóa đánh giá">
                                            <i class="zmdi zmdi-close"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="stars">
                                ${getStars(response.rating)}
                            </div>
                         <p class="mb-0">${response.review_message ? response.review_message : ''}</p>
                        </div>
                    </li>
                `;
                            // Thêm đánh giá mới vào đầu danh sách đánh giá
                            $('#reviews-list').prepend(newReview);

                            // Đăng ký lại sự kiện xóa cho form vừa được thêm
                            attachDeleteReviewHandler();
                        } else {
                            // Hiển thị thông báo lỗi
                            showFlashMessage(response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Hiển thị thông báo lỗi nếu có lỗi
                        showFlashMessage('Có lỗi xảy ra, vui lòng thử lại!', 'error');
                    }
                });
            });


            // Hàm hiển thị thông báo
            function showFlashMessage(message, type) {
                var flashMessage = $('#flash-message');
                var flashMessageText = $('#flash-message-text');

                flashMessageText.text(message);

                // Đặt màu sắc cho thông báo dựa trên loại (thành công hay lỗi)
                if (type === 'success') {
                    flashMessage.removeClass('error').addClass('success');
                } else {
                    flashMessage.removeClass('success').addClass('error');
                }

                // Hiển thị thông báo
                flashMessage.fadeIn();

                // Ẩn thông báo sau 3 giây
                setTimeout(function() {
                    flashMessage.fadeOut();
                }, 3000);
            }

            // Hàm để tạo sao đánh giá
            function getStars(rating) {
                var stars = '';
                for (var i = 1; i <= 5; i++) {
                    stars += i <= rating ? '<i class="zmdi zmdi-star"></i>' :
                        '<i class="zmdi zmdi-star-outline"></i>';
                }
                return stars;
            }
        });


        $(document).ready(function() {
            // Lắng nghe sự kiện submit của form xóa
            $('.delete-review-form').submit(function(e) {
                e.preventDefault(); // Ngừng hành động mặc định của form (tải lại trang)

                var form = $(this); // Lấy form hiện tại
                var url = form.attr('action'); // Lấy URL action của form

                // Gửi yêu cầu AJAX
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form.serialize(), // Lấy tất cả dữ liệu trong form
                    success: function(response) {
                        if (response.status === 'success') {
                            form.closest('li').remove(); // Xóa đánh giá từ danh sách hiển thị
                            alert('Đánh giá đã được xóa!');
                        } else {
                            alert('Có lỗi xảy ra khi xóa đánh giá!');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                });
            });
        });

        function attachDeleteReviewHandler() {
            $('.delete-review-form').off('submit').on('submit', function(e) {
                e.preventDefault(); // Ngừng hành động mặc định của form (tải lại trang)

                var form = $(this);
                var url = form.attr('action');

                // Gửi yêu cầu AJAX
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            form.closest('li').remove(); // Xóa đánh giá từ danh sách hiển thị
                            alert('Đánh giá đã được xóa!');
                        } else {
                            alert('Có lỗi xảy ra khi xóa đánh giá!');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi chi tiết: ", xhr.responseText);
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                });
            });
        }

        // Gọi hàm này sau khi DOM đã được tải
        $(document).ready(function() {
            attachDeleteReviewHandler();
        });
    </script>

    {{-- thêm yêu thích --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.wishlist-btn');

            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    const productId = button.getAttribute('data-id');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    // Gửi request bằng fetch
                    fetch('{{route('wishlist.store')}}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            // Hiển thị thông báo SweetAlert
                            Swal.fire({
                                title: 'Thành công!',
                                text: `Sản phẩm đã được thêm vào yêu thích.`,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Xem yêu thích',
                                cancelButtonText: 'Ở lại đây'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Điều hướng đến trang yêu thích
                                    window.location.href = '/wishlist';
                                }
                            });
                        } else if(data.error){
                            alert(data.error);
                        } 
                        else {
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Không thể thêm sản phẩm vào danh sách yêu thích.',
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi, vui lòng thử lại.',
                            icon: 'error'
                        });
                    });
                });
            });
        });

        // hàm để gắn vào sự kiện trong hàm loadproduct
        function initializeWishlistButtons() {
            const buttons = document.querySelectorAll('.wishlist-btn');

            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    const productId = button.getAttribute('data-id');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch('{{ route('wishlist.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Thành công!',
                                text: `Sản phẩm đã được thêm vào yêu thích.`,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Xem yêu thích',
                                cancelButtonText: 'Ở lại đây'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/wishlist';
                                }
                            });
                        } else if (data.error) {
                            alert(data.error);
                        } else {
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Không thể thêm sản phẩm vào danh sách yêu thích.',
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi, vui lòng thử lại.',
                            icon: 'error'
                        });
                    });
                });
            });
        }


    </script>
@endpush
