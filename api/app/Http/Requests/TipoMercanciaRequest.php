<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoMercanciaRequest extends FormRequest
{
    public function rules(): array
    {
        $user = auth()->user();

        if ($this->isMethod('PATCH'))
        {
            if ($user->hasRole('admin'))
            {
                return [
                    'tipo' => ['sometimes', 'string', 'max:50']
                ];
            }

        } else {
            if ($user->hasRole('admin'))
            {
                return [
                    'tipo' => ['required', 'string', 'max:50']
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
