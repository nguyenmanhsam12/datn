<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ComplanintsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ThanhYouController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::get('/register',[AuthController::class,'register'])->name('register');
Route::post('/postlogin',[AuthController::class,'postlogin'])->name('postlogin');
Route::post('/postRegister',[AuthController::class,'postRegister'])->name('postRegister');


// quen mk
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request'); 
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

//otp
Route::get('password/otp', [AuthController::class, 'showOtpForm'])->name('password.otp');
Route::post('password/otp', [AuthController::class, 'verifyOtp'])->name('password.verifyOtp');

// ko otp
// Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
// Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');




Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/cart',[CartController::class,'cart'])->name('cart');
Route::post('/addToCart',[CartController::class,'addToCart'])->name('addToCart');

// Tổng số lượng giỏ hàng
Route::get('/getCartItemCount',[CartController::class,'getCartItemCount'])->name('getCartItemCount');

// update số lượng giỏ hàng
Route::put('/cart/increase-quantity', [CartController::class, 'increaseQuantity'])->name('increaseQuantity');
Route::put('/cart/decrease-quantity', [CartController::class, 'decreaseQuantity'])->name('decreaseQuantity');
Route::put('/updateQuantity', [CartController::class, 'updateQuantity'])->name('updateQuantity');



// xóa giỏ hàng 
Route::delete('removeFromCart', [CartController::class, 'removeFromCart'])->name('removeFromCart');

// áp mã giảm giá vào giỏ hàng
Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('applyCoupon');
// hủy mã giảm giá
Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('removeCoupon');

// xử lí đơn vị hành chính
Route::post('/selectProvince',[CheckoutController::class,'selectProvince'])->name('selectProvince');
Route::post('/selectCity',[CheckoutController::class,'selectCity'])->name('selectCity');

Route::get('/my-account',[MyAccountController::class,'myAccount'])->name('myAccount');

// routes/web.php
Route::get('/user/orders', [MyAccountController::class, 'getOrders'])->name('user.orders');


Route::get('/checkout',[CheckoutController::class,'checkout'])->name('checkout');
// xác nhận đã nhận hàng 
Route::post('/order/confirm', [MyAccountController::class, 'confirmOrder'])->name('confirmOrder');
// xác nhận hủy đơn hàng
Route::post('/cancelOrder', [MyAccountController::class, 'cancelOrder'])->name('cancelOrder');

// cập nhập thông tin người dùng
Route::post('/update_profile', [MyAccountController::class, 'updateProfile'])->name('updateProfile');



// cửa hàng
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
Route::get('products/category/{slug}', [ShopController::class, 'category'])->name('products.category');
Route::get('products/brand/{slug}', [ShopController::class, 'brand'])->name('products.brand');
Route::get('/shop/filter', [ShopController::class, 'filter'])->name('shop.filter');




//Mã giảm giá
Route::get('/voucher',[VoucherController::class,'voucher'])->name('voucher');

// bài viết
Route::get('/blog',[BlogController::class,'blog'])->name('blog');

Route::get('blog/{id}', [BlogController::class, 'show'])->name('blog.show');

//về chúng tôi
Route::get('/about',[AboutController::class,'about'])->name('about');

//Liên Hệ
Route::get('/contact',[ContactController::class,'contact'])->name('contact');

// đặt hàng
Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('placeOrder');


// Route::post('/vnpay-payment', [CheckoutController::class, 'vnpayPayment'])->name('vnpayPayment');

// callback vnp
Route::get('/vnpay-callback', [CheckoutController::class, 'vnpayCallback'])->name('vnpayCallback');
// callback momo
Route::get('/momo-callback', [CheckoutController::class, 'momoCallback'])->name('momoCallback');

// thanh toán lại vnpay
Route::post('/payment-retry', [CheckoutController::class, 'retryPayment'])->name('retryPayment');

// router này sẽ xử lí khi người dùng back lại giao diện
// Route::get('/checkout-thankyou', [CheckoutController::class, ''])->name('momoCallback');


// khiếu nại
Route::get('/complaint/{orderId}',[ComplanintsController::class, 'complaints'])->name('complaints');
// gửi khiếu nại
Route::post('/complaintStore', [ComplanintsController::class, 'complaintStore'])->name('complaintStore');
// chi tiết khiếu nại
Route::get('/complaint_detail/{orderId}',[ComplanintsController::class, 'complaintsDetail'])->name('complaintsDetail');

Route::put('/update_complaint_image/{orderId}',[ComplanintsController::class, 'updateComplaintsImage'])->name('updateComplaintsImage');

// hủy khiếu nại
Route::delete('/complaint_delete',[ComplanintsController::class, 'complaintsDelete'])->name('complaintsDelete');



// đặt hàng thành công -> cảm ơn 
Route::get('/thank-you', [ThanhYouController::class,'thankyou'])->name('thankyou');

// lấy sản phẩm theo danh mục
Route::get('/getProductsByCategory/{category_id}', [HomeController::class, 'getProductsByCategory'])->name('getProductsByCategory');

