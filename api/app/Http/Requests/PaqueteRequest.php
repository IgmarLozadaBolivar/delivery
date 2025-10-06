<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PaqueteRequest extends FormRequest
{
    public function rules(): array
    {
        $user = auth()->user();

        if ($this->isMethod('PUT') || $this->isMethod('POST'))
        {
            if ($user->hasRole('admin'))
            {
                return [
                    'camionero_id' => ['required', 'exists:camioneros,id'],
                    'estado_id'    => ['required', 'exists:estados_paquetes,id'],
                    'direccion'    => ['required', 'string', 'max:70'],
                ];
            }

            return []; // Para camionero está prohibido
        }

        if ($this->isMethod('PATCH'))
        {
            if ($user->hasRole('admin'))
            {
                return [
                    'camionero_id' => ['sometimes', 'exists:camioneros,id'],
                    'estado_id'    => ['sometimes', 'exists:estados_paquetes,id'],
                    'direccion'    => ['sometimes', 'string', 'max:70'],
                ];
            }

            return [
                'estado_id' => ['required', 'exists:estados_paquetes,id'],
            ];
        }

        return [];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            api_validation("Se requiere los campos necesarios para continuar", $validator->errors()->toArray())
        );
    }
}
