<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\LogoutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', LoginController::class)->name('login');
Route::post('logout', LogoutController::class)->name('logout');

Route::apiResource('barang', BarangController::class)->middleware('auth:api');
Route::apiResource('admin', AdminController::class)->middleware('auth:api');
