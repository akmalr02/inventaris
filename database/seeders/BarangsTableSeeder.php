<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barangs')->insert([
            [
                'name' => 'Kertas HVS A4',
                'description' => 'Kertas HVS ukuran A4, cocok untuk dokumen sehari-hari.',
                'categories_id' => 1, // ID kategori Kertas HVS
                'image' => json_encode(['image1.jpg', 'image2.jpg']),
                'jumlah' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kertas Art Paper A4',
                'description' => 'Kertas Art Paper ukuran A4 untuk cetak foto dan brosur.',
                'categories_id' => 1, // ID kategori Kertas Art Paper
                'image' => json_encode(['artpaper1.jpg']),
                'jumlah' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kertas Glossy A4',
                'description' => 'Kertas Glossy ukuran A4, ideal untuk cetak gambar berkualitas tinggi.',
                'categories_id' => 1, // ID kategori Kertas Glossy
                'image' => json_encode(['glossy1.jpg']),
                'jumlah' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kertas Matt A4',
                'description' => 'Kertas Matt ukuran A4, cocok untuk cetak dokumen dan laporan.',
                'categories_id' => 1, // ID kategori Kertas Matt
                'image' => json_encode(['matt1.jpg']),
                'jumlah' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pensil 2B',
                'description' => 'Pensil 2B, ideal untuk menggambar dan menulis.',
                'categories_id' => 2, // ID kategori Pensil
                'image' => json_encode(['pencil1.jpg']),
                'jumlah' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pulpen Bic Biru',
                'description' => 'Pulpen Bic dengan tinta biru, ideal untuk menulis sehari-hari.',
                'categories_id' => 2, // ID kategori Pulpen
                'image' => json_encode(['pen2.jpg']),
                'jumlah' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Penghapus Rapi',
                'description' => 'Penghapus rapi yang efisien untuk menghapus kesalahan tulisan.',
                'categories_id' => 3, // ID kategori Penghapus
                'image' => json_encode(['eraser2.jpg']),
                'jumlah' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tip-X Korektor',
                'description' => 'Tip-X korektor dengan aplikator mudah digunakan.',
                'categories_id' => 4, // ID kategori Tip-X
                'image' => json_encode(['tipx2.jpg']),
                'jumlah' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kertas Karton A4',
                'description' => 'Kertas Karton ukuran A4, cocok untuk pembuatan kartu dan kerajinan.',
                'categories_id' => 1, // ID kategori Kertas Karton
                'image' => json_encode(['karton1.jpg']),
                'jumlah' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kertas Kraft A4',
                'description' => 'Kertas Kraft ukuran A4, sering digunakan untuk kemasan dan proyek kerajinan.',
                'categories_id' => 1, // ID kategori Kertas Kraft
                'image' => json_encode(['kraft1.jpg']),
                'jumlah' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
