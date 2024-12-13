___
# Analisis

### 1. Jabarkan Produk Berdasarkan Nama
Setiap produk memiliki atribut **nama**, yang menggunakan tipe data `string`.

### 2. Harga Produk
Setiap produk memiliki atribut **harga**, yang menggunakan tipe data `int`.

### 3. Kategori Produk
Setiap produk memiliki atribut **kategori**, yang menggunakan tipe data `enum`.

### 4. Relasi Kategori Berdasarkan Nama Produk
Relasi kategori diintegrasikan langsung ke dalam tabel produk dengan atribut `kategori` menggunakan tipe data enum.

### 5. Kategori dengan Enum
Kategori memiliki opsi berbentuk **enum** dengan nilai: `Sepatu`, `Celana`, dan `Baju`.

Berikut adalah struktur tabel yang diimplementasikan tanpa memisahkan kategori ke tabel terpisah:

#### Struktur Database
```sql
-- Tabel Produk dengan Kategori
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    category ENUM('Sepatu', 'Celana', 'Baju') NOT NULL
);
```

#### Contoh Data
```sql
-- Data Produk
INSERT INTO products (name, price, category) VALUES
('Nike Air Max', 1200000, 'Sepatu'),
('Levi’s Jeans', 800000, 'Celana'),
('Polo Shirt', 450000, 'Baju');
```

#### Output Relasi Dengan Query
Untuk melihat nama produk dan kategorinya:
```sql
SELECT name AS Produk, price AS Harga, category AS Kategori
FROM products;
```

Hasilnya akan berupa tabel:
| Produk        | Harga     | Kategori |
|---------------|-----------|----------|
| Nike Air Max  | 1200000   | Sepatu   |
| Levi’s Jeans  | 800000    | Celana   |
| Polo Shirt    | 450000    | Baju     |
---

# Implementasi Migration, Seeder, dan Model

#### 1. Jalankan docker
Lalu masuk ke dalam container bash
```bash
docker exec -it nama countainer_anda bash
```
#### 2. Masukkan perintah
```bash
composer create-project --prefer-dist raugadh/fila-starter .
```
Lalu modifikasi .env di dalam src seperti ini:
```php
APP_NAME="Fila Starter"
APP_ENV=local
APP_KEY=base64:yDnbWea8ay1kHjvoQAJvJ+j5NnVvNtr1X11LDKPVexk=
APP_DEBUG=true
APP_TIMEZONE='Asia/jakarta'
APP_URL=http://localhost
ASSET_URL=http://localhost
DEBUGBAR_ENABLED=false
ASSET_PREFIX=
# ASSET_PREFIX=/dev/kit/public example incase deployed inside a sub-folder

APP_LOCALE=en_IN
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_IN

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=test
DB_USERNAME=root
DB_PASSWORD=p455w0rd

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=True
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```
Setelahnya masukkan perintah:
```bash
php artisan key:generate
php artisan storage:link
php artisan migrate
chown -R www-data:www-data storage/*
chown -R www-data:www-data bootstrap/*
php artisan project:init
```

#### 3. Membuat Migration
Gunakan perintah berikut untuk membuat file migration:
```bash
php artisan make:migration create_products_table
```
Lalu, modifikasi file migration seperti ini:
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
---
#### 4. Membuat Seeder
Gunakan perintah berikut untuk membuat file seeder:
```bash
php artisan make:seeder ProductSeeder
```
Lalu, modifikasi file seeder seperti ini:
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
---
#### 5. Membuat Model
Gunakan perintah berikut untuk membuat model:
```bash
php artisan make:model Product
```
Lalu, modifikasi file model seperti ini:
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
#### 6. Generate Filament Resource
```bash
php artisan make:filament-resource Product --generate
```

#### 7. Langkah Penyelesaian:
```bash
php artisan project:init
```
#### 8. Generate seeder
```bash
php artisan db:seed --class=ProductSeeder
```
___
# localhost dapat di gunakan