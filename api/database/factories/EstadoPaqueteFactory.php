<?php

namespace Database\Factories;

use App\Models\EstadoPaquete;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstadoPaqueteFactory extends Factory
{
    protected $model = EstadoPaquete::class;

    public function definition(): array
    {
        return [
            'estado' => $this->faker->word(),
        ];
    }
}
