<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest; // Form Request con las reglas de validación
use App\Mail\ContactMessage;               // Mailable que construye el email
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Maneja el POST /contacto.     *
     * - La validación del servidor la hace StoreContactRequest automáticamente.
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        // Si llegamos aquí, los datos ya están validados por StoreContactRequest
        $data = $request->validated();

        // Destinatario: tu propio correo configurado en .env
        $to = config('mail.from.address');

        try {
            // Construimos y enviamos el email. Se añade replyTo para poder responder con 1 clic.
            Mail::to($to)->queue(
                (new ContactMessage(
                    nombre:   $data['nombre'],
                    telefono: $data['telefono'] ?? null,
                    email:    $data['email'],
                    mensaje:  $data['mensaje']
                ))->replyTo($data['email'], $data['nombre'])
            );
        } catch (\Throwable $e) {
            // Si falla el envío, dejamos registro y devolvemos al usuario un error genérico
            Log::error('Contacto: error enviando correo', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->withErrors([
                    'general' => 'No se pudo enviar el mensaje ahora mismo. Inténtalo de nuevo en unos minutos.',
                ]);
        }

        // Todo OK: redirige a la vista de contacto con un mensaje de éxito
        return redirect()
            ->route('contacto')
            ->with('status', '¡Gracias! Hemos recibido tu mensaje y te responderemos pronto.');
    }
}
