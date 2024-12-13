Berikut adalah implementasi **migration**, **model**, dan **seeder** untuk kebutuhan Anda menggunakan Laravel:

---

### 1. **Migration**
#### **Migration untuk `categories`**
Buat file migration untuk tabel `categories`:
```php
php artisan make:migration create_categories_table
```

Isi file migration:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['Sepatu', 'Celana', 'Baju'])->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
```

#### **Migration untuk `products`**
Buat file migration untuk tabel `products`:
```php
php artisan make:migration create_products_table
```

Isi file migration:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

---

### 2. **Model**
#### **Model untuk `Category`**
Buat file model untuk kategori:
```bash
php artisan make:model Category
```

Isi file `Category.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```

#### **Model untuk `Product`**
Buat file model untuk produk:
```bash
php artisan make:model Product
```

Isi file `Product.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

---

### 3. **Seeder**
#### **Seeder untuk `Category`**
Buat file seeder:
```bash
php artisan make:seeder CategorySeeder
```

Isi file `CategorySeeder.php`:
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Sepatu', 'Celana', 'Baju'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
```

#### **Seeder untuk `Product`**
Buat file seeder:
```bash
php artisan make:seeder ProductSeeder
```

Isi file `ProductSeeder.php`:
```php
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
```

---

### 4. **Jalankan Migration dan Seeder**
Setelah selesai, jalankan perintah berikut:
```bash
php artisan migrate --seed
```

Atau jalankan seed secara manual:
```bash
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
```

---

### 5. **Hasil Akhir**
- **Tabel `categories`** akan memiliki data kategori `Sepatu`, `Celana`, `Baju`.
- **Tabel `products`** akan memiliki data produk dengan relasi ke kategori masing-masing.
