# Migration Seeder Model

### Migration 
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->enum('category', ['Sepatu', 'Celana', 'Baju']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
```
### Seeder
```php
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
```
### Model
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category',
    ];
}
```