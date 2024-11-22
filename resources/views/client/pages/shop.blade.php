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

    /* search */
    .widget.widget-search {
        border: 1px solid #f0f0f0;
        padding: 8px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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
        transform: scale(1.05);

    }


    .product-img img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
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

    .widget-categories .treeview .nav-item a.active-category {
        color: #e03550;
        /* Màu đỏ */
        font-weight: bold;
        transition: all 0.3s ease;
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

    .size-filter-link.active {
        color: #e03550;
        /* Màu đỏ */
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

    .tooltip-inner {
        max-width: 400px;
        white-space: normal;
        overflow-wrap: break-word;
        text-align: center;
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
                            <li><a href="#">Trang Chủ</a></li>
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
                    <form id="search-form">
                        <input type="text" id="search-input" name="search" value="{{ request('search') }}" placeholder="Search products here...">
                        <button type="submit" style="display: none;"><i class="zmdi zmdi-search"></i></button>
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
                                    <a href="#" class="size-filter-link" data-size="{{ $size->name }}">{{ $size->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </aside>

                <!-- Lọc theo giá -->
                <aside class="widget shop-filter mb-30">
                    <div class="p-3 bg-white shadow-sm rounded" style="height: 290px; overflow-y: auto;">
                        <div class="widget-title">
                            <h4 style="color:#333">Price Range</h4>
                        </div>
                        <div class="widget-info">
                            <form action="javascript:void(0);">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Enter price range</label>
                                    <input type="text" id="price" name="price" value="{{ request('price') }}" placeholder="Ex:1000-1000000">
                                </div>
                            </form>
                        </div>
                    </div>
                </aside>
            </div>

            <div class="col-lg-9">
                <div class="shop-content">
                    <div class="product-option mb-30 d-flex flex-column-reverse flex-sm-row justify-content-between align-items-center">
                        <ul class="shop-tab nav" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-target="#grid-view" data-bs-toggle="tab" aria-selected="true" role="tab">
                                    <i class="zmdi zmdi-view-module"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-target="#list-view" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                    <i class="zmdi zmdi-view-list"></i>
                                </button>
                            </li>
                        </ul>
                        <div class="showing text-end">
                            <p class="mb-0">Showing {{ $list_product->count() }} of {{ $list_product->total() }} results</p>
                        </div>
                    </div>

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
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="product-info clearfix">
                                            <h4 data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $pr->name }}">{{ $pr->name }}</h4>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
<script>
    // Lấy tất cả các phần tử có class "product-img"
    const productImages = document.querySelectorAll('.product-img');

    // Thêm sự kiện di chuột vào từng phần tử
    productImages.forEach(image => {
        const productAction = image.querySelector('.product-action');

        image.addEventListener('mouseenter', () => {
            productAction.style.opacity = '1';
            productAction.style.visibility = 'visible';
        });

        image.addEventListener('mouseleave', () => {
            productAction.style.opacity = '0';
            productAction.style.visibility = 'hidden';
        });
    });

    $(document).ready(function() {
        // Khi người dùng thay đổi giá trị tìm kiếm
        $('.category-filter').on('click', function(e) {
            e.preventDefault(); // Ngừng hành động mặc định của thẻ <a>

            // Xóa class active-category khỏi tất cả danh mục
            $('.category-filter').removeClass('active-category');

            // Thêm class active-category vào danh mục vừa được chọn
            $(this).addClass('active-category');

            // Lấy ID danh mục từ data-id
            var categoryId = $(this).data('id');

            // Cập nhật giá trị của input ẩn categoryId
            $('#categoryId').val(categoryId);

            // Gọi hàm lọc sản phẩm
            filterProducts();
        });

        // Khi người dùng chọn một kích cỡ
        $('.size-filter-link').on('click', function(e) {
            e.preventDefault();
            $('.size-filter-link').removeClass('active');
            // Toggle trạng thái "active" của thẻ <a> (chọn hoặc bỏ chọn kích cỡ)
            $(this).addClass('active');

            // Lấy danh sách các kích cỡ đã được chọn (từ các thẻ <a> có class "active")
            var selectedSizes = $(this).data('size');;

            // Gọi hàm lọc sản phẩm
            filterProducts(selectedSizes);
        });

        // Khi người dùng nhập khoảng giá
        $('#price').on('keyup', function() {
            filterProducts();
        });

        // Hàm lọc sản phẩm
        function filterProducts(selectedSizes = null) {
            var searchQuery = $('#search-input').val();
            var priceFilter = $('#price').val();
            var categoryId = $('#categoryId').val(); // Lấy giá trị của categoryId ẩn

            $.ajax({
                url: "{{ route('shop') }}", // Địa chỉ xử lý tìm kiếm và lọc
                method: 'GET',
                data: {
                    search: searchQuery,
                    size: selectedSizes, // Gửi danh sách kích cỡ đã chọn
                    price: priceFilter,
                    category_id: categoryId
                },
                success: function(data) {
                    // Cập nhật lại danh sách sản phẩm
                    $('#product-list').html(data.products_html);

                    // Cập nhật phân trang
                    $('.pagination').html(data.pagination);
                }
            });
        }
    });
    //ajax phân trang
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        // Lấy URL từ phân trang
        var url = $(this).attr('href');

        // Lấy dữ liệu hiện tại để gửi kèm phân trang
        var searchQuery = $('#search-input').val();
        var priceFilter = $('#price').val();
        var categoryId = $('#categoryId').val();
        var selectedSizes = $('.size-filter-link.active').data('size');

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                search: searchQuery,
                size: selectedSizes,
                price: priceFilter,
                category_id: categoryId
            },
            success: function(data) {
                // Cập nhật danh sách sản phẩm
                $('#product-list').html(data.products_html);

                // Cập nhật phân trang
                $('.pagination').html(data.pagination);
            }
        });
    });
</script>

@endpush