<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CobaController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\LaporanBarangRusakController;
use App\Http\Controllers\Api\LaporanBarangKosongController;
use App\Http\Controllers\Api\LaporanPesananBarangController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', LoginController::class)->name('login');
Route::post('logout', LogoutController::class)->name('logout');
Route::post('coba', CobaController::class)->name('coba');

Route::apiResource('category', CategoriesController::class)->middleware('auth:api');
Route::apiResource('barang', BarangController::class)->middleware('auth:api');

Route::apiResource('admin', AdminController::class)->middleware('auth:api');

Route::apiResource('laporan', laporanController::class)->middleware('auth:api');
Route::apiResource('barangRusak', LaporanBarangRusakController::class)->middleware('auth:api');
Route::apiResource('barangKosong', LaporanBarangKosongController::class)->middleware('auth:api');
Route::apiResource('pesanan', LaporanPesananBarangController::class)->middleware('auth:api');
