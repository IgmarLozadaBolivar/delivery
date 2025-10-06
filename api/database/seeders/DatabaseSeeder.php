<?php

namespace Database\Seeders;

use App\Models\Camionero;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class
        ]);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            //'role' => 'admin'
        ]);
        $user->assignRole('admin');

        User::factory(10)->create([
            //'role' => 'camionero'
        ])->each(function ($user) {
            $user->assignRole('camionero');
            Camionero::factory()->create([
                'user_id' => $user->id
            ]);
        });

        $this->call([
            TipoMercanciaSeeder::class,
            EstadoPaqueteSeeder::class,
            CamionSeeder::class,
//            CamioneroSeeder::class,
            CamioneroCamionSeeder::class,
            PaqueteSeeder::class,
            DetallePaqueteSeeder::class
        ]);
    }
}
