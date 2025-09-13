<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ImagesController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProductDetailContoller;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PurchasesController;
use App\Http\Controllers\Dashboard\SupplierController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;



    //Login and Authenticate
        Route::get('/',[AuthController::class,'login'])->name('auth.index');
        Route::post('/login',[AuthController::class,'authenticate'])->name('auth.authenticate');

        //Logout 
        Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');



        //Dashboard Router
        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard.index');

        //User Routers
        Route::get("/user",[UserController::class,'index'])->name("user.index");
        Route::post("/user/list",[UserController::class,'list'])->name("user.list");
        Route::post("/user/store",[UserController::class,'store'])->name("user.store");
        Route::post("/user/destory",[UserController::class,'destroy'])->name("user.destroy");

        //Brand Routers
        Route::get("/brand",[BrandController::class,'index'])->name("brand.index");
        Route::post("/brand/list",[BrandController::class,'list'])->name("brand.list");
        Route::post("/brand/store",[BrandController::class,'store'])->name("brand.store");
        Route::post("/brand/edit",[BrandController::class,'edit'])->name("brand.edit");
        Route::post("/brand/update",[BrandController::class,'update'])->name("brand.update");
        Route::post("/brand/destroy",[BrandController::class,'destroy'])->name("brand.destroy");

        //Category Routers
        Route::get("/category",[CategoryController::class,'index'])->name("category.index");
        Route::post("/category/list",[CategoryController::class,'list'])->name("category.list");
        Route::post("/category/store",[CategoryController::class,'store'])->name("category.store");
        Route::post("/category/edit",[CategoryController::class,'edit'])->name("category.edit");
        Route::post("/category/update",[CategoryController::class,'update'])->name("category.update");
        Route::post("/category/destroy",[CategoryController::class,'destroy'])->name("category.destroy");
        Route::post("/category/upload",[CategoryController::class,'upload'])->name('category.upload');
        Route::post("/category/cancel",[CategoryController::class,'cancel'])->name('category.cancel');

     
        //Category Routers
        Route::get("/supplier",[SupplierController::class,'index'])->name("supplier.index");
        Route::post("/supplier/list",[SupplierController::class,'list'])->name("supplier.list");
        Route::post("/supplier/store",[SupplierController::class,'store'])->name("supplier.store");
        Route::post("/supplier/edit",[SupplierController::class,'edit'])->name("supplier.edit");
        Route::post("/supplier/update",[SupplierController::class,'update'])->name("supplier.update");
        Route::post("/supplier/destroy",[SupplierController::class,'destroy'])->name("supplier.destroy");


        //Profile Routers
        Route::get('/profile',[ProfileController::class,'index'])->name('profile.index');
        Route::post('/profile/change/password',[ProfileController::class,'changePassword'])->name('profile.change.password');
        Route::post('/profile/update',[ProfileController::class,'updateProfile'])->name('profile.update');
        Route::post('/profile/change/image',[ProfileController::class,'changeProfileImage'])->name('profile.change.image');




       //Product Routers
        Route::get("/product",[ProductController::class,'index'])->name("product.index");
        Route::post("/product/list",[ProductController::class,'list'])->name("product.list");
        Route::post("/product/store",[ProductController::class,'store'])->name("product.store");
        Route::post('/product/data',[ProductController::class,'data'])->name('product.data');
        Route::post("/product/edit",[ProductController::class,'edit'])->name("product.edit");
        Route::post("/product/update",[ProductController::class,'update'])->name("product.update");
        Route::post("/product/destroy",[ProductController::class,'destroy'])->name("product.destroy");

        //Image Routers
        Route::post('/product_image/upload', [ImagesController::class, 'uploads'])->name('product_image.uploads');
        Route::post('/product_image/cancel', [ImagesController::class, 'cancel'])->name('product_image.cancel');


        
       //Product_Detail Routers
        Route::get("/product_detail",[productDetailContoller::class,'index'])->name("product_detail.index");
        Route::post("/product_detail/list",[productDetailContoller::class,'list'])->name("product_detail.list");
        Route::post("/product_detail/store",[productDetailContoller::class,'store'])->name("product_detail.store");
        Route::post('/product_detail/data',[productDetailContoller::class,'data'])->name('product_detail.data');
        Route::post("/product_detail/edit",[productDetailContoller::class,'edit'])->name("product_detail.edit");
        Route::post("/product_detail/update",[productDetailContoller::class,'update'])->name("product_detail.update");
        Route::post("/product_detail/destroy",[ProductDetailContoller::class,'destroy'])->name("product_detail.destroy");


 //Image Routers
        Route::post('/product_detail/upload',[ImagesController::class,'uploads'])->name('product_detail.uploads');
        Route::post('/product_detail/cancel',[ImagesController::class,'cancel'])->name('product_detail.cancel');

 
       //Purchases Routers
        Route::get("/purchases",[PurchasesController::class,'index'])->name("purchases.index");
        Route::post("/purchases/list",[PurchasesController::class,'list'])->name("purchases.list");
        Route::post("/purchases/store",[PurchasesController::class,'store'])->name("purchases.store");
        Route::post('/purchases/data',[PurchasesController::class,'data'])->name('purchases.data');
        Route::post("/purchases/edit",[PurchasesController::class,'edit'])->name("purchases.edit");
        Route::post("/purchases/update",[PurchasesController::class,'update'])->name("purchases.update");
        Route::post("/purchases/destroy",[PurchasesController::class,'destroy'])->name("purchases.destroy");
 
