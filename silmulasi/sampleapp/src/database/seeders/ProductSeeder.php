<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Nike Air Max', 'price' => 1200000, 'category' => 'Sepatu', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Levi’s Jeans', 'price' => 800000, 'category' => 'Celana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Polo Shirt', 'price' => 450000, 'category' => 'Baju', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}