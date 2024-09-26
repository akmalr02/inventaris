<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'categories';


    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
