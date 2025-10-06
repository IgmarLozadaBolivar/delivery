<?php

namespace Database\Factories;

use App\Models\Camionero;
use App\Models\EstadoPaquete;
use App\Models\Paquete;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaqueteFactory extends Factory
{
    protected $model = Paquete::class;

    public function definition(): array
    {
        return [
            'direccion' => $this->faker->address(),

            'camionero_id' => Camionero::factory(),
            'estado_id' => EstadoPaquete::factory(),
        ];
    }
}
