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
            ['name_categories' => 'Kertas HVS', 'created_at' => now(), 'updated_at' => now()],
            ['name_categories' => 'Kertas Art Paper', 'created_at' => now(), 'updated_at' => now()],
            ['name_categories' => 'Kertas Glossy', 'created_at' => now(), 'updated_at' => now()],
            ['name_categories' => 'Kertas Matt', 'created_at' => now(), 'updated_at' => now()],

            // Alat Tulis
            ['name_categories' => 'Pensil', 'created_at' => now(), 'updated_at' => now()],
            ['name_categories' => 'Pulpen', 'created_at' => now(), 'updated_at' => now()],
            ['name_categories' => 'Penghapus', 'created_at' => now(), 'updated_at' => now()],
            ['name_categories' => 'Tip-X', 'created_at' => now(), 'updated_at' => now()],

            // Komputer dan Printer
            ['name_categories' => 'Komputer', 'created_at' => now(), 'updated_at' => now()],
            ['name_categories' => 'Printer', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
