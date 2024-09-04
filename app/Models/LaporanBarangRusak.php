<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanBarangRusak extends Model
{
    use HasFactory;

    protected $table = 'laporan_barang_rusaks';
    protected $guarded = [''];

    protected $fillable = [
        'nama_barang',
        'description',
        'tangal',
        'user_id'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
