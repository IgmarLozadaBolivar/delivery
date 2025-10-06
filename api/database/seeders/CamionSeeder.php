<?php

namespace Database\Seeders;

use App\Models\Camion;
use Illuminate\Database\Seeder;

class CamionSeeder extends Seeder
{
    public function run(): void
    {
        Camion::factory(10)->create();
    }
}
