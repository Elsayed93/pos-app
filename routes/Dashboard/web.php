<?php

use App\Http\Controllers\Dashboard\HomeController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () {
        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {

            Route::get('/home', [HomeController::class, 'index'])->name('welcome');
            // Route::view('/home', 'dashboard.welcome')->name('welcome');

            // users
            Route::resource('users', UserController::class)->except('show');

            //categories
            Route::resource('categories', CategoryController::class)->except('show');
            //get.all.categories
            Route::get('get-all-categories', [App\Http\Controllers\Dashboard\CategoryController::class, 'getAllCategories'])->name('get.all.categories');
            //get.product.category
            Route::get('get-product-category', [App\Http\Controllers\Dashboard\CategoryController::class, 'getProductCategory'])->name('get.product.category');

            //products
            Route::resource('products', ProductController::class)->except('show');

            // clients
            Route::resource('clients', ClientController::class)->except('show');

            // orders
            Route::resource('orders', OrderController::class)->except('show');
            Route::get('orders/{order}/products', [App\Http\Controllers\Dashboard\OrderController::class, 'getOrderProducts'])->name('orders.products');
        });
    }
);



/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/
