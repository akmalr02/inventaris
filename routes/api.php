<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\LaporanBarangRusakController;
use App\Http\Controllers\Api\LaporanBarangKosongController;
use App\Http\Controllers\Api\LaporanPesananBarangController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\ProfilController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', LoginController::class)->name('login');
Route::post('logout', LogoutController::class)->name('logout');

Route::apiResource('category', CategoriesController::class)->middleware('auth:api');
Route::apiResource('barang', BarangController::class)->middleware('auth:api');
Route::post('/barangKosong/{id}/tambahBarang', [BarangController::class, 'tambahBarang'])->middleware('auth:api');


Route::apiResource('admin', AdminController::class)->middleware('auth:api');
Route::apiResource('profil', ProfilController::class)->middleware('auth:api');
Route::delete('profil/{id}/destroy-image', [ProfilController::class, 'destroyImage'])->middleware('auth:api');
Route::post('/profil/{id}/ganti-password', [ProfilController::class, 'gantiPassword'])->middleware('auth:api');


Route::apiResource('laporan', laporanController::class)->middleware('auth:api');
Route::apiResource('barangRusak', LaporanBarangRusakController::class)->middleware('auth:api');
Route::apiResource('barangKosong', LaporanBarangKosongController::class)->middleware('auth:api');
Route::apiResource('pesanan', LaporanPesananBarangController::class)->middleware('auth:api');
Route::get('/pesanan/{id}/user', [LaporanPesananBarangController::class, 'pesananUser'])->middleware('auth:api');

// Route::apiResource('pesananUser', PesananController::class)->middleware('auth:api');
