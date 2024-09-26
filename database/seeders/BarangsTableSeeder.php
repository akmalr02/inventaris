<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barangs')->insert([

            [
                'name' => 'Kertas HVS 80gsm A4',
                'categories_id' => 1, // Kertas HVS
                'description' => 'Kertas HVS 80 gram ukuran A4 untuk keperluan cetak dokumen.',
                'image' => json_encode(['hvs_a4_80gsm.jpg']),
                'jumlah' => 500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kertas Glossy A4',
                'categories_id' => 3, // Kertas Glossy
                'description' => 'Kertas glossy ukuran A4 untuk cetak foto dan dokumen berkualitas.',
                'image' => json_encode(['glossy_a4.jpg']),
                'jumlah' => 300,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'Pensil 2B',
                'categories_id' => 5, // Pensil
                'description' => 'Pensil 2B untuk keperluan tulis-menulis dan gambar.',
                'image' => json_encode(['pensil_2b.jpg']),
                'jumlah' => 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pulpen Hitam',
                'categories_id' => 6, // Pulpen
                'description' => 'Pulpen tinta hitam untuk kebutuhan tulis-menulis.',
                'image' => json_encode(['pulpen_hitam.jpg']),
                'jumlah' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Penghapus Karet',
                'categories_id' => 7, // Penghapus
                'description' => 'Penghapus karet putih untuk membersihkan tulisan pensil.',
                'image' => json_encode(['penghapus_karet.jpg']),
                'jumlah' => 150,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'Laptop Lenovo ThinkPad',
                'categories_id' => 9, // Komputer
                'description' => 'Laptop Lenovo ThinkPad dengan RAM 16GB dan SSD 512GB.',
                'image' => json_encode(['laptop_lenovo_thinkpad.jpg']),
                'jumlah' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Printer Canon Pixma',
                'categories_id' => 10, // Printer
                'description' => 'Printer Canon Pixma untuk kebutuhan cetak dokumen dan foto.',
                'image' => json_encode(['printer_canon_pixma.jpg']),
                'jumlah' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'Kertas Art Paper 100gsm A3',
                'categories_id' => 2, // Kertas Art Paper
                'description' => 'Kertas Art Paper 100 gram ukuran A3 untuk cetak poster dan brosur.',
                'image' => json_encode(['artpaper_a3.jpg']),
                'jumlah' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Laptop Dell Inspiron',
                'categories_id' => 9, // Komputer
                'description' => 'Laptop Dell Inspiron dengan RAM 8GB dan HDD 1TB.',
                'image' => json_encode(['laptop_dell_inspiron.jpg']),
                'jumlah' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Printer Epson L3110',
                'categories_id' => 10, // Printer
                'description' => 'Printer Epson L3110 untuk cetak, scan, dan copy dengan tinta eco-tank.',
                'image' => json_encode(['printer_epson_l3110.jpg']),
                'jumlah' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pulpen Biru',
                'categories_id' => 6, // Pulpen
                'description' => 'Pulpen tinta biru untuk keperluan tulis-menulis.',
                'image' => json_encode(['pulpen_biru.jpg']),
                'jumlah' => 250,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
