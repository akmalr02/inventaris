<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function laporanBarangRusak()
    {
        return $this->belongsTo(LaporanBarangRusak::class);
    }

    // Relasi ke LaporanBarangKosong
    public function laporanBarangKosong()
    {
        return $this->belongsTo(LaporanBarangKosong::class);
    }

    // Relasi ke PesananBarang
    public function pesananBarang()
    {
        return $this->belongsTo(PesananBarang::class);
    }
}
