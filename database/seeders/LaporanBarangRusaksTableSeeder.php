<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanBarangRusaksTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('laporan_barang_rusaks')->insert([
            // Data sebelumnya
            [
                'user_id' => 1,
                'barang_id' => 1,
                'description' => 'Terdapat robekan pada beberapa lembar kertas.',
                'tanggal' => Carbon::now()->subDays(2),
                'image' => json_encode(['rusak_kertas_hvs.jpg']),
                'jumlah_rusak' => 50,
                'kondisi' => 'Ringan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'barang_id' => 6,
                'description' => 'Pulpen tidak bisa mengeluarkan tinta.',
                'tanggal' => Carbon::now()->subDays(3),
                'image' => json_encode(['rusak_pulpen_hitam.jpg']),
                'jumlah_rusak' => 20,
                'kondisi' => 'Sedang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'barang_id' => 9,
                'description' => 'Keyboard tidak berfungsi dengan baik.',
                'tanggal' => Carbon::now()->subDays(1),
                'image' => json_encode(['rusak_laptop_lenovo.jpg']),
                'jumlah_rusak' => 1,
                'kondisi' => 'Berat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'barang_id' => 7,
                'description' => 'Penghapus robek saat digunakan.',
                'tanggal' => Carbon::now()->subDays(5),
                'image' => json_encode(['rusak_penghapus_karet.jpg']),
                'jumlah_rusak' => 10,
                'kondisi' => 'Ringan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'barang_id' => 10,
                'description' => 'Printer mengalami masalah pada sensor kertas.',
                'tanggal' => Carbon::now()->subDays(4),
                'image' => json_encode(['rusak_printer_canon_pixma.jpg']),
                'jumlah_rusak' => 1,
                'kondisi' => 'Berat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Data tambahan
            [
                'user_id' => 2,
                'barang_id' => 3, // ID Barang (Kertas Glossy)
                'description' => 'Beberapa lembar kertas basah karena bocoran air.',
                'tanggal' => Carbon::now()->subDays(7),
                'image' => json_encode(['rusak_kertas_glossy.jpg']),
                'jumlah_rusak' => 30,
                'kondisi' => 'Sedang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'barang_id' => 5, // ID Barang (Penghapus)
                'description' => 'Penghapus hilang saat digunakan.',
                'tanggal' => Carbon::now()->subDays(6),
                'image' => json_encode(['rusak_penghapus.jpg']),
                'jumlah_rusak' => 5,
                'kondisi' => 'Ringan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'barang_id' => 8, // ID Barang (Tip-X)
                'description' => 'Tip-X bocor saat akan digunakan.',
                'tanggal' => Carbon::now()->subDays(3),
                'image' => json_encode(['rusak_tip_x.jpg']),
                'jumlah_rusak' => 15,
                'kondisi' => 'Berat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
