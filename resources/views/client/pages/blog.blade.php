@extends('client.components.default')

@section('content')
 <!-- HEADING-BANNER START -->
 <div class="heading-banner-area overlay-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-banner">
                    <div class="heading-banner-title">
                        <h2>Tin Tức</h2>
                    </div>
                    <div class="breadcumbs pb-15">
                        <ul>
                            <li><a href="index.html">Trang Chủ</a></li>
                            <li>Tin tức</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- HEADING-BANNER END -->
<!-- BLGO-AREA START -->
<div class="blog-area blog-2  pt-80 pb-80">
    <div class="container">	
        <div class="blog">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-option d-flex flex-column-reverse flex-md-row justify-content-between align-items-center mb-30">
                        <div class="left d-flex">
                            <!-- Categories start -->
                            <div class="dropdown">
                                <button class="option-btn" >
                                Categories
                                </button>
                                <div class="dropdown-menu dropdown-width" >
                                    <!-- Widget-Categories start -->
                                    <aside class="widget widget-categories">
                                        <div class="widget-title">
                                            <h4>Categories</h4>
                                        </div>
                                        <div id="cat-treeview"  class="widget-info product-cat boxscrol2">
                                            <ul>
                                                <li><span>Chair</span>
                                                    <ul>
                                                        <li><a href="#">T-Shirts</a></li>
                                                        <li><a href="#">Striped Shirts</a></li>
                                                        <li><a href="#">Half Shirts</a></li>
                                                        <li><a href="#">Formal Shirts</a></li>
                                                        <li><a href="#">Bilazers</a></li>
                                                    </ul>
                                                </li>          
                                                <li class="open"><span>Bag</span>
                                                    <ul>
                                                        <li><a href="#">Men Bag</a></li>
                                                        <li><a href="#">Shoes</a></li>
                                                        <li><a href="#">Watch</a></li>
                                                        <li><a href="#">T-shirt</a></li>
                                                        <li><a href="#">Shirt</a></li>
                                                    </ul>
                                                </li>          
                                                <li><span>Accessories</span>
                                                    <ul>
                                                        <li><a href="#">T-Shirts</a></li>
                                                        <li><a href="#">Striped Shirts</a></li>
                                                        <li><a href="#">Half Shirts</a></li>
                                                        <li><a href="#">Formal Shirts</a></li>
                                                        <li><a href="#">Bilazers</a></li>
                                                    </ul>
                                                </li>
                                                <li><span>Top Brands</span>
                                                    <ul>
                                                        <li><a href="#">T-Shirts</a></li>
                                                        <li><a href="#">Striped Shirts</a></li>
                                                        <li><a href="#">Half Shirts</a></li>
                                                        <li><a href="#">Formal Shirts</a></li>
                                                        <li><a href="#">Bilazers</a></li>
                                                    </ul>
                                                </li>
                                                <li><span>Jewelry</span>
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
                                    <!-- Widget-categories end -->
                                </div>
                            </div>	
                            <!-- Categories end -->
                            <!-- Price start -->
                            <div class="dropdown">
                                <button class="option-btn" >
                                Price
                                </button>
                                <div class="dropdown-menu dropdown-width" >
                                    <!-- Shop-Filter start -->
                                    <aside class="widget shop-filter">
                                        <div class="widget-title">
                                            <h4>Price</h4>
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
                                    <!-- Shop-Filter end -->
                                </div>
                            </div>	
                            <!-- Price end -->
                            <!-- Color start -->
                            <div class="dropdown">
                                <button class="option-btn">
                                Color
                                </button>
                                <div class="dropdown-menu dropdown-width" >
                                    <!-- Widget-Color start -->
                                    <aside class="widget widget-color">
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
                                </div>
                            </div>
                            <!-- Color end -->
                            <!-- Size start -->
                            <div class="dropdown">
                                <button class="option-btn">
                                Size
                                </button>
                                <div class="dropdown-menu dropdown-width" >
                                    <!-- Widget-Size start -->
                                    <aside class="widget widget-size">
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
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <!-- Size end -->								
                            <div class="showing text-end">
                                <p class="mb-0 hidden-xs">Showing 01-09 of 17 Results</p>
                            </div>
                        </div>						
                    </div>						
                </div>							
            </div>
            <div class="row">
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/4.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Lace Sheath Dress</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/5.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Boyfriend Jeans Bright</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/6.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Matchbox' Fit Jeans</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/7.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Mixed Media Top</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/8.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">New Fray Day' Polo</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/9.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Dot Men’s Pants</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/4.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Cotton Jersey Polo</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/8.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Three-Piece Check</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12 d-none d-lg-block">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/6.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Silk Blend Sweater</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
            </div>	
            <div class="row">
                <div class="col-12">
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
            </div>
        </div>
    </div>
</div>
<!-- BLGO-AREA END -->	
			
@endsection