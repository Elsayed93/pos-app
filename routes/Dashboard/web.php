<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () {
        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
            Route::view('/home', 'dashboard.welcome')->name('welcome');

            // users
            Route::resource('users', UserController::class)->except('show');

            //categories
            Route::resource('categories', CategoryController::class)->except('show');

            //products
            Route::resource('products', ProductController::class)->except('show');
        });
    }
);



/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/
