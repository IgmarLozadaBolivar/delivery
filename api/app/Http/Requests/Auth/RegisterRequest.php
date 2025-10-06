<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:6'
            ],
            'telefono' => [
                'required',
                'max:15',
                'unique:users,telefono'
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
