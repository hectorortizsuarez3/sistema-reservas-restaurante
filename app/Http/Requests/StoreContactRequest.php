<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Autoriza esta petición para usuarios no autenticados (formulario público).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación del servidor.
     *
     * - nombre: requerido, mínimo 2, máximo 100.
     * - telefono: opcional; si viene, debe seguir patrón general (opcional + + 7–15 dígitos).
     * - email: requerido y con formato válido (RFC + DNS).
     * - mensaje: requerido, mínimo 8, máximo 500.
     * - website: honeypot anti-spam (campo oculto en la vista); si viene con valor => error.
     */
    public function rules(): array
    {
        return [
            'nombre'   => ['required', 'string', 'min:2', 'max:100'],
            'telefono' => ['nullable', 'regex:/^\+?\d{7,15}$/'],
            'email'    => ['required', 'email:rfc,dns', 'max:255'],
            'mensaje'  => ['required', 'string', 'min:8', 'max:500'],
            'website'  => ['nullable', 'prohibited'], // honeypot
        ];
    }

    /**
     * Mensajes personalizados (más claros para el usuario).
     */
    public function messages(): array
    {
        return [
            'nombre.required'    => 'El nombre es obligatorio.',
            'nombre.min'         => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.max'         => 'El nombre no puede superar los 100 caracteres.',

            'telefono.regex'     => 'El teléfono debe tener entre 7 y 15 dígitos y puede empezar por +.',

            'email.required'     => 'El email es obligatorio.',
            'email.email'        => 'El email no tiene un formato válido.',
            'email.max'          => 'El email no puede superar los 255 caracteres.',

            'mensaje.required'   => 'El mensaje es obligatorio.',
            'mensaje.min'        => 'El mensaje debe tener al menos 8 caracteres.',
            'mensaje.max'        => 'El mensaje no puede superar los 500 caracteres.',

            'website.prohibited' => 'Detección de spam.',
        ];
    }

    /**
     * Nombres de atributos amigables en los mensajes de error.
     */
    public function attributes(): array
    {
        return [
            'nombre'   => 'nombre',
            'telefono' => 'teléfono',
            'email'    => 'email',
            'mensaje'  => 'mensaje',
        ];
    }
}

