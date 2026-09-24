<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'email' => 'Correo Electrónico',
            'password' => 'Contraseña',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El :attribute es obligatorio.',
            'email.email' => 'El :attribute debe ser una dirección de correo electrónico válida.',
            'password.required' => 'La :attribute es obligatoria.',
            'password.string' => 'La :attribute debe ser una cadena de texto.'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
