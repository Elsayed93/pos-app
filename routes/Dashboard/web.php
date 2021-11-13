<?php

use App\Http\Controllers\Dashboard\HomeController;
use Illuminate\Support\Facades\Route;


// routes/web.php
// Route::group(
//     [
//         'prefix' => LaravelLocalization::setLocale(),
//         'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
//     ],
//     function () { //...
//     }
// );

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth']
    ],
    function () {
        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
            // Route::get('test-route', [HomeController::class, 'index']);
            Route::view('/home', 'dashboard.welcome')->name('welcome');

            // users
            Route::resource('users', UserController::class);
        });
    }
);



/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/
