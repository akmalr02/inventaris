<?php

namespace App\Models;

use App\Models\Laporan;
use App\Models\Category;
use App\Models\PesananBarang;
use App\Models\LaporanBarangKosong;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $guarded = ['id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function barangkosong(): HasMany
    {
        return $this->hasMany(LaporanBarangKosong::class);
    }

    public function pesananBarang(): HasMany
    {
        return $this->hasMany(PesananBarang::class);
    }

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }
}
