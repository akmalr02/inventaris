<?php

namespace App\Providers;

use App\Models\PesananBarang;
use App\Models\LaporanBarangRusak;
use App\Models\LaporanBarangKosong;
use Illuminate\Support\ServiceProvider;
use App\Observers\PesananBarangObserver;
use App\Observers\LaporanBarangRusakObserver;
use App\Observers\LaporanBarangKosongObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LaporanBarangKosong::observe(LaporanBarangKosongObserver::class);
        LaporanBarangRusak::observe(LaporanBarangRusakObserver::class);
        PesananBarang::observe(PesananBarangObserver::class);
    }
}
