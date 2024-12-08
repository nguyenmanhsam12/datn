@extends('client.components.default')

@push('styles')
    <style>
        .zmdi {
            line-height: 40px;
        }

        .post-title a {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Pagination */
        .pagination-wrapper .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .pagination-wrapper .pagination li {
            margin: 0 5px;
        }

        .pagination-wrapper .pagination li a,
        .pagination-wrapper .pagination li span {
            color: #333;
            font-size: 16px;
            padding: 0;
            /* Loại bỏ padding để thu nhỏ kích thước */
            width: 30px;
            height: 30px;
            line-height: 30px;
            /* Căn giữa số và mũi tên */
            text-align: center;
            display: inline-block;
            text-decoration: none;
            transition: color 0.3s;
            border-radius: 50%;
            /* Tạo hình tròn */
        }

        .pagination-wrapper .pagination li a:hover {
            color: #ff4d4d;
            /* Màu khi hover */
        }

        .pagination-wrapper .pagination .active span {
            color: #ff4d4d;
            /* Màu cho trang hiện tại */
            font-weight: bold;
            background-color: #ffffff;
        }

        .pagination-wrapper .pagination li:first-child a::before {
            content: '\2190';
            /* Mũi tên trái */
        }

        .pagination-wrapper .pagination li:last-child a::before {
            content: '\2192';
            /* Mũi tên phải */
        }

        .pagination-wrapper .pagination li a,
        .pagination-wrapper .pagination li span {
            border: none;
            /* Xóa đường viền */
            color: #333;
            font-weight: normal;
        }

        .pagination-wrapper .pagination li a:hover,
        .pagination-wrapper .pagination .active span {
            color: #ff4d4d;
            /* Màu cho nút hiện tại */
        }

        .spor {
            height: 30px;
            max-width: 200px;
            opacity: 0;
            visibility: hidden;
            display: flex;
            margin-right: 60px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            background-color: #fff;
            padding: 5px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.5s ease 0s;
            max-width: 90%;
        }

        .spor a {
            color: #333;
            font-size: 16px;
            /* Giảm kích thước biểu tượng */
            display: flex;
            align-items: center;
            position: relative;
        }

        .spor a:not(:last-child)::after {
            content: "";
            height: 16px;
            /* Giảm chiều cao của đường phân cách */
            background-color: #ddd;
            position: absolute;
            right: -5px;
            /* Giảm khoảng cách của đường phân cách */
        }

        /* Product */

        .product-info h4 {
            font-size: 18px;
            font-weight: 500;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }
        .product-info h4:hover {
        color: #e03550;
    }
        .product-img img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
            /* Thêm hiệu ứng hover */
        }

        .product-img img:hover {
            transform: scale(1.1);
        }

        /* Category */

        .widget-categories {
            margin-bottom: 30px;
        }

        .widget-categories .widget-title h4 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .widget-categories .treeview {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .widget-categories .treeview .nav-item {
            margin-bottom: 8px;
        }

        .widget-categories .treeview .nav-item a {
            display: block;
            text-decoration: none;
            color: #666666;
            padding: 8px 12px;
            border-radius: 4px;
            transition: all 0.3s;
        }

        .widget-categories .treeview .nav-item a:hover {
            color: #e03550;
            transform: scale(1.2);
        }

        .widget-categories .treeview .nav-item a::before {
            color: #e03550;
        }

        /* Size Filter */
        .size-filter ul li a {
            transition: all 0.3s ease;
            color: #555;
            font-size: 14px;
        }

        .size-filter ul li a:hover {
            transform: scale(1.2);
            font-size: 16px;
        }


        /* price Filter */
        .shop-filter .widget-info input[type="text"] {
            width: 100%;
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .shop-filter .widget-info input[type="text"]:focus {
            border-color: #e03550;
            box-shadow: 0 0 5px rgba(224, 53, 80, 0.5);
            outline: none;
        }
        .ui-slider-handle {
        border-radius: 50%;
    }

    .ui-slider-handle:hover {
        cursor: grab;
    }

    .ui-slider-handle:active {
        cursor: grabbing;
    }
        .tooltip-inner {
            max-width: 400px;
            white-space: normal;
            overflow-wrap: break-word;
            text-align: center;
        }

        .size-filter-link.active {
            color: #ffffff;
            background-color: #e03550;
            border-radius: 4px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .product-img .spor {
            opacity: 0;
            visibility: hidden;
            transform: translate(-50%, -50%) scale(0.8);
            transition: all 0.3s ease;
        }

        /* Hiện khi di chuột */
        .product-img:hover .spor {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -50%) scale(1);
        }

        .wishlist-btn.active {
            color: red;
            /* Màu đỏ khi nút được chọn */
        }

        #wishlist-notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            /* Màu nền tối hơn */
            color: #fff;
            /* Màu chữ trắng */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            /* Đổ bóng cho thông báo */
            z-index: 1000;
            text-align: center;
            font-size: 16px;
            max-width: 600px;
            display: none;
            height: 10px;
            animation: slideIn 0.5s ease-out;
            display: flex;
            /* Sử dụng flexbox để căn giữa nội dung */
            justify-content: space-between;
            /* Căn chỉnh nút và chữ */
            align-items: center;
            /* Căn giữa theo chiều dọc */
        }

        /* Hiệu ứng khi thông báo xuất hiện */
        @keyframes slideIn {
            0% {
                transform: translateX(-50%) translateY(30px);
                opacity: 0;
            }

            100% {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
            }
        }

        #wishlist-notification p {
            margin: 0;
            font-weight: bold;
            font-size: 16px;
            line-height: 1.4;
            flex-grow: 1;
            /* Đảm bảo chữ chiếm không gian còn lại */
        }

        #wishlist-notification a {
            background-color: #fff;
            color: #5e5e5e;
            /* Màu chữ của nút */
            padding: 2px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
            border: 2px solid #333;
            margin-left: 15px;
            height: 30px;
        }

        #wishlist-notification a:hover {
            background-color: #fd3939;
            /* Màu nền khi hover */
            color: #fff;
            /* Màu chữ khi hover */
        }

        #wishlist-notification a {
            transition: transform 0.3s ease;
        }

        #wishlist-notification a:hover {
            transform: translateX(5px);
            /* Chuyển động nút khi hover */
        }

        .list-view .single-product {
            display: flex;
            justify-content: space-between;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .list-view .product-img img {
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .list-view .product-details h4 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .list-view .product-details p {
            margin-bottom: 5px;
            color: #555;
            font-size: 0.95rem;
        }

        .list-view .product-actions button,
        .list-view .product-actions a {
            margin-right: 5px;
        }
        /* search */
    .widget.widget-search {
        border: 1px solid #f0f0f0;
        padding: 8px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .search-button {
        margin: 11px 11px ;
    }
    #search-input {
        width: 100%;
        padding: 10px 15px;
        border: none;
        outline: none;
    }

    #search-input:focus {
        outline: none;
        /* Đảm bảo không có viền khi focus */
        border-color: transparent;
        /* Tránh hiện viền focus */
    }

    /* Category */

    .widget-categories {
        margin-bottom: 30px;
    }

    .widget-categories .widget-title h4 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
    }

    .widget-categories .treeview {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .widget-categories .treeview .nav-item {
        margin-bottom: 8px;
    }

    .widget-categories .treeview .nav-item a {
        display: block;
        text-decoration: none;
        color: #666666;
        padding: 8px 12px;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .widget-categories .treeview .nav-item a:hover {
        color: #e03550;
        transform: scale(1.2);
    }

    .widget-categories .treeview .nav-item a.active-category {
        color: #e03550;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    /* xoá bộ lọc */
    #clear-filters {
        height: 40px;
    width: 262.5px; /* Chiều rộng của nút */
    color: #fff;
    background-color: #dc3545;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    cursor: pointer;
    text-align: center; /* Canh giữa chữ */
}

#clear-filters:hover {
    background-color: #c82333;
    transform: scale(1.05);
}

#clear-filters:active {
    transform: scale(0.95);
}
/* nút bấm hover */
.product-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 3px;
    }
    .product-action button,
    .product-action a {
        padding: 8px;
        transition: color 0.3s ease, transform 0.3s ease;
    }
    .product-action i {
        font-size: 1rem;
    }

    .product-action button:hover i,
    .product-action a:hover i {
        color: #e03550;
        transform: scale(1.2);
    }
    /* button list shop */
    .product-actions {
    display: flex;
    gap: 10px; /* Khoảng cách giữa các nút */
}

