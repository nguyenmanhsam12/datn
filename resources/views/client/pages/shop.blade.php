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

    <div class="product-area pt-80 pb-80 product-style-2" style="background-color: rgba(245, 245, 245, 0.7); ">
        <div class="container">
            <div class="row flex-column-reverse flex-lg-row">
                <div class="col-lg-3">
                    <!-- Tìm kiếm -->
                    <aside class="widget widget-search mb-30">
                        <form action="{{ route('shop') }}" method="GET">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products here...">
                            <button type="submit"><i class="zmdi zmdi-search"></i></button>
                        </form>
                    </aside>

                    <!-- Lọc theo danh mục -->
                    <aside class="widget widget-categories mb-30">
                    <div class="p-3 bg-white shadow-sm rounded" style="height: 290px; overflow-y: auto;">
                        <div class="widget-title">
                            <h4>Danh Mục</h4>
                        </div>
                        <ul class="tab-menu nav treeview">
                            @foreach ($list_category as $cate)
                                <li class="nav-item expandable">
                                    <a class="nav-link {{ isset($categoryId) && $categoryId == $cate->id ? 'active' : '' }}"
                                        href="{{ route('shop.byCategory', $cate->id) }}">
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
                                <h4>Size</h4>
                            </div>
                            <div class="widget-info size-filter clearfix">
                                <ul>
                                    @foreach ($list_size as $size)
                                        <li>
                                            <a href="{{ route('shop', ['size' => $size->name, 'price' => request('price'), 'search' => request('search')]) }}">
                                                {{ $size->name }}
                                            </a>
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
                                <h4>Price Range</h4>
                            </div>
                            <div class="widget-info">
                                <form action="{{ route('shop') }}" method="GET">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Enter price range</label>
                                        <input type="text" id="price" name="price" value="{{ request('price') }}" placeholder="Ex:1000-1000000">
                                    </div>
                                    <button type="submit" class="btn btn-secondary w-100">Filter</button>
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
                                    @forelse ($list_product as $pr)
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="single-product">
                                                <div class="product-img">
                                                    <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">
                                                        <span class="pro-label new-label">new</span>
                                                        <img src="{{ $pr->image }}" alt="" />
                                                        <div class="product-action clearfix spor">
                                                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="product-info clearfix">
                                                    <h4>{{ $pr->name }}</h4>
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
                                    @empty
                                        <p class="text-center">Không có sản phẩm nào phù hợp với bộ lọc của bạn.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Pagination start -->
                        <div class="shop-pagination text-center">
                            <div class="pagination-wrapper pagination">
                                {{ $list_product->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        <!-- Pagination end -->
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
    </script>
@endpush
