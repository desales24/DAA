<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Nike Air Max', 'price' => 1200000, 'category' => 'Sepatu'],
            ['name' => 'Levi’s Jeans', 'price' => 800000, 'category' => 'Celana'],
            ['name' => 'Polo Shirt', 'price' => 450000, 'category' => 'Baju'],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category'])->first();
            Product::create([
                'name' => $product['name'],
                'price' => $product['price'],
                'category_id' => $category->id,
            ]);
        }
    }
}
