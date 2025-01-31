Berikut adalah versi lengkap dari **migration**, **seeder**, dan **model** untuk sistem manajemen atlet angkat beban, termasuk entitas **Atlet**, **Pelatih**, **Program Pelatihan**, **Penilaian**, dan **Kompetisi**.

---

### 1. Migration

#### a. Migration untuk Tabel `athletes`

```php
// database/migrations/2023_10_01_create_athletes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAthletesTable extends Migration
{
    public function up()
    {
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->string('category'); // Junior, Senior, Master
            $table->string('weight_category'); // Kategori berat badan
            $table->text('training_history')->nullable();
            $table->text('performance_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('athletes');
    }
}
```

#### b. Migration untuk Tabel `coaches`

```php
// database/migrations/2023_10_01_create_coaches_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachesTable extends Migration
{
    public function up()
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('license_number')->unique();
            $table->string('specialization');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coaches');
    }
}
```

#### c. Migration untuk Tabel `training_programs`

```php
// database/migrations/2023_10_01_create_training_programs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('training_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_id')->constrained()->onDelete('cascade');
            $table->foreignId('coach_id')->constrained()->onDelete('cascade');
            $table->string('program_name');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_programs');
    }
}
```

#### d. Migration untuk Tabel `competitions`

```php
// database/migrations/2023_10_01_create_competitions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionsTable extends Migration
{
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('level', ['local', 'national', 'international']);
            $table->date('date');
            $table->text('location');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('competitions');
    }
}
```

#### e. Migration untuk Tabel `assessments`

```php
// database/migrations/2023_10_01_create_assessments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_id')->constrained()->onDelete('cascade');
            $table->foreignId('competition_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('snatch', 8, 2);
            $table->decimal('clean_jerk', 8, 2);
            $table->decimal('total_lift', 8, 2);
            $table->integer('balance_score')->nullable();
            $table->integer('posture_score')->nullable();
            $table->integer('speed_score')->nullable();
            $table->integer('flexibility_score')->nullable();
            $table->integer('accuracy_score')->nullable();
            $table->integer('control_score')->nullable();
            $table->text('physical_condition')->nullable();
            $table->text('mental_condition')->nullable();
            $table->text('consistency_notes')->nullable();
            $table->text('development_notes')->nullable();
            $table->string('weight_category');
            $table->enum('competition_level', ['local', 'national', 'international'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessments');
    }
}
```

---

### 2. Seeder

#### a. Seeder untuk Tabel `athletes`

```php
// database/seeders/AthleteSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Athlete;

class AthleteSeeder extends Seeder
{
    public function run()
    {
        Athlete::create([
            'name' => 'John Doe',
            'date_of_birth' => '2000-01-01',
            'gender' => 'male',
            'category' => 'Senior',
            'weight_category' => '85 kg',
            'training_history' => '5 years of training',
            'performance_data' => 'Snatch: 150kg, Clean & Jerk: 180kg',
        ]);

        // Tambahkan lebih banyak data dummy jika diperlukan
    }
}
```

#### b. Seeder untuk Tabel `coaches`

```php
// database/seeders/CoachSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coach;

class CoachSeeder extends Seeder
{
    public function run()
    {
        Coach::create([
            'name' => 'Coach Smith',
            'license_number' => 'COACH123',
            'specialization' => 'Weightlifting',
        ]);

        // Tambahkan lebih banyak data dummy jika diperlukan
    }
}
```

#### c. Seeder untuk Tabel `training_programs`

```php
// database/seeders/TrainingProgramSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingProgram;
use App\Models\Athlete;
use App\Models\Coach;

class TrainingProgramSeeder extends Seeder
{
    public function run()
    {
        $athlete = Athlete::first();
        $coach = Coach::first();

        TrainingProgram::create([
            'athlete_id' => $athlete->id,
            'coach_id' => $coach->id,
            'program_name' => 'Strength Training Program',
            'description' => 'Program untuk meningkatkan kekuatan otot dan teknik angkat beban',
            'start_date' => '2023-10-01',
            'end_date' => '2023-12-31',
        ]);

        // Tambahkan lebih banyak data dummy jika diperlukan
    }
}
```

