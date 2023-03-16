<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'index');
    Route::post('/category/create', 'store')->middleware('json');
    Route::put('/category/update/{id}', 'update')->middleware('json');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'index');
    Route::post('/product/create', 'store');
});
