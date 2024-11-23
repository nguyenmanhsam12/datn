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
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ThanhYouController;
use App\Http\Controllers\UserController;
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
Route::get('/checkout',[CheckoutController::class,'checkout'])->name('checkout');
// xác nhận đã nhận hàng 
Route::post('/order/confirm', [MyAccountController::class, 'confirmOrder'])->name('confirmOrder');
// xác nhận hủy đơn hàng
Route::post('/cancelOrder', [MyAccountController::class, 'cancelOrder'])->name('cancelOrder');




// cửa hàng
// Route::get('/shop',[ShopController::class,'shop'])->name('shop');
// Route::get('/shop/category/{id}', [ShopController::class, 'showProByCate'])->name('shop.byCategory');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
Route::get('/shop/category/{categoryId}', [ShopController::class, 'showProByCate'])->name('shop.byCategory');


// bài viết
Route::get('/blog',[BlogController::class,'blog'])->name('blog');

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



// khiếu nại
Route::get('/complaint/{orderId}',[ComplanintsController::class, 'complaints'])->name('complaints');
// gửi khiếu nại
Route::post('/complaintStore', [ComplanintsController::class, 'complaintStore'])->name('complaintStore');


// đặt hàng thành công -> cảm ơn 
Route::get('/thank-you', [ThanhYouController::class,'thankyou'])->name('thankyou');

// lấy sản phẩm theo danh mục
Route::get('/getProductsByCategory/{category_id}', [HomeController::class, 'getProductsByCategory'])->name('getProductsByCategory');

// lấy chi tiết sp
Route::get('/getDetailProduct/{slug}',[HomeController::class,'getDetailProduct'])->name('getDetailProduct');



Route::prefix('admin')->middleware('checkadmin')->group(function(){

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
   

    Route::prefix('user')->group(function(){
        Route::get('/',[UserController::class,'index'])->name('admin.user.index');
        Route::get('/create',[UserController::class,'create'])->name('admin.user.create');
        Route::post('/store',[UserController::class,'store'])->name('admin.user.store');
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('admin.user.edit');
        Route::put('/update/{id}',[UserController::class,'update'])->name('admin.user.update');
        Route::get('/delete/{id}',[UserController::class,'delete'])->name('admin.user.delete');


    });

    Route::prefix('brands')->group(function(){
        Route::get('/',[BrandController::class,'index'])->name('admin.brand.index');
        Route::get('/create',[BrandController::class,'create'])->name('admin.brand.create');
        Route::post('/storeBrand',[BrandController::class,'storeBrand'])->name('admin.brand.storeBrand');
        Route::get('/edit/{id}',[BrandController::class,'edit'])->name('admin.brand.edit');
        Route::put('/update/{id}',[BrandController::class,'updateBrand'])->name('admin.brand.updateBrand');
        Route::get('/delete/{id}',[BrandController::class,'deleteBrand'])->name('admin.brand.deleteBrand');
    });

    Route::prefix('sizes')->group(function(){
        Route::get('/',[SizeController::class,'index'])->name('admin.size.index');
        Route::get('/create',[SizeController::class,'create'])->name('admin.size.create');
        Route::post('/store',[SizeController::class,'store'])->name('admin.size.store');
        Route::get('/edit/{id}',[SizeController::class,'edit'])->name('admin.size.edit');
        Route::put('/update/{id}',[SizeController::class,'update'])->name('admin.size.update');
        Route::get('/delete/{id}',[SizeController::class,'delete'])->name('admin.size.delete');


    });

    Route::prefix('category')->group(function(){
        Route::get('/',[CategoryController::class,'index'])->name('admin.category.index');
        Route::get('/create',[CategoryController::class,'create'])->name('admin.category.create');
        Route::post('/store',[CategoryController::class,'store'])->name('admin.category.store');
        Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('admin.category.edit');
        Route::put('/update/{id}',[CategoryController::class,'update'])->name('admin.category.update');
        Route::get('/delete/{id}',[CategoryController::class,'delete'])->name('admin.category.delete');


    });

    Route::prefix('product')->group(function(){
        Route::get('/',[ProductController::class,'index'])->name('admin.product.index');
        Route::get('/create',[ProductController::class,'create'])->name('admin.product.create');
        Route::post('/store',[ProductController::class,'store'])->name('admin.product.store');
        Route::get('/edit/{id}',[ProductController::class,'edit'])->name('admin.product.edit');
        Route::put('/update/{id}',[ProductController::class,'update'])->name('admin.product.update');
        Route::get('/delete/{id}',[ProductController::class,'delete'])->name('admin.product.delete');
    });

    Route::prefix('variant')->group(function(){
        Route::get('/',[VariantController::class,'index'])->name('admin.variant.index');
       
        Route::get('/edit/{id}',[VariantController::class,'edit'])->name('admin.variant.edit');
        Route::put('/update/{id}',[VariantController::class,'update'])->name('admin.variant.update');
        Route::get('/delete/{id}',[VariantController::class,'delete'])->name('admin.variant.delete');
    });

    Route::prefix('order')->group(function(){
        Route::get('/',[OrderAdminController::class,'index'])->name('admin.order.index');
        Route::get('/detail/{id}',[OrderAdminController::class,'detail'])->name('admin.order.detail');
        Route::put('/admin/orders/update-status', [OrderAdminController::class, 'updateStatus'])->name('admin.order.updateStatus');
        Route::put('/admin/orders/update-order', [OrderAdminController::class, 'updateOrder'])->name('admin.order.updateOrder');

    });

    Route::prefix('coupons')->group(function(){
        Route::get('/',[CouponController::class,'index'])->name('admin.coupons.index');
        Route::get('/create',[CouponController::class,'create'])->name('admin.coupons.create');
        Route::post('/storeCoupon',[CouponController::class,'storeCoupon'])->name('admin.coupons.storeCoupon');
        Route::get('/edit/{id}',[CouponController::class,'edit'])->name('admin.coupons.edit');
        Route::put('/update/{id}',[CouponController::class,'update'])->name('admin.coupons.update');
        Route::get('/delete/{id}',[CouponController::class,'delete'])->name('admin.coupons.delete');
    });

    Route::prefix('comlaints')->group(function(){
        Route::get('/',[ComplanintsController::class,'index'])->name('admin.comlaints.index');
        Route::get('/detailComplaints/{id}',[ComplanintsController::class,'detailComplaints'])->name('admin.comlaints.detailComplaints');
        Route::put('/admin/comlaints/update-status', [ComplanintsController::class, 'updateStatus'])->name('admin.comlaints.updateStatus');

    });

    // Route::prefix('statistical')->group(function(){
    //     Route::get('/',[StatisticsController::class,'index'])->name('admin.statistical.index');
    //     Route::get('/bieudo',[StatisticsController::class,'bieudo'])->name('admin.statistical.bieudo');


    // });

});
