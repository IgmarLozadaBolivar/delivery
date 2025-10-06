<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CamionRequest extends FormRequest
{
    public function rules(): array
    {

        $user = auth()->user();

        if ($this->isMethod('PATCH'))
        {
            if ($user->hasRole('admin'))
            {
                return [
                    'marca' => ['sometimes', 'string', 'max:50'],
                    'modelo' => ['sometimes', 'string', 'max:50'],
                    'placa' => ['sometimes', 'string', 'max:10', 'unique:camiones,placa'],
                ];
            }
        } else {
            if ($user->hasRole('admin'))
            {
                return [
                    'marca' => ['required', 'string', 'max:50'],
                    'modelo' => ['required', 'string', 'max:50'],
                    'placa' => ['required', 'string', 'max:10', 'unique:camiones,placa'],
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
