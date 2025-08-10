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

    //2. Guardar reseva
    Reserva::create($validated);

    //3. Mostrar confirmación
    return back()->with('success', "Reserva realizada correctamente");
})->name('reservas.enviar');

Route::get('/contacto', function(){
    return view('contacto');
})->name('contacto');
