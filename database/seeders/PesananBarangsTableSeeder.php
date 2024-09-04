<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PesananBarangsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pesanan_barangs')->insert([
            [
                'barang_id' => 1, // Ganti dengan ID barang yang sesuai
                'description' => 'Pesanan untuk kantor pusat',
                'tanggal' => now()->toDateString(),
                'jumlah_pesanan' => 50,
                'user_id' => 1, // Ganti dengan ID pengguna yang sesuai
            ],
            [
                'barang_id' => 2, // Ganti dengan ID barang yang sesuai
                'description' => 'Pesanan untuk cabang A',
                'tanggal' => now()->toDateString(),
                'jumlah_pesanan' => 20,
                'user_id' => 2, // Ganti dengan ID pengguna yang sesuai
            ],
            // Tambahkan lebih banyak data sesuai kebutuhan
        ]);
    }
}
