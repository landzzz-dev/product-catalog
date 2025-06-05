<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blade\BladeProductController;
use App\Http\Controllers\Vue\VueProductController;

Route::get('/login', function () { return view('app'); })->name('home');

Route::post('/login', function () { return view('app'); })->name('home');

Route::get('/', function () { return view('app'); })->name('home');

Route::get('/logout', function () { return view('app'); })->name('home');

Route::prefix('/blade/products')->controller(BladeProductController::class)->group(function () {
    Route::get('/', 'index')->name('products.blade');

    Route::get('/create', 'create')->name('products.create');
    Route::post('/store', 'store')->name('products.store');
    Route::get('/{product}/update', 'update')->name('products.update');
    Route::put('/{product}/edit', 'edit')->name('products.edit');
    Route::delete('/{product}/delete', 'destroy')->name('products.delete');
});

Route::prefix('/vue/products')->controller(VueProductController::class)->group(function () {
    Route::get('/', 'index')->name('products.vue');
    Route::get('/data', 'data');
    Route::post('/store', 'store');
    Route::put('/update/{product}', 'update');
    Route::delete('/delete/{product}', 'destroy');
});

