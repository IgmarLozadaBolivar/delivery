<?php

namespace Database\Factories;

use App\Models\Camion;
use Database\Fakers\TruckFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

class CamionFactory extends Factory
{
    protected $model = Camion::class;

    public function definition(): array
    {
        $this->faker->addProvider(new TruckFaker($this->faker));

        return [
            'marca' => $this->faker->truckBrand(),
            'modelo' => $this->faker->truckModel(),
            'placa' => strtoupper($this->faker->bothify('???###')),
        ];
    }
}
