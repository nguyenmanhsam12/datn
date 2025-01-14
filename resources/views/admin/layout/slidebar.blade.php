<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->

                <li class="nav-item ">
                    <a href="{{ route('dashboard') }}" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>


                {{-- thành viên --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Tài Khoản
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('viewAny', App\Models\User::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.user.index') }}" class="nav-link">

                                    <p>Danh sách Tài Khoản</p>
                                </a>
                            </li>
                        @endcan
                        @can('create', App\Models\User::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.user.create') }}" class="nav-link">
                                    <p>Thêm Tài Khoản</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{-- vai trò --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>
                            Vai trò
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('viewAny', App\Models\Role::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.role.index') }}" class="nav-link">
                                    <p>Danh sách vai trò</p>
                                </a>
                            </li>
                        @endcan
                      
                            {{-- <li class="nav-item">
                                <a href="{{ route('admin.permission.createPermission') }}" class="nav-link">
                                    <p>Thêm quyền</p>
                                </a>
                            </li> --}}
                        
                    </ul>
                </li>

                {{--  brand --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>
                            Thương hiệu
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('brand_list')
                            <li class="nav-item">
                                <a href="{{ route('admin.brand.index') }}" class="nav-link">

                                    <p>Danh sách thương hiệu</p>
                                </a>
                            </li>
                        @endcan
                        @can('brand_add')
                            <li class="nav-item">
                                <a href="{{ route('admin.brand.create') }}" class="nav-link">
                                    <p>Thêm thương hiệu</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{-- size --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-arrows-alt-h"></i>
                        <p>
                            Kích cỡ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('viewAny', App\Models\Size::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.size.index') }}" class="nav-link">

                                    <p>Danh sách kích cỡ</p>
                                </a>
                            </li>
                        @endcan
                        @can('create', App\Models\Size::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.size.create') }}" class="nav-link">
                                    <p>Thêm kích cỡ</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{-- danh mục --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                            Danh mục
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('viewAny', App\Models\Category::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.category.index') }}" class="nav-link">
                                    <p>Danh sách danh mục</p>
                                </a>
                            </li>
                        @endcan
                        @can('create', App\Models\Category::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.category.create') }}" class="nav-link">
                                    <p>Thêm danh mục</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{-- sản phẩm --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Sản phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('viewAny', App\Models\Product::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.product.index') }}" class="nav-link">

                                    <p>Danh sách sản phẩm</p>
                                </a>
                            </li>
                        @endcan
                        @can('create', App\Models\Product::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.product.create') }}" class="nav-link">
                                    <p>Thêm sản phẩm</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{-- thuộc tính --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Thuộc tính
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('viewAny', App\Models\ProductVariants::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.variant.index') }}" class="nav-link">
                                    <p>Danh sách thuộc tính</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{-- Đơn Hàng --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Đơn Hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('viewAny', App\Models\Order::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.order.index') }}" class="nav-link">
                                    <p>Danh Sách Đơn Hàng</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{-- mã giảm giá --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-gift"></i>
                        <p>
                            Mã giảm giá
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            @can('viewAny', App\Models\Coupon::class)
                                <a href="{{ route('admin.coupons.index') }}" class="nav-link">
                                    <p>Danh Sách Mã</p>
                                </a>
                            @endcan
                            @can('create', App\Models\Coupon::class)
                                <a href="{{ route('admin.coupons.create') }}" class="nav-link">
                                    <p>Thêm mã giảm giá</p>
                                </a>
                            @endcan
                        </li>
                    </ul>
                </li>

                {{-- khiếu nại --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Khiếu nại
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('viewAny', App\Models\Complaints::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.comlaints.index') }}" class="nav-link">
                                    <p>Danh Sách Khiếu nại</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>


                {{-- Đánh giá --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-star"></i>
                        <p>
                            Đánh giá
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('viewAny', App\Models\Review::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.reviews.index') }}" class="nav-link">
                                    <p>Danh Sách Đánh Giá</p>
                                </a>

                            </li>
                        @endcan
                    </ul>
                </li>
                {{--  Bài viết --}}
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-pen-nib"></i>
                        <p>
                            Bài viết
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('viewAny',App\Models\Post::class)
                            <li class="nav-item">
                                <a href="{{ route('admin.posts.index') }}" class="nav-link">
                                    <p>Danh Sách Bài viết</p>
                                </a>

                            </li>
                        @endcan
                    </ul>
                </li>



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
