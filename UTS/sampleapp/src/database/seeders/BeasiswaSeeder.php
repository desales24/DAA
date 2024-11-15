<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Beasiswa;

class BeasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Beasiswa::create([
            'nama' => 'usep',
            'nim' => '12345678910',
            'nominal uang di terima' => 'Rp. 900000'
        ]);
    }
}
