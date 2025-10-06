<?php

namespace App\Http\Resources;

use App\Models\Camion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Camion */
class CamionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'placa' => $this->placa,
            //'camioneros_count' => $this->camioneros_count,
        ];
    }
}
