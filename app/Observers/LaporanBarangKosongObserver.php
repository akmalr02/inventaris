<?php

namespace App\Observers;

use App\Models\Laporan;
use App\Models\LaporanBarangKosong;

class LaporanBarangKosongObserver
{
    /**
     * Handle the LaporanBarangKosong "created" event.
     */
    public function created(LaporanBarangKosong $laporanBarangKosong): void
    {
        Laporan::create([
            'user_id' => $laporanBarangKosong->user_id,
            'laporan_barang_kosong_id' => $laporanBarangKosong->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Handle the LaporanBarangKosong "updated" event.
     */
    public function updated(LaporanBarangKosong $laporanBarangKosong): void
    {
        //
    }

    /**
     * Handle the LaporanBarangKosong "deleted" event.
     */
    public function deleted(LaporanBarangKosong $laporanBarangKosong): void
    {
        Laporan::where('laporan_barang_kosong_id', $laporanBarangKosong->id)->delete();
    }

    /**
     * Handle the LaporanBarangKosong "restored" event.
     */
    public function restored(LaporanBarangKosong $laporanBarangKosong): void
    {
        //
    }

    /**
     * Handle the LaporanBarangKosong "force deleted" event.
     */
    public function forceDeleted(LaporanBarangKosong $laporanBarangKosong): void
    {
        //
    }
}