// lấy chi tiết sp
Route::get('/product-{slug}',[HomeController::class,'getDetailProduct'])->name('getDetailProduct');

Route::post('/submit-review', [HomeController::class, 'submitReview'])->name('submitReview');

Route::delete('/delete-review/{id}', [HomeController::class, 'deleteReview'])->name('deleteReview');
// Route::post('/submit-review', [MyAccountController::class, 'submitReview'])->name('submitReview');

Route::post('/submit-review-kh', [MyAccountController::class, 'submitReview'])->name('submitReview-kh');

// tìm kiếm sản phẩm
Route::post('/serach-product', [HomeController::class, 'serachProduct'])->name('serachProduct');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/store', [WishlistController::class, 'addToWishlist'])->name('wishlist.store');
Route::get('/wishlist/{id}', [WishlistController::class, 'delWishlist'])->name('delWishlist');
    

Route::prefix('admin')->middleware('checkadmin')->group(function(){

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
   

    Route::prefix('user')->group(function(){
        Route::get('/',[UserController::class,'index'])->name('admin.user.index')->middleware('can:viewAny,App\Models\User');
        Route::get('/create',[UserController::class,'create'])->name('admin.user.create')->middleware('can:create,App\Models\User');
        Route::post('/store',[UserController::class,'store'])->name('admin.user.store');
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('admin.user.edit')->middleware('can:view,App\Models\User,id');
        Route::put('/update/{id}',[UserController::class,'update'])->name('admin.user.update');
        Route::get('/delete/{id}',[UserController::class,'delete'])->name('admin.user.delete')->middleware('can:delete,App\Models\User');
    });

    Route::prefix('role')->group(function(){
        Route::get('/',[RoleController::class,'index'])->name('admin.role.index')
            ->middleware('can:viewAny,App\Models\Role');
        Route::get('/create',[RoleController::class,'create'])->name('admin.role.create')->middleware('can:create,App\Models\Role');
        Route::post('/store',[RoleController::class,'store'])->name('admin.role.store');
        Route::get('/edit/{id}',[RoleController::class,'edit'])->name('admin.role.edit')->middleware('can:view,App\Models\Role');
        Route::put('/update/{id}',[RoleController::class,'update'])->name('admin.role.update');
        Route::get('/delete/{id}',[RoleController::class,'delete'])->name('admin.role.delete')->middleware('can:delete,App\Models\Role');
    });

    Route::prefix('permission')->group(function(){
        Route::get('/create',[PermissionController::class,'createPermission'])
            ->name('admin.permission.createPermission')
            ->middleware('can:create,App\Models\Permission');
        Route::post('/store',[PermissionController::class,'store'])->name('admin.permission.store');
    });

    Route::prefix('brands')->group(function(){
        Route::get('/',[BrandController::class,'index'])->name('admin.brand.index')->middleware('can:brand_list');
        Route::get('/create',[BrandController::class,'create'])->name('admin.brand.create')->middleware('can:brand_add');
        Route::post('/storeBrand',[BrandController::class,'storeBrand'])->name('admin.brand.storeBrand');
        Route::get('/edit/{id}',[BrandController::class,'edit'])->name('admin.brand.edit')->middleware('can:brand_edit,id');
        Route::put('/update/{id}',[BrandController::class,'updateBrand'])->name('admin.brand.updateBrand');
        Route::get('/delete/{id}',[BrandController::class,'deleteBrand'])->name('admin.brand.deleteBrand');
    });

    Route::prefix('sizes')->group(function(){
        Route::get('/',[SizeController::class,'index'])
            ->name('admin.size.index')
            ->middleware('can:viewAny,App\Models\Size');
        Route::get('/create',[SizeController::class,'create'])->name('admin.size.create')->middleware('can:create,App\Models\Size');
        Route::post('/store',[SizeController::class,'store'])->name('admin.size.store');
        Route::get('/edit/{id}',[SizeController::class,'edit'])->name('admin.size.edit')->middleware('can:view,App\Models\Size');
        Route::put('/update/{id}',[SizeController::class,'update'])->name('admin.size.update');
        Route::get('/delete/{id}',[SizeController::class,'delete'])->name('admin.size.delete')->middleware('can:delete,App\Models\Size');
    });

    Route::prefix('category')->group(function(){
        Route::get('/',[CategoryController::class,'index'])->name('admin.category.index')
            ->middleware('can:viewAny,App\Models\Category');
        Route::get('/create',[CategoryController::class,'create'])->name('admin.category.create')->middleware('can:create,App\Models\Category');
        Route::post('/store',[CategoryController::class,'store'])->name('admin.category.store');
        Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('admin.category.edit')->middleware('can:view,App\Models\Category');
        Route::put('/update/{id}',[CategoryController::class,'update'])->name('admin.category.update');
        Route::get('/delete/{id}',[CategoryController::class,'delete'])->name('admin.category.delete')->middleware('can:delete,App\Models\Category');
    });

    Route::prefix('product')->group(function(){
        Route::get('/',[ProductController::class,'index'])->name('admin.product.index')
            ->middleware('can:viewAny,App\Models\Product');
        Route::get('/create',[ProductController::class,'create'])->name('admin.product.create')->middleware('can:create,App\Models\Product');
        Route::post('/store',[ProductController::class,'store'])->name('admin.product.store');
        Route::get('/edit/{id}',[ProductController::class,'edit'])->name('admin.product.edit')->middleware('can:view,App\Models\Product,id');
        Route::put('/update/{id}',[ProductController::class,'update'])->name('admin.product.update');
        Route::get('/delete/{id}',[ProductController::class,'delete'])->name('admin.product.delete')->middleware('can:delete,App\Models\Product,id');
        Route::get('/deleteAt',[ProductController::class,'deleteAt'])->name('admin.product.deleteAt');
        Route::get('/restore/{id}',[ProductController::class,'restore'])->name('admin.product.restore');
        Route::get('/forceDeleteProduct/{id}',[ProductController::class,'forceDeleteProduct'])->name('admin.product.forceDeleteProduct');


    });

    Route::prefix('variant')->group(function(){
        Route::get('/',[VariantController::class,'index'])->name('admin.variant.index')
        ->middleware('can:viewAny,App\Models\ProductVariants');
        Route::get('/edit/{id}',[VariantController::class,'edit'])->name('admin.variant.edit')->middleware('can:view,App\Models\ProductVariants');
        Route::put('/update/{id}',[VariantController::class,'update'])->name('admin.variant.update');
        Route::get('/delete/{id}',[VariantController::class,'delete'])->name('admin.variant.delete')->middleware('can:delete,App\Models\ProductVariants');
        Route::post('/productVariant',[VariantController::class,'productVariant'])->name('admin.variant.add');
    });

    Route::prefix('order')->group(function(){
        Route::get('/',[OrderAdminController::class,'index'])->name('admin.order.index');
        Route::get('/detail/{id}',[OrderAdminController::class,'detail'])->name('admin.order.detail');
        Route::put('/admin/orders/update-status', [OrderAdminController::class, 'updateStatus'])->name('admin.order.updateStatus');
        Route::put('/admin/orders/update-order', [OrderAdminController::class, 'updateOrder'])->name('admin.order.updateOrder');
        Route::get('/admin/orders/delete-order/{id}', [OrderAdminController::class, 'deleteOrder'])->name('admin.order.deleteOrder');
    });

    Route::prefix('coupons')->group(function(){
        Route::get('/',[CouponController::class,'index'])->name('admin.coupons.index')
            ->middleware('can:viewAny,App\Models\Coupon');
        Route::get('/create',[CouponController::class,'create'])->name('admin.coupons.create')->middleware('can:create,App\Models\Coupon');
        Route::post('/storeCoupon',[CouponController::class,'storeCoupon'])->name('admin.coupons.storeCoupon');
        Route::get('/edit/{id}',[CouponController::class,'edit'])->name('admin.coupons.edit')->middleware('can:view,App\Models\Coupon');
        Route::put('/update/{id}',[CouponController::class,'update'])->name('admin.coupons.update');
        Route::get('/delete/{id}',[CouponController::class,'delete'])->name('admin.coupons.delete')->middleware('can:delete,App\Models\Coupon');
    });

    Route::prefix('comlaints')->group(function(){
        Route::get('/',[ComplanintsController::class,'index'])->name('admin.comlaints.index');
        Route::get('/detailComplaints/{id}',[ComplanintsController::class,'detailComplaints'])->name('admin.comlaints.detailComplaints');
        Route::put('/updateComplaints/{id}',[ComplanintsController::class,'updateComplaints'])->name('admin.comlaints.updateComplaints');

        Route::put('/admin/comlaints/update-status', [ComplanintsController::class, 'updateStatus'])->name('admin.comlaints.updateStatus');

    });




         // Quản lý bài viết
         Route::get('posts', [PostController::class, 'index'])->name('admin.posts.index'); // Danh sách bài viết
         Route::get('posts/create', [PostController::class, 'create'])->name('admin.posts.create'); // Form thêm bài viết
         Route::post('posts', [PostController::class, 'store'])->name('admin.posts.store'); // Lưu bài viết mới
         Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('admin.posts.edit'); // Form sửa bài viết
         Route::put('admin/posts/{id}', [PostController::class, 'update'])->name('admin.posts.update');
                
        Route::delete('admin/posts/{id}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
        Route::put('admin/posts/{id}/restore', [PostController::class, 'restore'])->name('admin.posts.restore');
        Route::delete('admin/posts/{id}/forceDelete', [PostController::class, 'forceDelete'])->name('admin.posts.forceDelete');
        Route::get('admin/posts/deleted', [PostController::class, 'deletedPosts'])->name('admin.posts.listDelete');



    // Route::prefix('statistical')->group(function(){
    //     Route::get('/',[StatisticsController::class,'index'])->name('admin.statistical.index');
    //     Route::get('/bieudo',[StatisticsController::class,'bieudo'])->name('admin.statistical.bieudo');


    // });

});
