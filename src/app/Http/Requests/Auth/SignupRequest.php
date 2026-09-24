<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nombre',
            'email' => 'Correo Electrónico',
            'password' => 'Contraseña',
            'password_confirmation' => 'Confirmación de Contraseña',
        ];
    }

    public function messages(): array
    {
        return [
            // Name
            'name.required' => 'El nombre es obligatorio.',
            'name.string'   => 'El nombre debe ser una cadena de texto.',
            'name.max'      => 'El nombre no puede tener más de 255 caracteres.',

            // Email
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string'   => 'El correo electrónico debe ser una cadena de texto.',
            'email.email'    => 'Debes ingresar un correo electrónico válido.',
            'email.max'      => 'El correo electrónico no puede tener más de 255 caracteres.',
            'email.unique'   => 'Este correo electrónico ya está registrado.',

            // Password
            'password.required'  => 'La contraseña es obligatoria.',
            'password.string'    => 'La contraseña debe ser una cadena de texto.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.uncompromised' => 'La contraseña ingresada ha sido expuesta en una filtración de datos. Por favor, elige una diferente.',
        ];
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ];
    }
}
