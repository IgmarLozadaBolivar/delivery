<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CamioneroRequest extends FormRequest
{
    public function rules(): array
    {
        $user = auth()->user();

        if ($this->isMethod('PATCH'))
        {
            if ($user->hasRole('admin'))
            {
                return [
                    'user_id' => ['required', 'exists:users,id'],
                    'documento' => ['sometimes', 'max:10', 'unique:camioneros,documento'],
                    'fecha_nacimiento' => ['sometimes', 'date', 'before_or_equal:' . now()->subYears(18)->toDateString()],
                    'licencia' => ['sometimes', 'max:2']
                ];
            }
        } else {
            if ($user->hasRole('admin'))
            {
                return [
                    'user_id' => ['required', 'exists:users,id'],
                    'documento' => ['required', 'max:10', 'unique:camioneros,documento'],
                    'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->toDateString()],
                    'licencia' => ['required', 'max:2']
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
