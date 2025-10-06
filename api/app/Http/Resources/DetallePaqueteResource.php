<?php

namespace App\Http\Resources;

use App\Models\DetallePaquete;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin DetallePaquete */
class DetallePaqueteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'paquete_id' => $this->paquete_id,
            'tipo_mercancia_id' => $this->tipo_mercancia_id,
            'dimension' => $this->dimension,
            'peso' => $this->peso,
            'fecha_entrega' => $this->fecha_entrega,

            'paquetes' => new PaqueteResource($this->whenLoaded('paquete')),
            'tipos_mercancias' => new TipoMercanciaResource($this->whenLoaded('tipoMercancia')),
        ];
    }
}
