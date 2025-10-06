<?php

namespace App\Http\Resources;

use App\Models\EstadoPaquete;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EstadoPaquete */
class EstadoPaqueteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'estado' => $this->estado,
        ];
    }
}
