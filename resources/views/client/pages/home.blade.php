@extends('client.components.default')

@push('styles')
    <style>
        .post-title a {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Banner Video Container */
        .banner-video-area {
            background-image: url('img/banner/banner-video.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
            height: 400px;
            /* Cố định chiều cao cho banner */
        }

        /* Content trong banner */
        .banner-video-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            width: 100%;
            max-width: 80%;
            z-index: 1;
        }

        /* Nút Play */
        .play-button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 60px;
            color: white;
        }

        /* Tiêu đề */
        .banner-title {
            margin-top: 20px;
            font-size: 32px;
            font-weight: bold;
            color: white;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
        }

        /* Mô tả */
        .banner-description {
            margin-top: 10px;
            font-size: 18px;
            color: white;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6);
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
                                        <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}"><img
                                                src="{{ $pr->image }}" alt="" /></a>
                                        <div class="product-action clearfix">
                                            <a href=""><form action="{{ route('wishlist.add', $pr->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="wishlist-action"
                                                    title="Thêm vào wishlist">
                                                    <i class="zmdi zmdi-favorite-outline"></i>
                                                </button>
                                            </form></a>
                                            
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                                title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                        </div>
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
    <!-- PRODUCT-AREA END -->

    <div class="banner-video">
        <div class="container">
            <div class="banner-video-area">
                <div class="banner-video-content">
                    <!-- Nút Play -->
                    <button class="play-button" data-bs-toggle="modal" data-bs-target="#videoModal">
                        <i class="zmdi zmdi-play-circle"></i>
                    </button>
                    <!-- Title -->
                    <h2 class="banner-title">Khám Phá Video Sản Phẩm</h2>
                    <p class="banner-description">Hãy nhấn vào để xem chi tiết</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Nike Shoes Ad Motion Graphics: A Visual Masterpiece</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/G02E6LaZLYU?si=oZ1dsWynbpxddMaw"
                            title="Nike Shoes Ad Motion Graphics: A Visual Masterpiece" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- PURCHASE-ONLINE-AREA START -->
    <div class="purchase-online-area pt-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title-border">Sản phẩm phổ biến</h2>
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

                    // Khai báo biến đường dẫn trong Blade
                    const getDetailProductUrl = '{{ route('getDetailProduct', ['slug' => '__slug__']) }}';

                    response.forEach(function(product) {
                        // Thay thế __slug__ bằng slug của sản phẩm hiện tại
                        const productUrl = getDetailProductUrl.replace('__slug__', product.slug);
                        html += `
                            <div class="single-product col-xl-3 col-md-4 col-12">
                                <div class="product-img">
                                    <span class="pro-label new-label">new</span>
                                    <a href="${productUrl}">
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
                                    </div>
                                </div>
                                <div class="product-info clearfix">
                                    <div class="fix">
                                        <h4 class="post-title floatleft">
                                            <a href="${productUrl}">${product.name}</a>
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
    <script>
        // Tắt video khi modal đóng
        var videoModal = document.getElementById('videoModal');
        videoModal.addEventListener('hidden.bs.modal', function () {
            var iframe = videoModal.querySelector('iframe');
            iframe.src = iframe.src;  // Reset src để dừng video
        });
    </script>
    
@endpush
