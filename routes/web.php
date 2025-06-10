<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Blade\BladeProductController;
use App\Http\Controllers\Blade\BladeCategoryController;
use App\Http\Controllers\Vue\VueProductController;
use App\Http\Controllers\Vue\VueCategoryController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'login');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'create')->name('register');
    Route::post('/register', 'register');
});

Route::middleware(['auth', PreventBackHistory::class])->group(function () {
    Route::get('/', function () { return view('app'); })->name('home');
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::prefix('/blade/products')->controller(BladeProductController::class)->group(function () {
        Route::get('/', 'index')->name('products.blade');
    
        Route::get('/create', 'create')->name('products.create');
        Route::post('/store', 'store')->name('products.store');
        Route::get('/{product}/update', 'update')->name('products.update');
        Route::put('/{product}/edit', 'edit')->name('products.edit');
        Route::delete('/{product}/delete', 'destroy')->name('products.delete');

        // Route::resource('/', BladeProductController::class);
    });
    
    Route::prefix('/blade/categories')->controller(BladeCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('categories.blade');
    
        Route::get('/create', 'create')->name('categories.create');
        Route::post('/store', 'store')->name('categories.store');
        Route::get('/{category}/update', 'update')->name('categories.update');
        Route::put('/{category}/edit', 'edit')->name('categories.edit');
        Route::delete('/{category}/delete', 'destroy')->name('categories.delete');
    });
    
    Route::prefix('/vue')->group(function () {
        Route::prefix('/categories')->controller(VueCategoryController::class)->group(function () {
            Route::get('/', 'index')->name('vue');
            Route::get('/category_data', 'data');
            Route::post('/store', 'store');
            Route::put('/update/{category}', 'update');
            Route::delete('/delete/{category}', 'destroy');
        });

        Route::prefix('/products')->controller(VueProductController::class)->group(function () {
            Route::get('/', 'index')->name('vue');
            Route::get('product_data', 'data');
            Route::post('/store', 'store');
            Route::put('/update/{product}', 'update');
            Route::delete('/delete/{product}', 'destroy');
        });

    });
});