#### d. Seeder untuk Tabel `competitions`

```php
// database/seeders/CompetitionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Competition;

class CompetitionSeeder extends Seeder
{
    public function run()
    {
        Competition::create([
            'name' => 'National Weightlifting Championship',
            'level' => 'national',
            'date' => '2023-11-15',
            'location' => 'Jakarta, Indonesia',
        ]);

        // Tambahkan lebih banyak data dummy jika diperlukan
    }
}
```

#### e. Seeder untuk Tabel `assessments`

```php
// database/seeders/AssessmentSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\Athlete;
use App\Models\Competition;

class AssessmentSeeder extends Seeder
{
    public function run()
    {
        $athlete = Athlete::first();
        $competition = Competition::first();

        Assessment::create([
            'athlete_id' => $athlete->id,
            'competition_id' => $competition->id,
            'snatch' => 150.50,
            'clean_jerk' => 180.75,
            'total_lift' => 331.25,
            'balance_score' => 8,
            'posture_score' => 9,
            'speed_score' => 7,
            'flexibility_score' => 8,
            'accuracy_score' => 9,
            'control_score' => 8,
            'physical_condition' => 'Kebugaran baik, kekuatan otot optimal',
            'mental_condition' => 'Fokus tinggi, mampu mengelola tekanan',
            'consistency_notes' => 'Konsisten dalam latihan dan kompetisi',
            'development_notes' => 'Peningkatan signifikan dalam teknik dan kekuatan',
            'weight_category' => '85 kg',
            'competition_level' => 'national',
        ]);

        // Tambahkan lebih banyak data dummy jika diperlukan
    }
}
```

---

### 3. Model

#### a. Model untuk `Athlete`

```php
// app/Models/Athlete.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date_of_birth',
        'gender',
        'category',
        'weight_category',
        'training_history',
        'performance_data',
    ];

    public function trainingPrograms()
    {
        return $this->hasMany(TrainingProgram::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
```

#### b. Model untuk `Coach`

```php
// app/Models/Coach.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'license_number',
        'specialization',
    ];

    public function trainingPrograms()
    {
        return $this->hasMany(TrainingProgram::class);
    }
}
```

#### c. Model untuk `TrainingProgram`

```php
// app/Models/TrainingProgram.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_id',
        'coach_id',
        'program_name',
        'description',
        'start_date',
        'end_date',
    ];

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
```

#### d. Model untuk `Competition`

```php
// app/Models/Competition.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
        'date',
        'location',
    ];

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
```

#### e. Model untuk `Assessment`

```php
// app/Models/Assessment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_id',
        'competition_id',
        'snatch',
        'clean_jerk',
        'total_lift',
        'balance_score',
        'posture_score',
        'speed_score',
        'flexibility_score',
        'accuracy_score',
        'control_score',
        'physical_condition',
        'mental_condition',
        'consistency_notes',
        'development_notes',
        'weight_category',
        'competition_level',
    ];

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
```

---

### 4. Menjalankan Migration dan Seeder

Jalankan perintah berikut untuk menjalankan migration dan seeder:

```bash
php artisan migrate
php artisan db:seed --class=AthleteSeeder
php artisan db:seed --class=CoachSeeder
php artisan db:seed --class=TrainingProgramSeeder
php artisan db:seed --class=CompetitionSeeder
php artisan db:seed --class=AssessmentSeeder
```

---

### 5. Penjelasan

- **Migration**: Membuat tabel-tabel yang diperlukan untuk sistem manajemen atlet angkat beban.
- **Seeder**: Mengisi data dummy ke dalam tabel untuk pengujian dan pengembangan.
- **Model**: Menyediakan representasi objek dari tabel database dan relasi antar tabel.

Dengan struktur ini, Anda dapat mengelola atlet, pelatih, program pelatihan, kompetisi, dan penilaian secara terstruktur dan efisien.