<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'correo' => 'required|string',
            'contrasena' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'correo.required' => 'El correo es obligatorio',
            'contrasena.required' => 'La contraseña es obligatoria',

            'correo.string' => 'El correo debe ser string',
            'contrasena.string' => 'La contraseña debe ser string',

            'contrasena.min' => 'La contraseña debe tener mínimo 6 caracteres.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $errorMessage = array_shift($errors)[0] ?? '';
        throw new HttpResponseException(
            response()->json([
                'error' => "Parametros Incorrectos",
                'mensaje' => $errorMessage
            ], 422)
        );
    }
}
