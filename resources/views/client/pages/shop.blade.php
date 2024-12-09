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
                                <li><span>Shirt</span>
                                    <ul>
                                        <li><a href="#">T-Shirts</a></li>
                                        <li><a href="#">Striped Shirts</a></li>
                                        <li><a href="#">Half Shirts</a></li>
                                        <li><a href="#">Formal Shirts</a></li>
                                        <li><a href="#">Bilazers</a></li>
                                    </ul>
                                </li> 
                                <li><span>Shirt</span>
                                    <ul>
                                        <li><a href="#">T-Shirts</a></li>
                                        <li><a href="#">Striped Shirts</a></li>
                                        <li><a href="#">Half Shirts</a></li>
                                        <li><a href="#">Formal Shirts</a></li>
                                        <li><a href="#">Bilazers</a></li>
                                    </ul>
                                </li>
                                
                                <li><span>Shirt</span>
                                    <ul>
                                        <li><a href="#">T-Shirts</a></li>
                                        <li><a href="#">Striped Shirts</a></li>
                                        <li><a href="#">Half Shirts</a></li>
                                        <li><a href="#">Formal Shirts</a></li>
                                        <li><a href="#">Bilazers</a></li>
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
                                <li><span>Shirt</span>
                                    <ul>
                                        <li><a href="#">T-Shirts</a></li>
                                        <li><a href="#">Striped Shirts</a></li>
                                        <li><a href="#">Half Shirts</a></li>
                                        <li><a href="#">Formal Shirts</a></li>
                                        <li><a href="#">Bilazers</a></li>
                                    </ul>
                                </li>          
                            </ul>
                        </div>
                    </aside>
                    <!-- end -->
                    <!-- lọc giá start -->
                    <aside class="widget shop-filter mb-30">
                        <div class="widget-title">
                            <h4>Giá Tiền</h4>
                        </div>
                        <div class="widget-info">
                            <div class="price_filter">
                                <div class="price_slider_amount">
                                    <input type="submit"  value="You range :"/> 
                                    <input type="text" id="amount" name="price"  placeholder="Add Your Price" /> 
                                </div>
                                <div id="slider-range"></div>
                            </div>
                        </div>
                    </aside>
                    <!-- end -->
                    <!-- Kích cỡ start -->
                    <aside class="widget widget-size mb-30">
                        <div class="widget-title">
                            <h4>Kích cỡ</h4>
                        </div>
                        <div class="widget-info size-filter clearfix">
                            <ul>
                                <li><a href="#">M</a></li>
                                <li class="active"><a href="#">S</a></li>
                                <li><a href="#">L</a></li>
                                <li><a href="#">SL</a></li>
                                <li><a href="#">XL</a></li>
                            </ul>
                        </div>
                    </aside>
                    <!-- end -->
                    <!-- banner start -->
                    <aside class="widget widget-banner mb-30">
                        <div class="widget-info widget-banner-img">
                            <a href="#"><img src="img/banner/5.webp" alt="" /></a>
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
                                <p class="mb-0">Hiển thị 01-09 trong số 17 sản phẩm</p>
                            </div>
                        </div>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="grid-view">							
                                <div class="row">
                                    <!-- Single-product start -->
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="single-product border">
                                            <div class="product-img">
                                                <span class="pro-label new-label">new</span>
                                                <form action="" class=" pro-price-2">
                                                    <button data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></button>
                                                </form>
                                                <a href="single-product.html"><img src="img/product/6.webp" alt="" /></a>
                                            </div>
                                            <div class="product-info clearfix ">
                                                <div class="fix">
                                                    <h4 class="post-title"><a href="#">Women Cloth 1</a></h4>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <p class="pro-price">$ 56.20</p>
                                                    
                                                </div>
                                                {{-- <div class="product-action clearfix">
                                                    
                                                    <a href="#" data-bs-toggle="modal"  data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single-product end -->
                                    
                                </div>
                            </div>
                            <div class="tab-pane" id="list-view">							
                                <div class="row shop-list">
                                    <!-- Single-product start -->
                                    <div class="col-12">
                                        <div class="single-product clearfix">
                                            <div class="product-img">
                                                <span class="pro-label new-label">new</span>
                                                {{-- <a href="#" class="pro-price-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist"><i class="zmdi zmdi-favorite-outline "></i></a> --}}
                                                <a href="single-product.html"><img src="img/product/6.webp" alt="" /></a>
                                            </div>
                                            <div class="product-info">
                                                <div class="fix">
                                                    <h4 class="post-title floatleft"><a href="#">New trend style</a></h4>
                                                    
                                                </div>
                                                <div class="fix mb-20">
                                                    <span class="pro-price">$ 56.20</span>
                                                </div>
                                                {{-- <div class="clearfix">
                                                    <div class="product-action clearfix">
                                                        
                                                        <a href="#" data-bs-toggle="modal"  data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                                    </div>
                                                </div> --}}
                                                <div class="product-description">
                                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have be suffered alteration in some form, by injected humour, or randomised words which donot look even slightly believable. If you are going to use a passage of Lorem Ipsum, you neede be sure there isn't anythin  going to use a passage embarrassing.</p>
                                                </div>
                                                <div class="fix">
                                                    <button class="submit-button button-one" data-text="Thêm Vào Yêu Thích">Thêm Vào yêu thích</button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single-product end -->
                                </div>
                            </div>
                        </div>
                        <!-- Pagination start -->
                        <div class="shop-pagination text-center">
                            <div class="pagination">
                                <ul>
                                    <li><a href="#"><i class="zmdi zmdi-long-arrow-left"></i></a></li>
                                    <li><a href="#">01</a></li>
                                    <li class="active"><a href="#">02</a></li>
                                    <li><a href="#">03</a></li>
                                    <li><a href="#">04</a></li>
                                    <li><a href="#">05</a></li>
                                    <li><a href="#"><i class="zmdi zmdi-long-arrow-right"></i></a></li>
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
    
@endpush
