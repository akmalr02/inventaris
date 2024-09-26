<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function laporanBarangRusak(): BelongsTo
    {
        return $this->belongsTo(LaporanBarangRusak::class, 'laporan_barang_rusak_id');
    }

    // Relasi ke LaporanBarangKosong
    public function laporanBarangKosong(): BelongsTo
    {
        return $this->belongsTo(LaporanBarangKosong::class, 'laporan_barang_kosong_id');
    }

    // Relasi ke PesananBarang
    public function pesananBarang(): BelongsTo
    {
        return $this->belongsTo(PesananBarang::class, 'pesanan_barang_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
