<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Reserva;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

Route::get('/menu', function() {
    return view('menu');
})->name('menu');

Route::get('/reservas', function() {
    return view('reservas');
})->name('reservas');

Route::post('/reservas', function(Request $request) {
    //1. Validar
    $validated = $request->validate([
        'nombre'   => 'required|string|max:100',
        'telefono' => 'required|string|max:20',
        'email'    => 'required|email|max:255',
        'fecha'=> 'required|date|after_or_equal:today',
        'hora' => 'required|date_format:H:i',
        'personas' => 'required|integer|min:1|max:6',
        'mensaje'  => 'nullable|string|max:500',
    ]);

    // 2) Determinar el turno según la hora solicitada
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

    // 3) Calcular ocupación actual del turno para esa fecha
    $ocupacionActual = \App\Models\Reserva::query()
        ->whereDate('fecha', $validated['fecha'])
        ->whereIn('hora', $horasTurno)
        ->sum('personas');

    $capacidadTurno = 20;
    $solicitadas = (int) $validated['personas'];

    if ($ocupacionActual + $solicitadas > $capacidadTurno) {
        $disponibles = max($capacidadTurno - $ocupacionActual, 0);
        return back()
            ->withErrors([
                'personas' => "No hay suficientes plazas en el turno de $nombreTurno para el {$validated['fecha']}. Solo quedan $disponibles plazas disponibles."
            ])
            ->withInput();
    }

    //4. Guardar reseva
    \App\Models\Reserva::create($validated);

    //3. Mostrar confirmación
    return back()->with('success', "Reserva realizada correctamente");
})->name('reservas.enviar');

Route::get('/contacto', function(){
    return view('contacto');
})->name('contacto');
