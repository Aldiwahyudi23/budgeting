<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk kategori "Saving"
        DB::table('categories')->insert([
            'name' => 'Saving',
            'description' => 'Kategori untuk menyimpan uang.',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data untuk kategori "Bill"
        DB::table('categories')->insert(
            [
                'name' => 'Bill',
                'description' => 'Kategori untuk tagihan bulanan.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
