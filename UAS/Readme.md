Berikut adalah langkah-langkah lengkap untuk membuat **migration**, **seeder**, dan **model** untuk aplikasi EcoMarket berbasis Laravel:

---

### **Langkah 1: Setup Project Laravel**
1. **Buat Project Laravel Baru**:
   Jika Anda belum memiliki project Laravel, buat project baru dengan perintah berikut:
   ```bash
   composer create-project laravel/laravel EcoMarket
   cd EcoMarket
   ```

2. **Setup Database**:
   - Buka file `.env` di root project Laravel.
   - Konfigurasi koneksi database Anda:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=ecomarket
     DB_USERNAME=root
     DB_PASSWORD=
     ```
   - Pastikan database `ecomarket` sudah dibuat di MySQL.

---

### **Langkah 2: Buat Migration**
1. **Buat Migration untuk Tabel `users`**:
   ```bash
   php artisan make:migration create_users_table
   ```
   - Edit file migration yang baru dibuat di folder `database/migrations`:
     ```php
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

2. **Buat Migration untuk Tabel `categories`**:
   ```bash
   php artisan make:migration create_categories_table
   ```
   - Edit file migration:
     ```php
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

3. **Buat Migration untuk Tabel `products`**:
   ```bash
   php artisan make:migration create_products_table
   ```
   - Edit file migration:
     ```php
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

4. **Buat Migration untuk Tabel `transactions`**:
   ```bash
   php artisan make:migration create_transactions_table
   ```
   - Edit file migration:
     ```php
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

5. **Buat Migration untuk Tabel `reviews`**:
   ```bash
   php artisan make:migration create_reviews_table
   ```
   - Edit file migration:
     ```php
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

6. **Jalankan Migration**:
   Setelah semua migration dibuat, jalankan perintah berikut untuk membuat tabel di database:
   ```bash
   php artisan migrate
   ```

---

### **Langkah 3: Buat Model**
1. **Buat Model `User`**:
   ```bash
   php artisan make:model User
   ```
   - Edit file `app/Models/User.php`:
     ```php
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

2. **Buat Model `Category`**:
   ```bash
   php artisan make:model Category
   ```
   - Edit file `app/Models/Category.php`:
     ```php
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

3. **Buat Model `Product`**:
   ```bash
   php artisan make:model Product
   ```
   - Edit file `app/Models/Product.php`:
     ```php
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

4. **Buat Model `Transaction`**:
   ```bash
   php artisan make:model Transaction
   ```
   - Edit file `app/Models/Transaction.php`:
     ```php
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

5. **Buat Model `Review`**:
   ```bash
   php artisan make:model Review
   ```
   - Edit file `app/Models/Review.php`:
     ```php
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

---

### **Langkah 4: Buat Seeder**
1. **Buat Seeder untuk `User`**:
   ```bash
   php artisan make:seeder UserSeeder
   ```
   - Edit file `database/seeders/UserSeeder.php`:
     ```php
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

2. **Buat Seeder untuk `Category`**:
   ```bash
   php artisan make:seeder CategorySeeder
   ```
   - Edit file `database/seeders/CategorySeeder.php`:
     ```php
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

3. **Buat Seeder untuk `Product`**:
   ```bash
   php artisan make:seeder ProductSeeder
   ```
   - Edit file `database/seeders/ProductSeeder.php`:
     ```php
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

4. **Buat Seeder untuk `Transaction`**:
   ```bash
   php artisan make:seeder TransactionSeeder
   ```
   - Edit file `database/seeders/TransactionSeeder.php`:
     ```php
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

5. **Buat Seeder untuk `Review`**:
   ```bash
   php artisan make:seeder ReviewSeeder
   ```
   - Edit file `database/seeders/ReviewSeeder.php`:
     ```php
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

6. **Jalankan Seeder**:
   Jalankan semua seeder dengan perintah berikut:
   ```bash
   php artisan db:seed --class=UserSeeder
   php artisan db:seed --class=CategorySeeder
   php artisan db:seed --class=ProductSeeder
   php artisan db:seed --class=TransactionSeeder
   php artisan db:seed --class=ReviewSeeder
   ```

---

### **Langkah 5: Testing**
1. **Cek Database**:
   Buka database Anda (misalnya menggunakan phpMyAdmin atau MySQL CLI) dan pastikan semua tabel dan data sudah terisi dengan benar.

2. **Cek Relasi**:
   Pastikan relasi antara tabel (misalnya `users` dengan `products`, `products` dengan `categories`, dll.) berfungsi dengan baik.

---

Dengan mengikuti langkah-langkah di atas, Anda telah berhasil membuat migration, seeder, dan model untuk aplikasi EcoMarket berbasis Laravel. Selanjutnya, Anda dapat melanjutkan dengan pengembangan fitur-fitur lainnya seperti autentikasi, CRUD, dan integrasi frontend.