.product-actions .action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px; 
    height: 40px; /* Chiều cao cố định */
    border-radius: 8px; /* Bo góc nút */
    border: none;
    transition: all 0.3s ease; /* Hiệu ứng hover */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Đổ bóng */
}

.product-actions .btn-danger {
    background-color: #e03550; /* Màu nền nút */
    color: white;
}

.product-actions .btn-danger:hover {
    background-color: #b02a37; /* Màu nền khi hover */
    transform: scale(1.1); /* Phóng to khi hover */
}

.product-actions .btn-primary {
    background-color: #007bff; /* Màu nền nút */
    color: white;
}

.product-actions .btn-primary:hover {
    background-color: #0056b3; /* Màu nền khi hover */
    transform: scale(1.1); /* Phóng to khi hover */
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
                            <h2>Cửa Hàng</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="/">Trang Chủ</a></li>
                                <li><a href="/shop">Cửa Hàng</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-area pt-80 pb-80 product-style-2" style="background-color: rgba(245, 245, 245, 0.7);">

        <div class="container">
            <div class="row flex-column-reverse flex-lg-row">
                <div class="col-lg-3">
                    <!-- Tìm kiếm -->
                    <aside class="widget widget-search mb-30">
                        <form id="search-form" method="GET">
                            <input type="text" id="search-input" name="search" value="{{ request('search') }}"
                                placeholder="Search products here...">
                            <button type="submit" class="search-button">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                        </form>
                    </aside>

                    <!-- Lọc theo danh mục -->
                    <aside class="widget widget-categories mb-30">
                        <input type="hidden" id="categoryId" name="categoryId" value="">
                        <div class="p-3 bg-white shadow-sm rounded" style="height: 290px; overflow-y: auto;">
                            <div class="widget-title">
                                <h4>Category</h4>
                            </div>
                            <ul class="tab-menu nav treeview" style="justify-content:flex-start; padding-left:3px">
                                @foreach ($list_category as $cate)
                                    <li class="nav-item expandable">
                                        <a href="#" class="category-filter" data-id="{{ $cate->id }}">
                                            {{ $cate->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>

                    <!-- Lọc theo kích cỡ -->
                    <aside class="widget widget-size mb-30">
                        <div class="p-3 bg-white shadow-sm rounded" style="height: 290px; overflow-y: auto;">
                            <div class="widget-title">
                                <h4 style="color:#333">Size</h4>
                            </div>
                            <div class="widget-info size-filter clearfix">
                                <ul>
                                    @foreach ($list_size as $size)
                                        <li>
                                            <a href="#" class="size-filter-link"
                                                data-size="{{ $size->name }}">{{ $size->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </aside>
                    <!-- Lọc theo khoảng giá -->
                    <aside class="widget shop-filter mb-30">
                        <div class="p-3 bg-white shadow-sm rounded" style="height: 290px; overflow-y: auto;">
                            <div class="widget-title">
                                <h4>Price Range</h4>
                            </div>
                            <div class="widget-info">
                                <!-- Thanh trượt giá -->
                                <div id="price-range" style="width: 100%;"></div>

                                <!-- Hiển thị khoảng giá -->
                                <div class="d-flex justify-content-between mt-2">
                                    <span id="price-min">0</span>
                                    <span id="price-max">1000000</span>
                                </div>

                                <!-- Form filter giá, không cần nút filter -->
                                <input type="hidden" name="price" id="price-input">
                            </div>
                        </div>
                    </aside>
                    <a href="{{ route('shop') }}">
                        <div
                            class="shop-option mb-30 d-flex flex-column-reverse flex-sm-row justify-content-between align-items-center">
                            <button id="clear-filters" class="btn btn-danger">Xóa Bộ Lọc</button>
                        </div>
                    </a>

                </div>

                <div class="col-lg-9">
                    <div class="shop-content">
                        <div
                            class="product-option mb-30 d-flex flex-column-reverse flex-sm-row justify-content-between align-items-center">
                            <ul class="shop-tab nav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-target="#grid-view" data-bs-toggle="tab"
                                        aria-selected="true" role="tab">
                                        <i class="zmdi zmdi-view-module"></i>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-target="#list-view" data-bs-toggle="tab"
                                        aria-selected="false" role="tab" tabindex="-1">
                                        <i class="zmdi zmdi-view-list"></i>
                                    </button>
                                </li>
                            </ul>
                            <div class="showing text-end">
                                <p class="mb-0">Showing {{ $list_product->count() }} of {{ $list_product->total() }}
                                    results</p>
                            </div>
                        </div>
                        {{-- <div class="filter-title">
                            <h2>
                                @if (request('category_id'))
                                    Sản phẩm theo danh mục: {{ $list_category->find(request('category_id'))->name }}
                                @elseif(request('size'))
                                    Sản phẩm theo kích cỡ: {{ implode(', ', request('size')) }}
                                @elseif(request('price'))
                                    Sản phẩm theo khoảng giá: {{ request('price') }}
                                @elseif(request('search'))
                                    Kết quả tìm kiếm cho: "{{ request('search') }}"
                                @else
                                    Tất cả sản phẩm
                                @endif
                            </h2>
                        </div> --}}
                        <div class="tab-content">
                            <div class="tab-pane active show" id="grid-view" role="tabpanel">
                                <div class="row" id="product-list">
                                    @foreach ($list_product as $pr)
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="single-product">
                                                <div class="product-img">
                                                    <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">
                                                        <span class="pro-label new-label">new</span>
                                                        <img src="{{ $pr->image }}" alt="{{ $pr->image }}" />
                                                        <div class="product-action clearfix spor">
                                                            <form action="{{ route('wishlist.store') }}" method="POST"
                                                                class="wishlist-form">
                                                                @csrf
                                                                <input type="hidden" name="product_id"
                                                                    value="{{ $pr->id }}">
                                                                <button type="submit" class="btn-link wishlist-btn"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Wishlist">
                                                                    <i class="zmdi zmdi-favorite-outline"></i>
                                                                </button>
                                                            </form>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#productModal" title="Quick View">
                                                                <i class="zmdi zmdi-zoom-in"></i>
                                                            </a>
                                                            <a href="#" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Compare">
                                                                <i class="zmdi zmdi-refresh"></i>
                                                            </a>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="product-info clearfix">
                                                    <h4 data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="{{ $pr->name }}">{{ $pr->name }}</h4>
                                                    <span>{{ number_format(optional($pr->mainVariant)->price, 0, ',', '.') . ' VNĐ' }}</span>
                                                </div>
                                                <div class="clearfix">
                                                    <div class="pro-rating floatright">
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Pagination start -->
                                <div class="shop-pagination text-center">
                                    <div class="pagination-wrapper pagination">
                                        {{ $list_product->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                                <!-- Pagination end -->
                            </div>
                            <div class="tab-pane" id="list-view" role="tabpanel">
                                <div class="list-view" id="list-view-products">
                                    @foreach ($list_product as $pr)
                                        <div
                                            class="single-product d-flex align-items-center mb-3 p-3 bg-white shadow-sm rounded">
                                            <div class="product-img me-3">
                                                <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">
                                                    <img src="{{ $pr->image }}" alt="{{ $pr->name }}"
                                                        style="width: 120px; height: 120px;">
                                                </a>
                                            </div>
                                            <div class="product-details flex-grow-1">
                                                <h4><a
                                                        href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">{{ $pr->name }}</a>
                                                </h4>
                                                <p class="product-price mb-2">
                                                    {{ number_format(optional($pr->mainVariant)->price, 0, ',', '.') . ' VNĐ' }}
                                                </p>
                                                <p class="product-description">{{ Str::limit($pr->description, 120) }}</p>
                                            </div>
                                            <div class="product-actions">
                                                <form action="{{ route('wishlist.store') }}" method="POST"
                                                    class="wishlist-form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $pr->id }}">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm me-2"
                                                        title="Add to Wishlist">
                                                        <i class="zmdi zmdi-favorite-outline"></i>
                                                    </button>
                                                </form>
                                                <a href="#" class="btn btn-outline-primary btn-sm"
                                                    title="Quick View">
                                                    <i class="zmdi zmdi-zoom-in"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="wishlist-notification" class="wishlist-notification" style="display: none;">
        <p>Sản phẩm đã được thêm vào danh sách yêu thích.</p>
        <a href="#" id="view-wishlist-btn" class="btn btn-primary">Xem</a>
    </div>
@endsection


@push('script')
    <script>
        function add_wishlist(id) {
            // var formdata = new FormData()
            var data = {
                "_token": "{{ csrf_token() }}",
                "product_id": id
            }
            $.ajax({
                url: '{{ route('wishlist.store') }}',
                method: 'POST',
                data: data,
                success: function(response) {
                    // Hiển thị thông báo
                    $('#wishlist-notification').fadeIn();

                    // Khi người dùng nhấn "Xem", điều hướng đến wishlist
                    $('#view-wishlist-btn').on('click', function() {
                        window.location.href = response
                            .redirect_to_wishlist; // Điều hướng đến trang wishlist
                    });

                    // Thay đổi màu sắc của nút yêu thích
                    button.addClass('active'); // Thêm lớp 'active' để thay đổi màu

                    // Ẩn thông báo sau 5 giây
                    setTimeout(function() {
                        $('#wishlist-notification').fadeOut();
                    }, 5000);
                },
                error: function(response) {
                    // Hiển thị thông báo lỗi
                    alert(response.responseJSON.message);
                }
            });
        }
        $(document).ready(function() {
            // Khởi tạo thanh trượt giá
            $('#price-range').slider({
                range: true,
                min: 0,
                max: 1000000, // Điều chỉnh giá trị tối đa
                values: [0, 1000000], // Giá trị mặc định
                slide: function(event, ui) {
                    // Cập nhật giá trị min và max hiển thị khi thay đổi
                    $('#price-min').text(ui.values[0]);
                    $('#price-max').text(ui.values[1]);
                    // Cập nhật giá trị cho input ẩn
                    $('#price-input').val(ui.values[0] + '-' + ui.values[1]);
                    // Gọi hàm lọc sản phẩm mỗi khi thay đổi giá trị khoảng giá
                    filterProducts();
                }
            });

            // Khi người dùng thay đổi giá trị tìm kiếm
            $('#search-input').on('keyup', function() {
                filterProducts(); // Gọi hàm lọc sản phẩm khi thay đổi tìm kiếm
            });

            // Khi người dùng chọn một mục trong danh mục
            $('.category-filter').on('click', function(e) {
                e.preventDefault(); // Ngừng hành động mặc định của thẻ <a>
                var categoryId = $(this).data('id');
                $('#categoryId').val(categoryId);
                filterProducts(); // Gọi hàm lọc sản phẩm khi chọn danh mục
            });

            // Khi người dùng chọn một kích cỡ
            $('.size-filter-link').on('click', function(e) {
                e.preventDefault();
                $('.size-filter-link').removeClass('active'); // Bỏ trạng thái active của các kích cỡ khác
                $(this).addClass(
                    'active'); // Toggle trạng thái "active" của thẻ <a> (chọn hoặc bỏ chọn kích cỡ)

                var selectedSizes = [];
                $('.size-filter-link.active').each(function() {
                    selectedSizes.push($(this).data('size'));
                });
                filterProducts(selectedSizes);
            });

            // Hàm lọc sản phẩm
            function filterProducts(selectedSizes = null) {
                var searchQuery = $('#search-input').val(); // Lấy từ khóa tìm kiếm
                var priceFilter = $('#price-input').val(); // Lấy giá trị khoảng giá
                var categoryId = $('#categoryId').val(); // Lấy giá trị của categoryId ẩn

                $.ajax({
                    url: "{{ route('shop') }}", // Địa chỉ xử lý tìm kiếm và lọc
                    method: 'GET',
                    data: {
                        search: searchQuery,
                        size: selectedSizes, // Gửi danh sách kích cỡ đã chọn
                        price: priceFilter, // Gửi khoảng giá đã chọn
                        category_id: categoryId // Gửi ID danh mục đã chọn
                    },
                    success: function(data) {
                        // Cập nhật lại danh sách sản phẩm
                        $('#product-list').html(data.products_html);
                        // Cập nhật phân trang
                        $('.pagination').html(data.pagination);
                    }
                });
            }


            // $('#clear-filters').on('click', function() {

            //     $('#search-input').val(''); 
            //     $('#categoryId').val(''); 
            //     $('#price-input').val(''); 
            //     $('#price-range').slider('values', [0, 1000000]); 
            //     $('#price-min').text(0); 
            //     $('#price-max').text(1000000); 
            //     $('.size-filter-link').removeClass('active'); 

            //     filterProducts();
            // });

            // Cập nhật phân trang khi người dùng nhấn vào phân trang
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function(data) {
                    $('#product-list').html(data.products_html);
                    $('.pagination').html(data.pagination);
                });
            });
        });

        $('.wishlist-form').on('submit', function(e) {
            e.preventDefault(); // Ngừng hành động mặc định của form

            var form = $(this);
            var button = form.find('button'); // Lấy nút yêu thích

            // Gửi yêu cầu AJAX
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // Hiển thị thông báo
                    $('#wishlist-notification').fadeIn();

                    // Khi người dùng nhấn "Xem", điều hướng đến wishlist
                    $('#view-wishlist-btn').on('click', function() {
                        window.location.href = response
                            .redirect_to_wishlist; // Điều hướng đến trang wishlist
                    });

                    // Thay đổi màu sắc của nút yêu thích
                    button.addClass('active'); // Thêm lớp 'active' để thay đổi màu

                    // Ẩn thông báo sau 5 giây
                    setTimeout(function() {
                        $('#wishlist-notification').fadeOut();
                    }, 5000);
                },
                error: function(response) {
                    // Hiển thị thông báo lỗi
                    alert(response.responseJSON.message);
                }
            });
        });
    </script>
@endpush
