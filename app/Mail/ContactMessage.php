<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nombre,
        public ?string $telefono,
        public string $email,
        public string $mensaje
    ) {}

    public function build()
    {
        // El "from" ya lo toma de MAIL_FROM_* del .env
        return $this->subject('Nuevo mensaje de contacto')
            ->view('emails.contacto')
            ->with([
                'nombre'   => $this->nombre,
                'telefono' => $this->telefono,
                'email'    => $this->email,
                'mensaje'  => $this->mensaje,
            ]);
    }
}
