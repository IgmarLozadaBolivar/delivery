<?php

namespace Database\Factories;

use App\Models\TipoMercancia;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoMercanciaFactory extends Factory
{
    protected $model = TipoMercancia::class;

    public function definition(): array
    {
        return [
            'tipo' => $this->faker->word(),
        ];
    }
}
