<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|min:3',
            'correo' => 'required|string|unique:users,email',
            'movil' => 'required|integer|regex:/^(1-)?\d{10}$/',
        ];
    }


    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'correo.required' => 'El correo es obligatorio',
            'movil.required' => 'El móvil es obligatorio',

            'nombre.string' => 'El nombre debe ser string',
            'correo.string' => 'El correo debe ser string',
            'movil.integer' => 'El móvil debe ser numerico',

            'nombre.min' => 'El nombre debe contener mínimo 3 caracteres.',
            'correo.unique' => 'Este correo ya existe',
            'movil.regex' => 'El móvil debe ser uno valido',
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
