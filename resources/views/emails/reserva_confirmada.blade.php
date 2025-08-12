@php
    use Carbon\Carbon;
    $fechaBonita = Carbon::parse($reserva->fecha)->format('d-m-Y');
@endphp

@component('mail::message')
# ¡Reserva confirmada!

Hola **{{ $reserva->nombre }}**,

Tu reserva se ha realizado correctamente:

- **Número de reserva:** R-000{{ $reserva->id }}
- **Fecha:** {{ $fechaBonita }}
- **Hora:** {{ $reserva->hora }}
- **Personas:** {{ $reserva->personas }}

@component('mail::button', ['url' => url('/')])
Visitar web
@endcomponent

Si necesitas modificar o cancelar tu reserva, responde a este correo o llámenos al tlf XXX XXX XXX.

Gracias,  
**Restaurante Cuatro Caminos**
@endcomponent


