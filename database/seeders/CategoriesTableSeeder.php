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
            ['name_categiries' => 'Kertas HVS', 'created_at' => now(), 'updated_at' => now()],
            ['name_categiries' => 'Kertas Art Paper', 'created_at' => now(), 'updated_at' => now()],
            ['name_categiries' => 'Kertas Glossy', 'created_at' => now(), 'updated_at' => now()],
            ['name_categiries' => 'Kertas Matt', 'created_at' => now(), 'updated_at' => now()],

            // Alat Tulis
            ['name_categiries' => 'Pensil', 'created_at' => now(), 'updated_at' => now()],
            ['name_categiries' => 'Pulpen', 'created_at' => now(), 'updated_at' => now()],
            ['name_categiries' => 'Penghapus', 'created_at' => now(), 'updated_at' => now()],
            ['name_categiries' => 'Tip-X', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
