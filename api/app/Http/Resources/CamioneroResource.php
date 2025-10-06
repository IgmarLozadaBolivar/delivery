<?php

namespace App\Http\Resources;

use App\Models\Camionero;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Camionero */
class CamioneroResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'documento' => $this->documento,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'licencia' => $this->licencia,
        ];
    }
}
