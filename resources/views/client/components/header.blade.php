<header>
    <!-- Header Top start -->
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="welcome-mes">
                        <p>Welcome Greentech store!</p>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="header-right-menu text-center text-md-end">
                        <ul>
                            @if (Auth::user())
                                <li><a href="#">Xin chào {{ Auth::user()->name }}</a><i class="zmdi zmdi-chevron-down"></i>
                                    <ul>
                                        @if (Auth::user()->hasRole('admin'))
                                            <li><a href="{{ route('dashboard') }}">Admin</a></li>   
                                        @endif

                                        <li><a href="{{ route('myAccount') }}">Tài khoản của tôi</a></li>

                                        <li><a href="{{route('wishlist')}}">Yêu thích</a></li>
                                        
                                        

                                        <li><a href="{{ route('checkout') }}">Thanh toán</a></li>
                                        <li><a href="{{ route('logout') }}">Đăng Xuất</a></li>

                                    </ul>
                                </li>
                            @else
                                <li><a href="#">Tài khoản</a><i class="zmdi zmdi-chevron-down"></i>
                                    <ul>
                                        <li><a href="{{ route('myAccount') }}">Tài khoản của tôi</a></li>
                                        <li><a href="wishlist.html">Yêu thích</a></li>
                                        <li><a href="{{ route('checkout') }}">Thanh toán</a></li>
                                        <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                                        <li><a href="{{ route('register') }}">Đăng Ký</a></li>
                                        
                                    </ul>
                                </li>
                            @endif
                          
                            {{-- <li><a href="#">usd</a><i class="zmdi zmdi-chevron-down"></i>
                                <ul>
                                    <li><a href="#">eur</a></li>
                                    <li><a href="#">usd</a></li>
                                </ul>
                            </li>
                            <li><a href="#">English</a><i class="zmdi zmdi-chevron-down"></i>
                                <ul>
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">France</a></li>
                                </ul>
                            </li> --}}
                        </ul>
                    </div>								
                </div>
            </div>
        </div>
    </div>
    <!-- Header Top End -->
    <!-- Header Bottom Menu Area Start -->
    <div id="sticky-menu" class="header-bottom">
        <div class="container">
            <div class="row justify-content-between">
                <!-- logo start -->
                <div class="col-md col-6">
                    <div class="top-logo">
                        <a href="{{route('home')}}"><img style="width: 200px;" src="{{asset('img/logo/logo.png')}}" alt="" /></a>
                    </div>
                </div>
                <!-- logo end -->
                <!-- mainmenu area start -->
                <div class="col-md-auto col-6 d-flex justify-content-end">
                    <!-- Menu Area -->
                    <div class="mainmenu  position-relative">
                        <nav>
                            <ul>
                                <li class="expand"><a href="{{ route('home') }}">Trang chủ</a></li>						
                                
                         
                                <li class="expand position-static"><a href="{{route('shop')}}">Cửa Hàng</a>
                                    <div class="restrain mega-menu megamenu4">
                                        <span>
                                            <a class="mega-menu-title" href="">Thương hiệu</a>
                                            @foreach($list_brand as $br)
                                                <a href="">{{ $br->name }}</a>
                                            @endforeach
                                            
                                        </span>
                                        <span class="block-last">
                                            <a class="mega-menu-title" href="product-details.html">Danh mục</a>
                                            @foreach($list_category as $cate)
                                                <a href="">{{ $cate->name }}</a>
                                            @endforeach
                                        </span>
                                    </div>
                                </li>
                                <li class="expand"><a href="{{route('blog')}}">Tin tức</a></li>
                                <li class="expand"><a href="{{route('contact')}}">Liên hệ</a></li>
                                <li class="expand"><a href="{{route('about')}}">Về chúng tôi</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Menu Area -->
                    <!-- Menu Cart Area Start -->
                    <div class="mini-cart text-right">
                        <ul>
                            <li>
                                <a class="cart-icon" href="{{route('cart')}}">
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                    <span class="cart-count"></span>
                                </a>
                                {{-- <div class="mini-cart-brief text-left">
                                    <div class="cart-items">
                                        <p class="mb-0">You have <span>03 items</span> in your shopping bag</p>
                                    </div>
                                    <div class="all-cart-product clearfix">
                                        <div class="single-cart clearfix">
                                            <div class="cart-photo">
                                                <a href="#"><img src="{{ asset('img/cart/1.webp') }}" alt="" /></a>
                                            </div>
                                            <div class="cart-info">
                                                <h5><a href="#">dummy product name</a></h5>
                                                <p class="mb-0">Price : $ 100.00</p>
                                                <p class="mb-0">Qty : 02 </p>
                                                <span class="cart-delete"><a href="#"><i class="zmdi zmdi-close"></i></a></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="cart-totals">
                                        <h5 class="mb-0">Total <span class="floatright">$500.00</span></h5>
                                    </div>
                                    <div class="cart-bottom  clearfix">
                                        <a href="{{route('cart')}}" class="button-one floatleft text-uppercase" data-text="View cart">View cart</a>
                                        <a href="{{route('checkout')}}" class="button-one floatright text-uppercase" data-text="Check out">Check out</a>
                                    </div>
                                </div> --}}
                            </li>
                        </ul>
                    </div>
                    <!-- Menu Cart Area Start -->
                </div>
                <!-- mainmenu area end -->
            </div>
        </div>
    </div>
    <!-- Header Menu Bottom Area Start -->
    <!-- Mobile-menu start -->
    <div class="mobile-menu-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-block d-md-none">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul>
                                <li><a href="index.html">home</a>
                                    <ul>
                                        <li><a href="index.html">Home V1</a></li>
                                        <li><a href="index-2.html">Home V2</a></li>
                                    </ul>
                                </li>
                                <li><a href="shop.html">products</a></li>
                                <li><a href="shop-sidebar.html">accesories</a></li>
                                <li><a href="shop-list.html">lookbook</a></li>
                                <li><a href="blog.html">blog</a>
                                    <ul>
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="single-blog.html">Single Blog</a></li>
                                        <li><a href="single-blog-sidebar.html">Single Blog Sidebar</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">pages</a>
                                    <ul>
                                        <li><a href="shop.html">Shop</a></li>
                                        <li><a href="shop-sidebar.html">Shop Sidebar</a></li>
                                        <li><a href="shop-list.html">Shop List</a></li>
                                        <li><a href="single-product.html">Single Product</a></li>
                                        <li><a href="single-product-sidebar.html">Single Product Sidebar</a></li>
                                        <li><a href="cart.html">Shopping Cart</a></li>
                                        <li><a href="wishlist.html">Wishlist</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                        <li><a href="order.html">Order</a></li>
                                        <li><a href="login.html">login / Registration</a></li>
                                        <li><a href="my-account.html">My Account</a></li>
                                        <li><a href="404.html">404</a></li>
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="single-blog.html">Single Blog</a></li>
                                        <li><a href="single-blog-sidebar.html">Single Blog Sidebar</a></li>
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="contact.html">Contact</a></li>
                                    </ul>
                                </li>
                                <li><a href="about.html">about us</a></li>
                                <li><a href="contact.html">contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile-menu end -->
</header>


