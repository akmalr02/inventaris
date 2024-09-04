<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporansTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('laporans')->insert([
            [
                'laporan_barang_rusak_id' => 1, // Referensi ke laporan_barang_rusaks
                'laporan_barang_kosong_id' => null,
                'pesanan_barang_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'laporan_barang_rusak_id' => null,
                'laporan_barang_kosong_id' => 1, // Referensi ke laporan_barang_kosongs
                'pesanan_barang_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'laporan_barang_rusak_id' => null,
                'laporan_barang_kosong_id' => null,
                'pesanan_barang_id' => 1, // Referensi ke pesanan_barangs
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'laporan_barang_rusak_id' => 2, // Referensi ke laporan_barang_rusaks
                'laporan_barang_kosong_id' => 2, // Referensi ke laporan_barang_kosongs
                'pesanan_barang_id' => 2, // Referensi ke pesanan_barangs
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan lebih banyak data sesuai kebutuhan
        ]);
    }
}
