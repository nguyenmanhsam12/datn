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
                            <li><a href="#">usd</a><i class="zmdi zmdi-chevron-down"></i>
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
                            </li>

                            @if (Auth::user())
                                <li><a href="#">Xin chào {{ Auth::user()->name }}</a><i
                                        class="zmdi zmdi-chevron-down"></i>
                                    <ul>
                                        @if (Auth::user()->roles->count() == 1 && Auth::user()->roles->first()->name == 'guest')
                                            <li><a href="{{ route('myAccount') }}">Tài khoản của tôi</a></li>
                                            <li><a href="{{ route('wishlist') }}">Yêu thích</a></li>
                                            <li><a href="{{ route('checkout') }}">Thanh toán</a></li>
                                            <li><a href="{{ route('logout') }}">Đăng Xuất</a></li>
                                        @else
                                            <li><a href="{{ route('dashboard') }}">Trang quản trị</a></li>
                                            <li><a href="{{ route('myAccount') }}">Tài khoản của tôi</a></li>
                                            <li><a href="{{ route('wishlist') }}">Yêu thích</a></li>
                                            <li><a href="{{ route('checkout') }}">Thanh toán</a></li>
                                            <li><a href="{{ route('logout') }}">Đăng Xuất</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @else
                                <li><a href="#">Tài khoản</a><i class="zmdi zmdi-chevron-down"></i>
                                    <ul>
                                        <li><a href="{{ route('myAccount') }}">Tài khoản của tôi</a></li>
                                        <li><a href="{{route('wishlist')}}">Yêu thích</a></li>
                                        <li><a href="{{ route('checkout') }}">Thanh toán</a></li>
                                        <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                                        <li><a href="{{ route('register') }}">Đăng Ký</a></li>

                                    </ul>
                                </li>
                            @endif


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
                        <a href="{{ route('home') }}"><img style="width: 200px;"
                                src="{{ asset('img/logo/logo.png') }}" alt="" /></a>
                    </div>
                </div>
                <!-- logo end -->
                <!-- mainmenu area start -->
                <div class="col-md-auto col-6 d-flex justify-content-end gap-2">
                    <!-- Menu Area -->
                    <div class="mainmenu  position-relative">
                        <nav>
                            <ul>
                                <li class="expand"><a href="{{ route('home') }}">Trang chủ</a></li>


                                <li class="expand position-static"><a href="{{ route('shop') }}">Cửa Hàng</a>
                                    <div class="restrain mega-menu megamenu4">
                                        <span>
                                            <a class="mega-menu-title" href="">Thương hiệu</a>
                                            @foreach ($list_brand as $br)
                                                <a
                                                    href="{{ route('products.brand', ['slug' => $br->slug]) }}">{{ $br->name }}</a>
                                            @endforeach
                                        </span>
                                        <span class="block-last">
                                            <a class="mega-menu-title" href="product-details.html">Danh mục</a>
                                            @foreach ($list_category as $cate)
                                                <a
                                                    href="{{ route('products.category', ['slug' => $cate->slug]) }}">{{ $cate->name }}</a>
                                            @endforeach
                                        </span>

                                    </div>
                                </li>
                                <li class="expand"><a href="{{ route('voucher') }}">Mã Giảm Giá</a></li>
                                <li class="expand"><a href="{{ route('blog') }}">Tin tức</a></li>
                                <li class="expand"><a href="{{ route('contact') }}">Liên hệ</a></li>
                                <li class="expand"><a href="{{ route('about') }}">Về chúng tôi</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Menu Area -->
                    <div class="mini-cart text-right">
                        <ul>
                            <li>
                                <button class="cart-icon" id="search-icon">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div id="search-modal" class="search-modal">
                        <div class="search-modal-content">
                            <div class="search-modal-logo">
                                <img style="width: 200px;" src="{{ asset('img/logo/logo.png') }}" alt=""
                                    srcset="">
                            </div>
                            <input type="text" id="search-input" placeholder="Tìm kiếm...">
                            <div id="search-results"></div>
                            <p class="close" id="close-modal">&times;</p>
                        </div>
                    </div>

                    <!-- Menu Cart Area Start -->
                    <div class="mini-cart text-right">
                        <ul>
                            <li>
                                <a class="cart-icon" href="{{ route('cart') }}">
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                    <span class="cart-count"></span>
                                </a>
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
