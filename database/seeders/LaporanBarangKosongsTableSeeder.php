<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanBarangKosongsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('laporan_barang_kosongs')->insert([
            [
                'barang_id' => 1, // Ganti dengan ID barang yang sesuai
                'description' => 'Laporan barang kosong untuk printer',
                'tanggal' => now()->toDateString(),
                'user_id' => 1, // Ganti dengan ID pengguna yang sesuai
            ],
            [
                'barang_id' => 3, // Ganti dengan ID barang yang sesuai
                'description' => 'Laporan barang kosong untuk tinta printer',
                'tanggal' => now()->toDateString(),
                'user_id' => 2, // Ganti dengan ID pengguna yang sesuai
            ],
            // Tambahkan lebih banyak data sesuai kebutuhan
        ]);
    }
}
