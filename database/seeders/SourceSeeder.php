<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Panggil seeder yang telah Anda buat
        $this->call([
            CategorySeeder::class,
            // Tambahkan seeder lain di sini jika ada
        ]);
    }
}
