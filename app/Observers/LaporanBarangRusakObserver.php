<?php

namespace App\Observers;

use App\Models\Laporan;
use App\Models\LaporanBarangRusak;

class LaporanBarangRusakObserver
{
    /**
     * Handle the LaporanBarangRusak "created" event.
     */
    public function created(LaporanBarangRusak $laporanBarangRusak): void
    {
        Laporan::create([
            'user_id' => $laporanBarangRusak->user_id,
            'laporan_barang_rusak_id' => $laporanBarangRusak->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Handle the LaporanBarangRusak "updated" event.
     */
    public function updated(LaporanBarangRusak $laporanBarangRusak): void
    {
        //
    }

    /**
     * Handle the LaporanBarangRusak "deleted" event.
     */
    public function deleted(LaporanBarangRusak $laporanBarangRusak): void
    {
        Laporan::where('laporan_barang_rusak_id', $laporanBarangRusak->id)->delete();
    }

    /**
     * Handle the LaporanBarangRusak "restored" event.
     */
    public function restored(LaporanBarangRusak $laporanBarangRusak): void
    {
        //
    }

    /**
     * Handle the LaporanBarangRusak "force deleted" event.
     */
    public function forceDeleted(LaporanBarangRusak $laporanBarangRusak): void
    {
        //
    }
}
