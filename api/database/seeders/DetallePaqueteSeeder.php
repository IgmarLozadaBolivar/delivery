<?php

namespace Database\Seeders;

use App\Models\DetallePaquete;
use App\Models\Paquete;
use App\Models\TipoMercancia;
use Illuminate\Database\Seeder;

class DetallePaqueteSeeder extends Seeder
{
    public function run(): void
    {
        $paquetes = Paquete::pluck('id')->toArray();
        $tipos_mercancias = TipoMercancia::pluck('id')->toArray();

        DetallePaquete::factory(50)->create([
            'paquete_id' => fn () => fake()->randomElement($paquetes),
            'tipo_mercancia_id' => fn () => fake()->randomElement($tipos_mercancias)
        ]);
    }
}
