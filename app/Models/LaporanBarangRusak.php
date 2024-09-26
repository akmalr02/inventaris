<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaporanBarangRusak extends Model
{
    use HasFactory;

    protected $table = 'laporan_barang_rusaks';
    protected $guarded = ['id'];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'laporan_barang_rusak_id');
    }
}
