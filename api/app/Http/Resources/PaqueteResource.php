<?php

namespace App\Http\Resources;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Paquete */
class PaqueteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'camionero' => new CamioneroResource($this->whenLoaded('camionero')),
            'estado' => new EstadoPaqueteResource($this->whenLoaded('estadoPaquete')),
            'direccion' => $this->direccion
        ];
    }
}
