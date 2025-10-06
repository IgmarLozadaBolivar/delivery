<?php

namespace Database\Factories;

use App\Models\Camionero;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CamioneroFactory extends Factory
{
    protected $model = Camionero::class;

    public function definition(): array
    {
        $users = User::pluck('id')->toArray();
        $idCamioneros = null;

        if ($users != 1)
        {
            $idCamioneros = $users;
        }

        return [
            'documento' => $this->faker->numerify('##########'),
            'fecha_nacimiento' => $this->faker->date(),
            'licencia' => $this->faker->randomElement(['C2', 'C3']),

            'user_id' => $this->faker->randomElement($idCamioneros),
        ];
    }
}
