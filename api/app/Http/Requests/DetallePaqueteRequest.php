<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetallePaqueteRequest extends FormRequest
{
    public function rules(): array
    {
        $user = auth()->user();

        if ($this->isMethod('PATCH'))
        {
            if ($user->hasRole('admin'))
            {
                return [
                    'paquete_id' => ['sometimes', 'exists:paquetes,id'],
                    'tipo_mercancia_id' => ['sometimes', 'exists:tipos_mercancias,id'],
                    'dimension' => ['sometimes', 'max:45', 'string', 'regex:/^\d+x\d+x\d+$/'],
                    'peso' => ['sometimes', 'numeric', 'gt:0'],
                    'fecha_entrega' => ['sometimes', 'date', 'after_or_equal:today'],
                ];
            }

        } else {
            if ($user->hasRole('admin'))
            {
                return [
                    'paquete_id' => ['required', 'exists:paquetes,id'],
                    'tipo_mercancia_id' => ['required', 'exists:tipos_mercancias,id'],
                    'dimension' => ['required', 'max:45', 'string', 'regex:/^\d+x\d+x\d+$/'],
                    'peso' => ['required', 'numeric', 'gt:0'],
                    'fecha_entrega' => ['required', 'date', 'after_or_equal:today'],
                ];
            }

        }

        return [];
    }

    public function authorize(): bool
    {
        return true;
    }
}
