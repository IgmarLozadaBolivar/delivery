<?php

namespace Database\Seeders;

use App\Models\Camion;
use App\Models\Camionero;
use Illuminate\Database\Seeder;

class CamioneroCamionSeeder extends Seeder
{
    public function run(): void
    {
        $camioneros = Camionero::all();
        $camiones = Camion::all();

        foreach ($camioneros as $camionero)
        {
            $ids = $camiones->random(rand(1, $camiones->count()))->pluck('id');
            $camionero->camiones()->attach($ids);
        }
    }
}
