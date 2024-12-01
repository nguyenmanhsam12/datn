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
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
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
.search-modal-logo{
    position: absolute;
}
/* Kết quả tìm kiếm */
#search-results {
    margin-top: 50px; /* Đảm bảo không đè lên ô input */
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
    <script>
        // Lấy các phần tử
const searchIcon = document.getElementById('search-icon');
const searchModal = document.getElementById('search-modal');
const closeModal = document.getElementById('close-modal');

// Khi nhấn vào biểu tượng tìm kiếm, hiển thị modal
searchIcon.addEventListener('click', function () {
    searchModal.style.display = 'block';
    setTimeout(() => {
        searchModal.style.top = '0'; // Di chuyển modal xuống sau khi hiển thị
    }, 10);
});

// Khi nhấn vào nút đóng, ẩn modal
closeModal.addEventListener('click', function () {
    searchModal.style.top = '-100px'; // Đẩy modal lên khỏi màn hình
    setTimeout(() => {
        searchModal.style.display = 'none'; // Ẩn modal sau khi chuyển đi
    }, 300); // Đảm bảo modal đã di chuyển lên trước khi ẩn
});

// Để đóng modal khi nhấn vào bất kỳ đâu ngoài modal
window.addEventListener('click', function (event) {
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

// Dữ liệu sản phẩm (có thể lấy từ API hoặc một mảng cố định như trên)
const products = [
    { id: 1, name: "Bản phẩm 1", price: 100 },
    { id: 2, name: "Bản phẩm 2", price: 200 },
    { id: 3, name: "Sản phẩm 3", price: 300 },
    { id: 4, name: "Sản phẩm 4", price: 400 },
    { id: 5, name: "Sản phẩm 5", price: 100 },
    { id: 6, name: "Sản phẩm 6", price: 200 },
    { id: 7, name: "Sản phẩm 7", price: 300 },
    { id: 8, name: "Sản phẩm 8", price: 400 },
    { id: 9, name: "Sản phẩm 9", price: 100 },
    { id: 10, name: "Sản phẩm 10", price: 200 },
    { id: 11, name: "Sản phẩm 11", price: 300 },
    { id: 12, name: "Sản phẩm 12", price: 400 },
    { id: 13, name: "Sản phẩm 13", price: 100 },
    { id: 14, name: "Sản phẩm 14", price: 200 },
    { id: 15, name: "Sản phẩm 15", price: 300 },
    { id: 16, name: "Sản phẩm 16", price: 400 },
];

// Hàm tìm kiếm sản phẩm
function searchProducts(query) {
    return products.filter(product => product.name.toLowerCase().includes(query.toLowerCase()));
}

// Lắng nghe sự kiện nhập liệu trong ô tìm kiếm
searchInput.addEventListener('input', function () {
    const searchQuery = searchInput.value;
    const result = searchProducts(searchQuery);

    // Hiển thị kết quả tìm kiếm
    console.log(result); // Bạn có thể hiển thị kết quả tìm kiếm ở đây (trong console, hoặc tạo danh sách HTML)
    // Ví dụ, bạn có thể tạo các sản phẩm tìm thấy vào một div hoặc danh sách
    displaySearchResults(result);
});

// Hàm hiển thị kết quả tìm kiếm
function displaySearchResults(results) {
    // Giả sử bạn muốn hiển thị kết quả dưới input
    const resultContainer = document.getElementById('search-results');
    resultContainer.innerHTML = ""; // Xóa kết quả cũ
    results.forEach(product => {
        const productElement = document.createElement('div');
        productElement.textContent = `${product.name} - ${product.price} VNĐ`;
        resultContainer.appendChild(productElement);
    });
}

// Đóng modal khi nhấn vào nút đóng
closeModalButton.addEventListener('click', function () {
    modal.style.display = 'none';
});

    </script>
    @stack('script')
</body>


</html>
