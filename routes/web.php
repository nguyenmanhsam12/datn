<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyAccountController;
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

Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/cart',[CartController::class,'cart'])->name('cart');
Route::post('/addToCart',[CartController::class,'addToCart'])->name('addToCart');
// Tổng số lượng giỏ hàng
Route::get('/getCartItemCount',[CartController::class,'getCartItemCount'])->name('getCartItemCount');
// update số lượng giỏ hàng
Route::put('updateCartQuantity', [CartController::class, 'updateCartQuantity'])->name('updateCartQuantity');
// xóa giỏ hàng 
Route::delete('removeFromCart', [CartController::class, 'removeFromCart'])->name('removeFromCart');



Route::get('/my-account',[MyAccountController::class,'myAccount'])->name('myAccount');
Route::get('/checkout',[CheckoutController::class,'checkout'])->name('checkout');

// lấy sản phẩm theo danh mục
Route::get('/getProductsByCategory/{category_id}', [HomeController::class, 'getProductsByCategory'])->name('getProductsByCategory');

// lấy chi tiết sp
Route::get('/getDetailProduct/{slug}',[HomeController::class,'getDetailProduct'])->name('getDetailProduct');


Route::prefix('admin')->middleware('checkadmin')->group(function(){

    Route::get('/', function () {
        return view('admin.layout.default');
    })->name('dashboard');

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
});
