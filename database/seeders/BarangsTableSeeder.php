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
                'name' => 'Barang A',
                'description' => 'description Barang A',
                'categories_id' => 1, // Asumsikan kategori dengan ID 1 ada
                'image' => json_encode(['gambar_a1.jpg', 'gambar_a2.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Barang B',
                'description' => 'description Barang B',
                'categories_id' => 2, // Asumsikan kategori dengan ID 2 ada
                'image' => json_encode(['gambar_a1.jpg', 'gambar_a2.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Barang C',
                'description' => 'description Barang C',
                'categories_id' => 1, // Asumsikan kategori dengan ID 1 ada
                'image' => json_encode(['gambar_a1.jpg', 'gambar_a2.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
