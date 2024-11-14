<!doctype html>
<html class="no-js" lang="en">

<!-- Mirrored from htmldemo.net/latest/latest/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Oct 2024 06:35:18 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home one || Latest</title>
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- all css here -->
    <!-- bootstrap v3.3.6 css -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <!-- jquery-ui.min css -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="{{ asset('css/meanmenu.min.css') }}">
    <!-- owl carousel css -->
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <!-- slick css -->
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <!-- lightbox css -->
    <link rel="stylesheet" href="{{ asset('css/lightbox.min.css') }}">
    <!-- material-design-iconic-font css -->
    <link rel="stylesheet" href="{{ asset('css/material-design-iconic-font.css') }}">
    <!-- All common css of theme -->
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <!-- shortcode css -->
    <link rel="stylesheet" href="{{ asset('css/shortcode.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <!-- modernizr css -->
    <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
    

    <!-- slick css -->
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/js/bootstrap.js'])

    <style>
        .all-cart-product {
            display: flex;
            flex-direction: column;
        }

        .single-cart {
            display: flex;
            /* Sử dụng flexbox để sắp xếp hàng ngang */
            margin-bottom: 15px;
            /* Khoảng cách giữa các sản phẩm */
            align-items: center;
            /* Căn giữa theo chiều dọc */
        }

        .cart-photo {
            flex: 0 0 auto;
            /* Không cho phần ảnh co lại */
            margin-right: 15px;
            /* Khoảng cách giữa ảnh và thông tin */
        }

        .cart-info {
            flex: 1;
            /* Chiếm không gian còn lại */
        }

        .cart-info h5 {
            margin: 0;
            /* Xóa khoảng cách mặc định */
            white-space: nowrap;
            /* Không cho tên sản phẩm xuống dòng */
            overflow: hidden;
            /* Ẩn phần thừa ra ngoài */
            text-overflow: ellipsis;
            /* Hiển thị dấu '...' nếu tên quá dài */
        }

        .cart-info p {
            margin: 5px 0;
            /* Khoảng cách giữa các đoạn văn bản */
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- WRAPPER START -->
    <div class="wrapper">
        <!-- HEADER-AREA START -->

        @include('client.components.header')

        <!-- HEADER-AREA END -->

        @yield('content')

        <!-- FOOTER START -->
        @include('client.components.footer')
        <!-- FOOTER END -->
        <!-- QUICKVIEW PRODUCT -->

        @include('client.components.quickview')
        <!-- END QUICKVIEW PRODUCT -->

    </div>

    <!-- jquery latest version -->
    <script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- jquery.meanmenu js -->
    <script src="{{ asset('js/jquery.meanmenu.js') }}"></script>
    <!-- slick.min js -->
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <!-- jquery.treeview js -->
    <script src="{{ asset('js/jquery.treeview.js') }}"></script>
    <!-- lightbox.min js -->
    <script src="{{ asset('js/lightbox.min.js') }}"></script>
    <!-- jquery-ui js -->
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <!-- owl.carousel js -->
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <!-- jquery.nicescroll.min js -->
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <!-- countdon.min js -->
    <script src="{{ asset('js/countdon.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <!-- plugins js -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Hàm định dạng tiền tệ
            function formatCurrency(amount) {
                const formatted = Math.floor(amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                return `${formatted} VNĐ`;
            }

            // tổng số lượng trong giỏ hàng
            const cartCountElement = document.querySelector('.cart-count');

            // thông tin sp trong giỏ hàng
            const cartItemsContainer = document.querySelector('.all-cart-product');

            // tổng tiền
            const cartTotalPriceElement = document.querySelector('.cart-totals .floatright');

            // Gọi API để cập nhật số lượng sản phẩm nếu cần
            fetch("{{ route('getCartItemCount') }}")
                .then(response => response.json())
                .then(data => {

                    if (data.totalItems !== undefined) {
                        cartCountElement.textContent = data.totalItems;
                    }
                    // Cập nhật tổng giá tiền
                    if (data.totalPrice !== undefined) {
                        cartTotalPriceElement.textContent = formatCurrency(data.totalPrice);
                    }

                    // Hiển thị danh sách sản phẩm
                    if (data.cartItems && Array.isArray(data.cartItems)) {
                        cartItemsContainer.innerHTML = ''; // Xóa nội dung cũ
                        data.cartItems.forEach(item => {
                            const productElement = `
                        <div class="single-cart clearfix">
                            <div class="cart-photo">
                                <a href="#"><img src="${item.image}" alt="${item.name}" /></a>
                            </div>
                            <div class="cart-info">
                                <h5><a href="#">${item.name}</a></h5>
                                <p class="mb-0">Price: ${formatCurrency(item.price)}</p>
                                <p class="mb-0">Qty: ${item.quantity}</p>
                                <span class="cart-delete">
                                    <a href="#" data-product-id="${item.id}">
                                        <i class="zmdi zmdi-close"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    `;
                            cartItemsContainer.insertAdjacentHTML('beforeend', productElement);
                        });
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi tải số lượng sản phẩm:', error);
                });
        });
    </script>
    @stack('script')
</body>

<!-- Mirrored from htmldemo.net/latest/latest/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Oct 2024 06:35:35 GMT -->

</html>
