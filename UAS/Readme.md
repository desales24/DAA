Untuk membuat migration, seeder, dan model berdasarkan dokumen yang diberikan, kita perlu mengidentifikasi entitas utama yang akan diimplementasikan dalam database. Berdasarkan dokumen, entitas utama yang terlibat adalah:

1. **User** (Konsumen, Produsen, Administrator)
2. **Product** (Barang Daur Ulang, Produk Organik, Energi Terbarukan)
3. **Transaction** (Transaksi antara Konsumen dan Produsen)
4. **Category** (Kategori Produk: Barang Daur Ulang, Produk Organik, Energi Terbarukan)
5. **Review** (Ulasan dan Rating dari Konsumen)

Berikut adalah contoh implementasi migration, seeder, dan model untuk setiap entitas tersebut menggunakan Laravel.

### 1. Migration

#### a. Users Table
```php
// database/migrations/xxxx_xx_xx_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['consumer', 'producer', 'admin'])->default('consumer');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```

#### b. Products Table
```php
// database/migrations/xxxx_xx_xx_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->integer('stock');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
```

#### c. Categories Table
```php
// database/migrations/xxxx_xx_xx_create_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
```

#### d. Transactions Table
```php
// database/migrations/xxxx_xx_xx_create_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('total_price', 8, 2);
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
```

#### e. Reviews Table
```php
// database/migrations/xxxx_xx_xx_create_reviews_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
```

### 2. Seeder

#### a. Users Seeder
```php
// database/seeders/UserSeeder.php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ecomarket.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Producer',
            'email' => 'producer@ecomarket.com',
            'password' => bcrypt('password'),
            'role' => 'producer',
        ]);

        User::create([
            'name' => 'Consumer',
            'email' => 'consumer@ecomarket.com',
            'password' => bcrypt('password'),
            'role' => 'consumer',
        ]);
    }
}
```

#### b. Categories Seeder
```php
// database/seeders/CategorySeeder.php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Barang Daur Ulang']);
        Category::create(['name' => 'Produk Organik']);
        Category::create(['name' => 'Energi Terbarukan']);
    }
}
```

#### c. Products Seeder
```php
// database/seeders/ProductSeeder.php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'user_id' => 2, // Producer
            'category_id' => 1, // Barang Daur Ulang
            'name' => 'Tas dari Plastik Daur Ulang',
            'description' => 'Tas ramah lingkungan yang terbuat dari plastik daur ulang.',
            'price' => 150000,
            'stock' => 50,
        ]);

        Product::create([
            'user_id' => 2, // Producer
            'category_id' => 2, // Produk Organik
            'name' => 'Sayuran Organik',
            'description' => 'Sayuran organik segar langsung dari petani lokal.',
            'price' => 20000,
            'stock' => 100,
        ]);

        Product::create([
            'user_id' => 2, // Producer
            'category_id' => 3, // Energi Terbarukan
            'name' => 'Panel Surya',
            'description' => 'Panel surya dengan efisiensi tinggi untuk rumah tangga.',
            'price' => 5000000,
            'stock' => 10,
        ]);
    }
}
```

#### d. Transactions Seeder
```php
// database/seeders/TransactionSeeder.php

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        Transaction::create([
            'user_id' => 3, // Consumer
            'product_id' => 1, // Tas dari Plastik Daur Ulang
            'quantity' => 2,
            'total_price' => 300000,
            'status' => 'completed',
        ]);

        Transaction::create([
            'user_id' => 3, // Consumer
            'product_id' => 2, // Sayuran Organik
            'quantity' => 5,
            'total_price' => 100000,
            'status' => 'pending',
        ]);
    }
}
```

#### e. Reviews Seeder
```php
// database/seeders/ReviewSeeder.php

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        Review::create([
            'user_id' => 3, // Consumer
            'product_id' => 1, // Tas dari Plastik Daur Ulang
            'rating' => 5,
            'comment' => 'Produk sangat bagus dan ramah lingkungan!',
        ]);

        Review::create([
            'user_id' => 3, // Consumer
            'product_id' => 2, // Sayuran Organik
            'rating' => 4,
            'comment' => 'Sayuran segar dan berkualitas.',
        ]);
    }
}
```

### 3. Model

#### a. User Model
```php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
```

#### b. Product Model
```php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'name', 'description', 'price', 'stock', 'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
```

#### c. Category Model
```php
// app/Models/Category.php

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

#### d. Transaction Model
```php
// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'quantity', 'total_price', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

#### e. Review Model
```php
// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'rating', 'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

### 4. Running Migrations and Seeders

Setelah membuat migration dan seeder, jalankan perintah berikut untuk menjalankan migrasi dan mengisi database dengan data awal:

```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
php artisan db:seed --class=TransactionSeeder
php artisan db:seed --class=ReviewSeeder
```

Dengan ini, Anda telah berhasil membuat migration, seeder, dan model untuk aplikasi EcoMarket berbasis Laravel.