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
            text-align: center
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
        h2{
            color: black
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
                            <h2>Sản phẩm yêu thích</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="/">Trang Chủ</a></li>
                                <li><a href="/wishlist">Yêu thích</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-area pt-80 pb-80 product-style-2" style="background-color: rgba(245, 245, 245, 0.7);">
        <div class="container">
            <div class="row">
                <h2>Danh sách sản phẩm yêu thích</h2>
                <div class="shop-content">
                    @if ($wishlists->count() > 0)
                        <p>Bạn có {{ $wishlists->count() }} sản phẩm yêu thích</p>
                        <div class="tab-content">
                            <div class="tab-pane active show" id="grid-view" role="tabpanel">
                                <div class="row" id="product-list">
                                    @foreach ($wishlists as $wishlist)
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="single-product ">
                                                <div class="product-img">
                                                    <a
                                                        href="{{ route('getDetailProduct', ['slug' => $wishlist->product->slug]) }}">
                                                        <img src="{{ $wishlist->product->image }}"
                                                            alt="{{ $wishlist->product->name }}" />
                                                        <div class="product-action clearfix spor">

                                                            <form action="{{ route('wishlist.remove', $wishlist->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn-remove-wishlist" data-wishlist-id="{{ $wishlist->id }}" data-url="{{ route('wishlist.remove', $wishlist->id) }}">
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
                                                    <h4>{{ $wishlist->product->name }}</h4>
                                                    <span>{{ number_format(optional($wishlist->product->mainVariant)->price, 0, ',', '.') . ' VNĐ' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="shop-pagination text-center">
                                    <div class="pagination-wrapper pagination">
                                        {{ $wishlists->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p>Không có sản phẩm trong danh sách yêu thích.</p>
                    @endif
                </div>
            </div>

            <!-- Thêm danh sách sản phẩm bán chạy -->
            <div class="row mt-5">
                <div class="col-12">
                    <h2>Các sản phẩm có lẽ bạn sẽ thích</h2>
                </div>
                @foreach ($topSellingProducts as $product)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{ route('getDetailProduct', ['slug' => $product->slug]) }}">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" />
                                    <div class="product-action clearfix spor">
                                        <form action="{{ route('wishlist.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <!-- Corrected here -->
                                            <button type="button" class="btn-add-wishlist" data-product-id="{{ $product->id }}" data-url="{{ route('wishlist.add') }}">
                                                <i class="zmdi zmdi-favorite-outline"></i>
                                            </button>
                                        </form>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                            title="Quick View">
                                            <i class="zmdi zmdi-zoom-in"></i>
                                        </a>
                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <i class="zmdi zmdi-refresh"></i>
                                        </a>
                                    </div>
                                </a>
                            </div>
                            <div class="product-info clearfix">
                                <h4>{{ $product->name }}</h4>
                                <span>{{ number_format(optional($product->mainVariant)->price, 0, ',', '.') . ' VNĐ' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@push('script')
<script>
$(document).on('click', '.btn-add-wishlist', function (e) {
    e.preventDefault();
    const button = $(this);
    const productId = button.data('product-id');
    const url = button.data('url');

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            product_id: productId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('.shop-content').html(response.html); // Cập nhật phần shop-content
        },
        error: function () {
            console.error('Có lỗi xảy ra!');
        }
    });
});

$(document).on('click', '.btn-remove-wishlist', function (e) {
    e.preventDefault();
    const button = $(this);
    const wishlistId = button.data('wishlist-id');
    const url = button.data('url');

    $.ajax({
        url: url,
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('.shop-content').html(response.html); // Cập nhật phần shop-content
        },
        error: function () {
            console.error('Có lỗi xảy ra!');
        }
    });
});



</script>
@endpush