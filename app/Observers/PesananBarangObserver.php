<?php

namespace App\Observers;

use App\Models\Laporan;
use App\Models\PesananBarang;

class PesananBarangObserver
{
    /**
     * Handle the PesananBarang "created" event.
     */
    public function created(PesananBarang $pesananBarang): void
    {
        Laporan::create([
            'user_id' => $pesananBarang->user_id,
            'pesanan_barang_id' => $pesananBarang->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Handle the PesananBarang "updated" event.
     */
    public function updated(PesananBarang $pesananBarang): void
    {
        //
    }

    /**
     * Handle the PesananBarang "deleted" event.
     */
    public function deleted(PesananBarang $pesananBarang): void
    {
        Laporan::where('pesanan_barang_id', $pesananBarang->id)->delete();
    }

    /**
     * Handle the PesananBarang "restored" event.
     */
    public function restored(PesananBarang $pesananBarang): void
    {
        //
    }

    /**
     * Handle the PesananBarang "force deleted" event.
     */
    public function forceDeleted(PesananBarang $pesananBarang): void
    {
        //
    }
}
