<?php

namespace Database\Seeders;

use App\Models\TipoMercancia;
use Illuminate\Database\Seeder;

class TipoMercanciaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ["tipo" => "Electrónicos"],
            ["tipo" => "Alimentos perecedores"],
            ["tipo" => "Alimentos no perecedores"],
            ["tipo" => "Materiales de construcción"],
            ["tipo" => "Químicos peligrosos"],
            ["tipo" => "Medicamentos"],
            ["tipo" => "Vehículos y partes"],
            ["tipo" => "Documentos"]
        ];

        TipoMercancia::insert($tipos);
    }
}
