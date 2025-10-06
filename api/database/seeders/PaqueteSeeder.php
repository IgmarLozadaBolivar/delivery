<?php

namespace Database\Seeders;

use App\Models\Camionero;
use App\Models\EstadoPaquete;
use App\Models\Paquete;
use Illuminate\Database\Seeder;

class PaqueteSeeder extends Seeder
{
    public function run(): void
    {
        $camioneros = Camionero::pluck('id')->toArray();
        $estados = EstadoPaquete::pluck('id')->toArray();

        Paquete::factory(50)->create([
            'camionero_id' => fn () => fake()->randomElement($camioneros),
            'estado_id' => fn () => fake()->randomElement($estados),
        ]);    }
}
