@extends('client.components.default')

@push('styles')
    <style>
        input[type="text"] {
            background: #f6f6f6;
            border: medium none;
        }
        .post-title a {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .shop-list .product-action {
            margin: 0 0 20px 0;
           
        }
        form button i{
            color: #666;
        }
        form button i:hover{
            color: #d63384;
        }
        .widget-title h4 {
        padding: 0;
        }
        .widget-info.product-cat {
            /* background: #fff; */
            height: 150px;
            /* padding: 15px 20px 20px 10px; */
        }

        .active-link {
            color: red;              /* Màu chữ khi active */
        }

    </style>

      {{-- bộ lọc giá tiền --}}
      <style>
        .widget.shop-filter {
            background: #ffffff;
            padding: 20px;
            border: 1px solid #eaeaea;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .widget-title h4 {
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
            font-weight: 600;
            border-bottom: 2px solid #d63384;
            display: inline-block;
        }
        .price_slider_amount {
            margin-top: 20px;
            text-align: center;
        }
        .filter-price-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        .filter-price-form label {
            font-size: 14px;
            color: #555;
        }
     .filter-price-form input#amount {
                width: auto; /* Tự điều chỉnh theo nội dung */
                min-width: 150px; /* Đặt độ rộng tối thiểu */
                max-width: 100%; /* Giới hạn độ rộng tối đa */
                padding: 5px 10px;
                text-align: center;
                font-size: 14px;
                color: #333;
                white-space: nowrap; /* Ngăn xuống dòng */
                overflow: hidden; /* Ẩn phần thừa nếu quá dài */
                text-overflow: ellipsis; /* Thêm dấu "..." nếu nội dung quá dài */
        }
        .filter-price-form .filter-button {
            background-color: #d63384;
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .filter-price-form .filter-button:hover {
            background-color: #c12771;
        }
        #slider-range {
            margin-top: 15px;
            height: 8px;
            background-color: #ddd;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
        }
        .ui-slider-range {
            background-color: #d63384;
        }
        .ui-slider-handle {
            background-color: #fff;
            border: 2px solid #d63384;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            top: -6px;
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

    <div class="product-area pt-80 pb-80 product-style-2">
        <div class="container">
            <div class="row flex-column-reverse flex-lg-row">
                <div class="col-lg-3">
                    <!-- Danh mục start -->
                    <aside class="widget widget-categories  mb-30">
                        <div class="widget-title">
                            <h4>Danh mục</h4>
                        </div>
                        <div id=""  class="widget-info product-cat boxscrol2">
                            <ul>
                                <li>
                                    <ul>
                                        @foreach ($list_category as $cate)
                                            <li><a class="
                                                @if($cate->id == $category->id) 
                                                    active-link
                                                @endif
                                                " 
                                            href="{{ route('products.category',['slug'=>$cate->slug])}}"
                                                
                                            >{{ $cate->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li> 
                                
                            </ul>
                        </div>
                    </aside>
                    <!-- end -->
                    <!-- Thương Hiệu start -->
                    <aside class="widget   ">
                        <div class="widget-title">
                            <h4>Thương Hiệu</h4>
                        </div>
                        <div id=""  class="widget-info product-cat boxscrol2">
                            <ul>
                                <li>
                                    <ul>
                                        @foreach ($list_brand as $brand)
                                            <li><a href="{{ route('products.brand',['slug'=>$brand->slug]) }}">{{$brand->name}}</a></li>
                                        @endforeach
                                        
                                    </ul>
                                </li>          
                            </ul>
                        </div>
                    </aside>
                    <!-- end -->
                    <!-- lọc giá start -->
                    <aside class="widget shop-filter mb-30">
                        <div class="widget-title">
                            <h4>Lọc theo giá</h4>
                        </div>
                        <div class="widget-info">
                            <div class="price_filter">
                                <div class="price_slider_amount">
                                    <form class="filter-price-form"method="GET">
                                        
                                        <label for="amount">Khoảng giá:</label>
                                        <input type="text" id="amount" readonly style="border:0; background-color: #f0f0f0; font-weight: bold;"/>

                                        <input type="hidden"name="min_price" id="min_price">                            
                                        <input type="hidden"name="max_price" id="max_price">                            

                                        <button type="submit" class="btn btn-primary filter-button">Lọc</button>
                                    </form>
                                </div>
                                <div>
                                    <div id="slider-range"></div>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- end -->
                    <!-- Kích cỡ start -->
                    
                    <!-- end -->
                    <!-- banner start -->
                    <aside class="widget widget-banner mb-30">
                        <div class="widget-info widget-banner-img">
                            <a href="#"><img src="{{ asset('img/banner/5.webp') }}" alt="" /></a>
                        </div>
                    </aside>
                    <!--  end -->
                </div>
                <div class="col-lg-9">
                    <!-- Shop-Content End -->
                    <div class="shop-content">
                        <div class="product-option mb-30 d-flex flex-column-reverse flex-sm-row justify-content-between align-items-center">
                            <!-- Nav tabs -->
                            <ul class="shop-tab nav">
                                <li class="nav-item"><button class="nav-link active" data-bs-target="#grid-view" data-bs-toggle="tab"><i class="zmdi zmdi-view-module"></i></button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-target="#list-view"  data-bs-toggle="tab"><i class="zmdi zmdi-view-list"></i></button></li>
                            </ul>
                            <div class="showing text-end">
                                <p class="mb-0">Hiển thị {{ $startItem }}-{{ $endItem }} trong số {{ $products->total() }} sản phẩm</p>
                            </div>
                        </div>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="grid-view">							
                                <div class="row">
                                    <!-- Single-product start -->
                                    @foreach($products as $key => $pr)
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="single-product border">
                                                <div class="product-img">
                                                    <span class="pro-label new-label">new</span>
                                                    <div action="" class=" pro-price-2">
                                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist"
                                                        class="add-to-wishlist" data-id="{{ $pr->id }}"><i class="zmdi zmdi-favorite-outline"></i></button>
                                                    </div>
                                                    <a href="single-product.html"><img src="{{ asset($pr->image) }}" alt="" /></a>
                                                </div>
                                                <div class="product-info clearfix ">
                                                    <div class="fix">
                                                        <h4 class="post-title"><a href="#">{{ $pr->name }}</a></h4>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <p class="pro-price">{{ number_format($pr->mainVariant->price,0,',','.')}} VNĐ</p>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- Single-product end -->
                                    
                                </div>
                            </div>
                            <div class="tab-pane" id="list-view">
                                <div class="row shop-list">
                                    <!-- Single-product start -->
                                    @foreach ($products as $pr)
                                        <div class="col-12"> 
                                            <div class="single-product clearfix">
                                                <div class="product-img">
                                                    <span class="pro-label new-label">new</span>
                                                    {{-- <a href="#" class="pro-price-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist"><i class="zmdi zmdi-favorite-outline "></i></a> --}}
                                                    <a href="single-product.html"><img src="{{ asset($pr->image) }}" alt="" /></a>
                                                </div>
                                                <div class="product-info">
                                                    <div class="fix">
                                                        <h4 class="post-title floatleft"><a href="#">{{ $pr->name }}</a></h4>
                                                        
                                                    </div>
                                                    <div class="fix mb-20">
                                                        <span class="pro-price">{{ number_format($pr->mainVariant->price,0,',','.')}}</span>
                                                    </div>
                                                 
                                                    <div class="product-description">
                                                        <p>{{ $pr->description }}</p>
                                                    </div>
                                                    <div class="fix">
                                                        <button class="submit-button button-one add-to-wishlist" data-id="{{$pr->id}}" data-text="Thêm Vào Yêu Thích">Thêm Vào yêu thích</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- Single-product end -->
                                </div>
                            </div>
                        </div>
                        <!-- Pagination start -->
                        <div class="shop-pagination text-center">
                            <div class="pagination">
                                <ul>
                                    <li>
                                        {{ $products->links() }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Pagination end -->
                    </div>
                    <!-- Shop-Content End -->
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.add-to-wishlist');

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

    </script>


    {{-- tạo bộ lọc --}}
    <script>
        $( function() {
            var minPrice = {{ $minPrice }};
            var maxPrice = {{ $maxPrice }};
            
        
            $('#min_price').val(minPrice);
            $('#max_price').val(maxPrice);

            $( "#slider-range" ).slider({
                range: true,
                min: minPrice,
                max: maxPrice,
                values: [ minPrice, maxPrice ],
                slide: function( event, ui ) {
                $( "#amount" ).val( "đ" + addPlus(ui.values[ 0 ].toString()) + " - đ" + addPlus(ui.values[1].toString()) );
                $('#min_price').val(ui.values[ 0 ]);
                $('#max_price').val(ui.values[ 1 ]);
                }
            });

        $( "#amount" ).val( "đ" + addPlus(minPrice.toString()) +
            " - đ" + addPlus(maxPrice.toString()));
        });

        function addPlus(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }
    </script>
@endpush

