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


    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


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

        /* Ẩn input tìm kiếm */
        /* Modal */
        .search-modal {
            display: none;
            position: fixed;
            top: -100px;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            transition: top 0.3s ease-in-out;
        }

        .search-modal-content {
            position: absolute;
            background-color: #fff;
            padding: 20px;
            width: 100%;
            max-width: 100%;
            height: auto;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #333;
            cursor: pointer;
        }

        .search-modal input {
            position: absolute;
            left: 40%;
            width: 400px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .search-modal-logo {
            position: absolute;
        }

        /* Kết quả tìm kiếm */
        #search-results {
            margin-top: 50px;
            /* Đảm bảo không đè lên ô input */
            padding-top: 10px;
            max-height: 200px;
            overflow-y: auto;
            text-align: center;
        }

        /* Mỗi kết quả tìm kiếm */
        #search-results div {
            position: relative;
            left: 40%;
            width: 400px;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #search-results div:hover {
            background-color: #f0f0f0;
        }

        /* dữ liệu tìm kiếm */
        .product-item {
    margin: 10px;
}

.product-link {
    text-decoration: none;
    color: inherit; /* Giữ nguyên màu chữ mặc định */
    display: flex;
    align-items: center; /* Căn giữa theo trục ngang */
}

.product-image {
    width: 100px;
    height: 100px;
    margin-right: 10px;
    object-fit: cover; /* Giữ tỉ lệ ảnh */
}

.product-name {
    font-size: 16px;
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

    <!--Start of Tawk.to Script-->
    <!--Start of Tawk.to Script-->
    {{-- <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/67509b222480f5b4f5a7d1f1/1ie9ds0jf';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script> --}}
    <!--End of Tawk.to Script-->
    <!--End of Tawk.to Script-->

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
            // const cartItemsContainer = document.querySelector('.all-cart-product');

            // tổng tiền
            // const cartTotalPriceElement = document.querySelector('.cart-totals .floatright');

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
    {{-- Chức năng tìm kiếm sản phẩm --}}
    <script>
        // Lấy các phần tử
        const searchIcon = document.getElementById('search-icon');
        const searchModal = document.getElementById('search-modal');
        const closeModal = document.getElementById('close-modal');

        // Khi nhấn vào biểu tượng tìm kiếm, hiển thị modal
        searchIcon.addEventListener('click', function() {
            searchModal.style.display = 'block';
            setTimeout(() => {
                searchModal.style.top = '0'; // Di chuyển modal xuống sau khi hiển thị
            }, 10);
        });

        // Khi nhấn vào nút đóng, ẩn modal
        closeModal.addEventListener('click', function() {
            searchModal.style.top = '-100px'; // Đẩy modal lên khỏi màn hình
            setTimeout(() => {
                searchModal.style.display = 'none'; // Ẩn modal sau khi chuyển đi
            }, 300); // Đảm bảo modal đã di chuyển lên trước khi ẩn
        });

        // Để đóng modal khi nhấn vào bất kỳ đâu ngoài modal
        window.addEventListener('click', function(event) {
            if (event.target === searchModal) {
                searchModal.style.top = '-100px';
                setTimeout(() => {
                    searchModal.style.display = 'none';
                }, 300);
            }
        });
        // Lấy các phần tử HTML cần thiết
        const searchInput = document.getElementById('search-input');
        const modal = document.getElementById('search-modal');
        const closeModalButton = document.getElementById('close-modal');
        
        // Hàm tìm kiếm sản phẩm
        function searchProducts(query) {
            fetch('{{ route('serachProduct') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Bảo mật CSRF
                },
                body: JSON.stringify({ query: query }) // Gửi query qua body
            })
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data); // Hiển thị kết quả tìm kiếm
            })
            .catch(error => console.error('Lỗi khi tìm kiếm sản phẩm:', error));
        }

        // Lắng nghe sự kiện nhập liệu trong ô tìm kiếm
        // Cập nhật sự kiện input với debounce
        searchInput.addEventListener(
            'input',
            debounce(function() {
                const searchQuery = searchInput.value;

                if (searchQuery === '') {
                    clearSearchResults(); // Xóa kết quả nếu input trống
                    return;
                }

                searchProducts(searchQuery); // Gọi API tìm kiếm với debounce
            }, 300) // Thời gian trì hoãn (ms)
        );

        // hàm xóa kết quả tìm kiếm khi không có đầu vào
        function clearSearchResults() {
            const resultContainer = document.getElementById('search-results');
            resultContainer.innerHTML = ""; // Xóa toàn bộ kết quả
        }

        // Hàm hiển thị kết quả tìm kiếm
        function displaySearchResults(results) {
            const resultContainer = document.getElementById('search-results');
            resultContainer.innerHTML = ""; // Xóa kết quả cũ

            results.forEach(product => {
                const getDetailProductUrl = '{{ route('getDetailProduct', ['slug' => '__slug__']) }}';
                const productElement = document.createElement('div');
                productElement.classList.add('product-item'); // Class cho CSS

                // Khai báo biến đường dẫn trong Blade
                const productUrl = getDetailProductUrl.replace('__slug__', product.slug);
                // Tạo thẻ <a> để bọc hình ảnh và tên sản phẩm
                const productLink = document.createElement('a');
                productLink.href = `${productUrl}`; // Đường dẫn đến trang chi tiết sản phẩm
                productLink.classList.add('product-link'); // Class cho thẻ <a>

                // Tạo phần tử hiển thị hình ảnh sản phẩm
                const productImage = document.createElement('img');
                productImage.src = product.image;
                productImage.alt = product.name;
                productImage.classList.add('product-image'); // Class cho ảnh

                // Tạo phần tử hiển thị tên sản phẩm
                const productName = document.createElement('p');
                productName.textContent = product.name;
                productName.classList.add('product-name'); // Class cho tên

                // Thêm hình ảnh và tên sản phẩm vào thẻ <a>
                productLink.appendChild(productImage);
                productLink.appendChild(productName);

                // Thêm thẻ <a> vào productElement
                productElement.appendChild(productLink);

                // Thêm productElement vào kết quả tìm kiếm
                resultContainer.appendChild(productElement);
            });
        }


        // Hàm debounce chung delay gõ kí tự
        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), delay);
            };
        }

        // Đóng modal khi nhấn vào nút đóng
        closeModalButton.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    </script>
    @stack('script')
</body>


</html>
