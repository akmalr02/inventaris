<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => "08435839835",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pengelola User',
                'email' => 'pengelola@example.com',
                'password' => Hash::make('password'),
                'role' => 'pengelola',
                'phone' => "08435839835",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pemakai User',
                'email' => 'pemakai@example.com',
                'password' => Hash::make('password'),
                'role' => 'pemakai',
                'phone' => "08435839835",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
