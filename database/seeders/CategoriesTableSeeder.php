<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            // Jenis Kertas untuk Perkantoran
            ['name' => 'Kertas HVS', 'description' => 'Kertas HVS untuk keperluan kantor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kertas Art Paper', 'description' => 'Kertas Art Paper yang biasa digunakan untuk desain', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kertas Glossy', 'description' => 'Kertas dengan permukaan glossy untuk mencetak gambar', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kertas Matt', 'description' => 'Kertas dengan permukaan matt tanpa kilap', 'created_at' => now(), 'updated_at' => now()],

            // Alat Tulis
            ['name' => 'Pensil', 'description' => 'Pensil untuk menulis dan menggambar', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pulpen', 'description' => 'Pulpen untuk menulis di atas kertas', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penghapus', 'description' => 'Penghapus untuk menghapus tulisan pensil', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tip-X', 'description' => 'Tip-X untuk mengoreksi kesalahan tulisan', 'created_at' => now(), 'updated_at' => now()],

            // Komputer dan Printer
            ['name' => 'Komputer', 'description' => 'Komputer untuk keperluan perkantoran', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Printer', 'description' => 'Printer untuk mencetak dokumen dan gambar', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
