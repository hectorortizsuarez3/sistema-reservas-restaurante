<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaConfirmada;

class ReservaController extends Controller
{
    //método para devolver la vista de reservas
    //De momento sin lógica, pero se puede añadir más a futuro
public function create() {
    return view('reservas');
}

    public function store(Request $request)
    {
        // Validar
        $validated = $request->validate([
            'nombre'   => 'required|string|max:100',
            'telefono' => 'required|string|max:20',
            'email'    => 'required|email|max:255',
            'fecha'=> 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'personas' => 'required|integer|min:1|max:6',
            'mensaje'  => 'nullable|string|max:500',
        ],
        //Mensaje personalizado en caso de fecha pasada
        [
        'fecha.after_or_equal' => 'La fecha debe ser igual o posterior a hoy.'
        ]
    
    );

        // Determinar turno
        $hora = $validated['hora'];
        $turnoMediodia = ['13:00','13:30','14:00','14:30'];
        $turnoNoche    = ['21:00','21:30','22:00'];

        if (in_array($hora, $turnoMediodia, true)) {
            $horasTurno = $turnoMediodia;
            $nombreTurno = 'mediodía';
        } else {
            $horasTurno = $turnoNoche;
            $nombreTurno = 'noche';
        }

        // Comprobar ocupación
        $ocupacionActual = Reserva::whereDate('fecha', $validated['fecha'])
            ->whereIn('hora', $horasTurno)
            ->sum('personas');

        $capacidadTurno = 20;
        $solicitadas = (int) $validated['personas'];

        if ($ocupacionActual + $solicitadas > $capacidadTurno) {
            $disponibles = max($capacidadTurno - $ocupacionActual, 0);
            $fechaFormateada = Carbon::parse($validated['fecha'])->format('d-m-Y');

            return back()
                ->withErrors([
                    'personas' => "No hay suficientes plazas en el turno de $nombreTurno para el $fechaFormateada. Solo quedan $disponibles plazas disponibles."
                ])
                ->withInput();
        }

        // Guardar reserva
        $reserva = Reserva::create($validated);

        // Enviar email
        Mail::to($reserva->email)->queue(new ReservaConfirmada($reserva));

        // Respuesta
        return back()->with('success', "Reserva realizada correctamente.
        Su número de reserva es <b>R-000{$reserva->id}</b>");
    }
}

