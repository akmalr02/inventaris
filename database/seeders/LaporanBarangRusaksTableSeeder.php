<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanBarangRusaksTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('laporan_barang_rusaks')->insert([
            [
                'nama_barang' => 'Printer XYZ', // Ganti dengan nama barang yang sesuai
                'description' => 'Printer tidak bisa mencetak',
                'tanggal' => now()->toDateString(),
                'image' => json_encode(['foto1.jpg', 'foto2.jpg']), // Ganti dengan nama file foto yang sesuai
                'user_id' => 1, // Ganti dengan ID pengguna yang sesuai
            ],
            [
                'nama_barang' => 'Komputer ABC', // Ganti dengan nama barang yang sesuai
                'description' => 'Komputer sering mati sendiri',
                'tanggal' => now()->toDateString(),
                'image' => json_encode(['foto3.jpg']), // Ganti dengan nama file foto yang sesuai
                'user_id' => 2, // Ganti dengan ID pengguna yang sesuai
            ],
            // Tambahkan lebih banyak data sesuai kebutuhan
        ]);
    }
}
