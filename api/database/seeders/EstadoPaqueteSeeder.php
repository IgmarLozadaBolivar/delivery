<?php

namespace Database\Seeders;

use App\Models\EstadoPaquete;
use Illuminate\Database\Seeder;

class EstadoPaqueteSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ["estado" => "Pendiente"],
            ["estado" => "En bodega"],
            ["estado" => "En tránsito"],
            ["estado" => "En reparto"],
            ["estado" => "Entregado"],
            ["estado" => "Devuelto"],
            ["estado" => "Cancelado"]
        ];

        EstadoPaquete::insert($estados);
    }
}
