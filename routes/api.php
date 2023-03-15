<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'index');
    Route::post('/category/create', 'store');
    Route::put('/category/update/{id}', 'update');
});
