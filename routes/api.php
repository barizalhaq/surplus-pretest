<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'index');
    Route::post('/category/create', 'store')->middleware('json');
    Route::put('/category/update/{id}', 'update')->middleware('json');
    Route::delete('/category/delete/{id}', 'delete');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'index');
    Route::get('/product/{id}', 'view');
    Route::post('/product/create', 'store');
    Route::post('/product/{id}/image/append', 'append_image');
    Route::post('/product/update/{id}', 'update');
    Route::delete('/product/delete/{id}', 'delete');
});

Route::controller(ImageController::class)->group(function () {
    Route::post('/product/image/update/{id}', 'update');
    Route::delete('/product/image/delete/{id}', 'delete');
});
