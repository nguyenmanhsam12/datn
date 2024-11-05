@extends('client.components.default')

@push('styles')
    <style>
        .post-title a{
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    @include('client.components.slider')

    <div class="product-area pt-80 pb-35">
        <div class="container">
            <!-- Section-title start -->
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title-border">Sẩn phẩm mới nhất</h2>
                    </div>
                </div>
            </div>
            <!-- Section-title end -->
            <div class="row ">
                <div class="col-12">
                    <div class="product-slider arrow-left-right">
                        <!-- Single-product start -->

                        @foreach ($list_product as $pr)
                            <div class="single-product">
                                <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">
                                    <div class="product-img">
                                        <span class="pro-label new-label">new</span>
                                        <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}"><img src="{{ $pr->image }}" alt="" /></a>
                                        <div class="product-action clearfix">
                                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                                title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Add To Cart"><i class="zmdi zmdi-shopping-cart-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-info clearfix">
                                        <div class="fix">
                                            <h4 class="post-title floatleft"><a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">{{ $pr->name }}</a></h4>
                                        </div>
                                        <div class="fix">
                                            <span class="pro-price floatleft">{{ number_format($pr->mainVariant->price,0,',','.').' '.'VNĐ' }}</span>
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
                        @endforeach

                        <!-- Single-product end -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT-AREA END -->



    <!-- PURCHASE-ONLINE-AREA START -->
    <div class="purchase-online-area pt-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title-border">Sản phẩm</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <!-- Nav tabs -->
                    <ul class="tab-menu nav">
                        @foreach ($list_category as $cate)
                            <li class="nav-item">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    data-category-id="{{ $cate->id }}" onclick="loadProducts({{ $cate->id }})"
                                    data-bs-toggle="tab">{{ $cate->name }}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-12">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="new-arrivals">
                            <div class="row" id="product-list">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PURCHASE-ONLINE-AREA END -->
    <!-- BLGO-AREA START -->
    <div class="blog-area pt-55 pb-80">
        <div class="container">
            <!-- Section-title start -->
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title-border">From The Blog</h2>
                    </div>
                </div>
            </div>
            <!-- Section-title end -->
            <div class="row">
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mt-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/1.webp" alt="" /></a>
                        </div>
                        <div class="blog-info">
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Sweet Street Life 2022</a>
                                    </h4>
                                </div>
                            </div>
                            <div class="like-share fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum alteratio available, but the majority
                                have suffered If you are going to use a passage Lorem Ipsum, you alteration in some form.
                            </p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mt-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/2.webp" alt="" /></a>
                        </div>
                        <div class="blog-info">
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Designer`s look 2022</a>
                                    </h4>
                                </div>
                            </div>
                            <div class="like-share fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>45 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>56 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>27 Share</span></a>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum alteratio available, but the majority
                                have suffered If you are going to use a passage Lorem Ipsum, you alteration in some form.
                            </p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mt-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/3.webp" alt="" /></a>
                        </div>
                        <div class="blog-info">
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Fashion drawing 2022</a>
                                    </h4>
                                </div>
                            </div>
                            <div class="like-share fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>78 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>25 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>43 Share</span></a>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum alteratio available, but the majority
                                have suffered If you are going to use a passage Lorem Ipsum, you alteration in some form.
                            </p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
            </div>
        </div>
    </div>
    <!-- BLGO-AREA END -->
@endsection

@push('script')
    <script>
        // Hàm để định dạng giá tiền
        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price) + ' VNĐ';
        }

        // Hàm load sản phẩm
        function loadProducts(categoryId) {
            // Active tab tương ứng
            $('.tab-menu .nav-link').removeClass('active');
            $(`.tab-menu .nav-link[data-category-id="${categoryId}"]`).addClass('active');

            $.ajax({
                url: '/getProductsByCategory/' + categoryId,
                type: 'GET',
                beforeSend: function() {
                    $('#product-list').html('<div class="text-center">Loading...</div>');
                },
                success: function(response) {
                    let html = '';

                    response.forEach(function(product) {
                        html += `
                            <div class="single-product col-xl-3 col-md-4 col-12">
                                <div class="product-img">
                                    <span class="pro-label new-label">new</span>
                                    <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">
                                        <img src="${product.image}" alt="" />
                                    </a>
                                    <div class="product-action clearfix">
                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <i class="zmdi zmdi-favorite-outline"></i>
                                        </a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View">
                                            <i class="zmdi zmdi-zoom-in"></i>
                                        </a>
                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <i class="zmdi zmdi-refresh"></i>
                                        </a>
                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Cart">
                                            <i class="zmdi zmdi-shopping-cart-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-info clearfix">
                                    <div class="fix">
                                        <h4 class="post-title floatleft">
                                            <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">${product.name}</a>
                                        </h4>
                                    </div>
                                    <div class="fix">
                                        <span class="pro-price floatleft">${formatPrice(product.main_variant.price)}</span>
                                        <span class="pro-rating floatright">
                                            <a href="#"><i class="zmdi zmdi-star"></i></a>
                                            <a href="#"><i class="zmdi zmdi-star"></i></a>
                                            <a href="#"><i class="zmdi zmdi-star"></i></a>
                                            <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                            <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    $('#product-list').html(html);

                    // Khởi tạo lại tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#product-list').html(
                        '<div class="alert alert-danger">Có lỗi xảy ra khi tải sản phẩm</div>');
                }
            });
        }

        // Khi document ready
        $(document).ready(function() {
            // Lấy category_id của tab đầu tiên
            const firstCategoryId = $('.tab-menu .nav-link.active').data('category-id');

            // Load sản phẩm của category đầu tiên
            loadProducts(firstCategoryId);

            // Khởi tạo tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush

