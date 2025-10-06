<?php

namespace Database\Factories;

use App\Models\DetallePaquete;
use App\Models\Paquete;
use App\Models\TipoMercancia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DetallePaqueteFactory extends Factory
{
    protected $model = DetallePaquete::class;

    public function definition(): array
    {
        return [
            'dimension' => $this->faker->bothify('##x##'),
            'peso' => $this->faker->randomFloat(2, 1, 500),
            'fecha_entrega' => $this->faker->date(),

            'paquete_id' => Paquete::factory(),
            'tipo_mercancia_id' => TipoMercancia::factory(),
        ];
    }
}
