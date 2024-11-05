@extends('client.components.default');
@push('styles')
    <style>
        .zmdi{
            line-height: 40px;
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
                            <li>Cửa Hàng</li>
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
                <!-- Widget-Search start -->
                <aside class="widget widget-search mb-30">
                    <form action="#">
                        <input type="text" placeholder="Search here...">
                        <button type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
                </aside>
                <!-- Widget-search end -->
                <!-- Widget-Categories start -->
                <aside class="widget widget-categories  mb-30">
                    <div class="widget-title">
                        <h4>Categories</h4>
                    </div>
                    <div id="cat-treeview" class="widget-info product-cat boxscrol2" tabindex="0" style="overflow: hidden; outline: none;">
                        <ul class="treeview">
                            <li class="expandable"><div class="hitarea expandable-hitarea"></div><span class="">Shirt</span>
                                <ul class="treeview" style="display: none;">
                                    <li><a href="#">T-Shirts</a></li>
                                    <li><a href="#">Striped Shirts</a></li>
                                    <li><a href="#">Half Shirts</a></li>
                                    <li><a href="#">Formal Shirts</a></li>
                                    <li class="last"><a href="#">Bilazers</a></li>
                                </ul>
                            </li>          
                            <li class="open collapsable"><div class="hitarea open-hitarea collapsable-hitarea"></div><span class="">Bag</span>
                                <ul class="treeview">
                                    <li><a href="#" class="">Men Bag</a></li>
                                    <li><a href="#" class="">Shoes</a></li>
                                    <li><a href="#" class="">Watch</a></li>
                                    <li><a href="#" class="">T-shirt</a></li>
                                    <li class="last"><a href="#" class="">Shirt</a></li>
                                </ul>
                            </li>          
                            <li class="expandable"><div class="hitarea expandable-hitarea"></div><span class="">Accessories</span>
                                <ul class="treeview" style="display: none;">
                                    <li><a href="#">T-Shirts</a></li>
                                    <li><a href="#">Striped Shirts</a></li>
                                    <li><a href="#">Half Shirts</a></li>
                                    <li><a href="#">Formal Shirts</a></li>
                                    <li class="last"><a href="#">Bilazers</a></li>
                                </ul>
                            </li>
                            <li class="expandable"><div class="hitarea expandable-hitarea"></div><span class="">Top Brands</span>
                                <ul class="treeview" style="display: none;">
                                    <li><a href="#">T-Shirts</a></li>
                                    <li><a href="#">Striped Shirts</a></li>
                                    <li><a href="#">Half Shirts</a></li>
                                    <li><a href="#">Formal Shirts</a></li>
                                    <li class="last"><a href="#">Bilazers</a></li>
                                </ul>
                            </li>
                            <li class="expandable lastExpandable"><div class="hitarea expandable-hitarea lastExpandable-hitarea"></div><span class="">Jewelry</span>
                                <ul class="treeview" style="display: none;">
                                    <li><a href="#">T-Shirts</a></li>
                                    <li><a href="#">Striped Shirts</a></li>
                                    <li><a href="#">Half Shirts</a></li>
                                    <li><a href="#">Formal Shirts</a></li>
                                    <li class="last"><a href="#">Bilazers</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </aside>
                <!-- Widget-categories end -->
                <!-- Shop-Filter start -->
                <aside class="widget shop-filter mb-30">
                    <div class="widget-title">
                        <h4>Price</h4>
                    </div>
                    <div class="widget-info">
                        <div class="price_filter">
                            <div class="price_slider_amount">
                                <input type="submit" value="You range :"> 
                                <input type="text" id="amount" name="price" placeholder="Add Your Price"> 
                            </div>
                            <div id="slider-range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"><div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 66.5641%;"></div><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 66.5641%;"></span></div>
                        </div>
                    </div>
                </aside>
                <!-- Shop-Filter end -->
                <!-- Widget-Color start -->
                <aside class="widget widget-color mb-30">
                    <div class="widget-title">
                        <h4>Color</h4>
                    </div>
                    <div class="widget-info color-filter clearfix">
                        <ul>
                            <li><a href="#"><span class="color color-1"></span>LightSalmon<span class="count">12</span></a></li>
                            <li><a href="#"><span class="color color-2"></span>Dark Salmon<span class="count">20</span></a></li>
                            <li><a href="#"><span class="color color-3"></span>Tomato<span class="count">59</span></a></li>
                            <li class="active"><a href="#"><span class="color color-4"></span>Deep Sky Blue<span class="count">45</span></a></li>
                            <li><a href="#"><span class="color color-5"></span>Electric Purple<span class="count">78</span></a></li>
                            <li><a href="#"><span class="color color-6"></span>Atlantis<span class="count">10</span></a></li>
                            <li><a href="#"><span class="color color-7"></span>Deep Lilac<span class="count">15</span></a></li>
                        </ul>
                    </div>
                </aside>
                <!-- Widget-Color end -->
                <!-- Widget-Size start -->
                <aside class="widget widget-size mb-30">
                    <div class="widget-title">
                        <h4>Size</h4>
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
                <!-- Widget-Size end -->
                <!-- Widget-banner start -->
                <aside class="widget widget-banner mb-30">
                    <div class="widget-info widget-banner-img">
                        <a href="#"><img src="img/banner/5.webp" alt=""></a>
                    </div>
                </aside>
                <!-- Widget-banner end -->
            </div>
            <div class="col-lg-9">
                <!-- Shop-Content End -->
                <div class="shop-content">
                    <div class="product-option mb-30 d-flex flex-column-reverse flex-sm-row justify-content-between align-items-center">
                        <!-- Nav tabs -->
                        <ul class="shop-tab nav" role="tablist">
                            <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-target="#grid-view" data-bs-toggle="tab" aria-selected="true" role="tab"><i class="zmdi zmdi-view-module"></i></button></li>
                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-target="#list-view" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1"><i class="zmdi zmdi-view-list"></i></button></li>
                        </ul>
                        <div class="showing text-end">
                            <p class="mb-0">Showing 01-09 of 17 Results</p>
                        </div>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active show" id="grid-view" role="tabpanel">							
                            <div class="row">
                                <!-- Single-product start -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <span class="pro-label new-label">new</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/6.webp" alt=""></a>
                                        </div>
                                        <div class="product-info clearfix text-center">
                                            <div class="fix">
                                                <h4 class="post-title"><a href="#">Women Cloth 1</a></h4>
                                            </div>
                                            <div class="fix">
                                                <span class="pro-rating">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                </span>
                                            </div>
                                            <div class="product-action clearfix">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <span class="pro-label sale-label">Sale</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/3.webp" alt=""></a>
                                        </div>
                                        <div class="product-info clearfix text-center">
                                            <div class="fix">
                                                <h4 class="post-title"><a href="#">Sweet Street Life 2022</a></h4>
                                            </div>
                                            <div class="fix">
                                                <span class="pro-rating">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                </span>
                                            </div>
                                            <div class="product-action clearfix">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/7.webp" alt=""></a>
                                        </div>
                                        <div class="product-info clearfix text-center">
                                            <div class="fix">
                                                <h4 class="post-title"><a href="#">Split Side Pink</a></h4>
                                            </div>
                                            <div class="fix">
                                                <span class="pro-rating">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                </span>
                                            </div>
                                            <div class="product-action clearfix">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <span class="pro-label sale-label">sale</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/10.webp" alt=""></a>
                                        </div>
                                        <div class="product-info clearfix text-center">
                                            <div class="fix">
                                                <h4 class="post-title"><a href="#">New trend style</a></h4>
                                            </div>
                                            <div class="fix">
                                                <span class="pro-rating">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                </span>
                                            </div>
                                            <div class="product-action clearfix">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/8.webp" alt=""></a>
                                        </div>
                                        <div class="product-info clearfix text-center">
                                            <div class="fix">
                                                <h4 class="post-title"><a href="#">Split Side Pink</a></h4>
                                            </div>
                                            <div class="fix">
                                                <span class="pro-rating">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                </span>
                                            </div>
                                            <div class="product-action clearfix">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <span class="pro-label new-label">new</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/11.webp" alt=""></a>
                                        </div>
                                        <div class="product-info clearfix text-center">
                                            <div class="fix">
                                                <h4 class="post-title"><a href="#">New trend style</a></h4>
                                            </div>
                                            <div class="fix">
                                                <span class="pro-rating">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                </span>
                                            </div>
                                            <div class="product-action clearfix">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <span class="pro-label new-label">new</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/2.webp" alt=""></a>
                                        </div>
                                        <div class="product-info clearfix text-center">
                                            <div class="fix">
                                                <h4 class="post-title"><a href="#">New trend style</a></h4>
                                            </div>
                                            <div class="fix">
                                                <span class="pro-rating">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                </span>
                                            </div>
                                            <div class="product-action clearfix">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/1.webp" alt=""></a>
                                        </div>
                                        <div class="product-info clearfix text-center">
                                            <div class="fix">
                                                <h4 class="post-title"><a href="#">New trend style</a></h4>
                                            </div>
                                            <div class="fix">
                                                <span class="pro-rating">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                </span>
                                            </div>
                                            <div class="product-action clearfix">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-lg-4 d-none d-lg-block col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <span class="pro-label new-label">new</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/12.webp" alt=""></a>
                                        </div>
                                        <div class="product-info clearfix text-center">
                                            <div class="fix">
                                                <h4 class="post-title"><a href="#">New trend style</a></h4>
                                            </div>
                                            <div class="fix">
                                                <span class="pro-rating">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                </span>
                                            </div>
                                            <div class="product-action clearfix">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                            </div>
                        </div>
                        <div class="tab-pane" id="list-view" role="tabpanel">							
                            <div class="row shop-list">
                                <!-- Single-product start -->
                                <div class="col-12">
                                    <div class="single-product clearfix">
                                        <div class="product-img">
                                            <span class="pro-label new-label">new</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/6.webp" alt=""></a>
                                        </div>
                                        <div class="product-info">
                                            <div class="fix">
                                                <h4 class="post-title floatleft"><a href="#">New trend style</a></h4>
                                                <span class="pro-rating floatright">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <span>( 27 Rating )</span>
                                                </span>
                                            </div>
                                            <div class="fix mb-20">
                                                <span class="pro-price">$ 56.20</span>
                                                <span class="old-price font-16px ml-10"><del>$ 96.20</del></span>
                                            </div>
                                            <div class="product-description">
                                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have be suffered alteration in some form, by injected humour, or randomised words which donot look even slightly believable. If you are going to use a passage of Lorem Ipsum, you neede be sure there isn't anythin  going to use a passage embarrassing.</p>
                                            </div>
                                            <div class="clearfix">
                                                <div class="cart-plus-minus"><div class="dec qtybutton">-</div>
                                                    <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                                <div class="inc qtybutton">+</div></div>
                                                <div class="product-action clearfix">
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-12">
                                    <div class="single-product clearfix">
                                        <div class="product-img">
                                            <span class="pro-label new-label">new</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/3.webp" alt=""></a>
                                        </div>
                                        <div class="product-info">
                                            <div class="fix">
                                                <h4 class="post-title floatleft"><a href="#">New trend style</a></h4>
                                                <span class="pro-rating floatright">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <span>( 27 Rating )</span>
                                                </span>
                                            </div>
                                            <div class="fix mb-20">
                                                <span class="pro-price">$ 56.20</span>
                                            </div>
                                            <div class="product-description">
                                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have be suffered alteration in some form, by injected humour, or randomised words which donot look even slightly believable. If you are going to use a passage of Lorem Ipsum, you neede be sure there isn't anythin  going to use a passage embarrassing.</p>
                                            </div>
                                            <div class="clearfix">
                                                <div class="cart-plus-minus"><div class="dec qtybutton">-</div>
                                                    <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                                <div class="inc qtybutton">+</div></div>
                                                <div class="product-action clearfix">
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-12">
                                    <div class="single-product clearfix">
                                        <div class="product-img">
                                            <span class="pro-label new-label">new</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/2.webp" alt=""></a>
                                        </div>
                                        <div class="product-info">
                                            <div class="fix">
                                                <h4 class="post-title floatleft"><a href="#">New trend style</a></h4>
                                                <span class="pro-rating floatright">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <span>( 27 Rating )</span>
                                                </span>
                                            </div>
                                            <div class="fix mb-20">
                                                <span class="pro-price">$ 56.20</span>
                                            </div>
                                            <div class="product-description">
                                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have be suffered alteration in some form, by injected humour, or randomised words which donot look even slightly believable. If you are going to use a passage of Lorem Ipsum, you neede be sure there isn't anythin  going to use a passage embarrassing.</p>
                                            </div>
                                            <div class="clearfix">
                                                <div class="cart-plus-minus"><div class="dec qtybutton">-</div>
                                                    <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                                <div class="inc qtybutton">+</div></div>
                                                <div class="product-action clearfix">
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-12">
                                    <div class="single-product clearfix">
                                        <div class="product-img">
                                            <span class="pro-label new-label">new</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/10.webp" alt=""></a>
                                        </div>
                                        <div class="product-info">
                                            <div class="fix">
                                                <h4 class="post-title floatleft"><a href="#">New trend style</a></h4>
                                                <span class="pro-rating floatright">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <span>( 27 Rating )</span>
                                                </span>
                                            </div>
                                            <div class="fix mb-20">
                                                <span class="pro-price">$ 56.20</span>
                                                <span class="old-price font-16px ml-10"><del>$ 96.20</del></span>
                                            </div>
                                            <div class="product-description">
                                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have be suffered alteration in some form, by injected humour, or randomised words which donot look even slightly believable. If you are going to use a passage of Lorem Ipsum, you neede be sure there isn't anythin  going to use a passage embarrassing.</p>
                                            </div>
                                            <div class="clearfix">
                                                <div class="cart-plus-minus"><div class="dec qtybutton">-</div>
                                                    <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                                <div class="inc qtybutton">+</div></div>
                                                <div class="product-action clearfix">
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single-product end -->
                                <!-- Single-product start -->
                                <div class="col-12">
                                    <div class="single-product clearfix">
                                        <div class="product-img">
                                            <span class="pro-label new-label">new</span>
                                            <span class="pro-price-2">$ 56.20</span>
                                            <a href="single-product.html"><img src="img/product/12.webp" alt=""></a>
                                        </div>
                                        <div class="product-info">
                                            <div class="fix">
                                                <h4 class="post-title floatleft"><a href="#">New trend style</a></h4>
                                                <span class="pro-rating floatright">
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                    <span>( 27 Rating )</span>
                                                </span>
                                            </div>
                                            <div class="fix mb-20">
                                                <span class="pro-price">$ 56.20</span>
                                            </div>
                                            <div class="product-description">
                                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have be suffered alteration in some form, by injected humour, or randomised words which donot look even slightly believable. If you are going to use a passage of Lorem Ipsum, you neede be sure there isn't anythin  going to use a passage embarrassing.</p>
                                            </div>
                                            <div class="clearfix">
                                                <div class="cart-plus-minus"><div class="dec qtybutton">-</div>
                                                    <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                                <div class="inc qtybutton">+</div></div>
                                                <div class="product-action clearfix">
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Wishlist" data-bs-original-title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Compare" data-bs-original-title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                                </div>
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