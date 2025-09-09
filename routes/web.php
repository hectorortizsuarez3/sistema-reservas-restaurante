<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaConfirmada;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PlatoController;
use App\Http\Controllers\GerenciaReservasController;

//Pestaña de inicio
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

//Rutas del menu
    //Ruta pública
Route::get('/menu', [PlatoController::class, 'index'])->name('menu');

    //Rutas internas (protegidas con autenticación básica)
Route::middleware('auth.basic')->group(function () {
    Route::get('/platos/editar', [PlatoController::class, 'manage'])->name('platos.manage');
    Route::resource('platos', PlatoController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});



//Pestaña reservas
Route::get('/reservas', [ReservaController::class, 'create'])->name('reservas');
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.enviar');

//Pestaña de contacto
Route::get('/contacto', function(){
    return view('contacto');
})->name('contacto');

//Procesamiento del formulario:
Route::post('/contacto', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')  //máximo 5 solicitudes/min/cliente
    ->name('contacto.enviar');

//Rutas para ver las reservas (solo para gerencia)
Route::middleware('auth.basic')->group(function () {
    Route::get('/gerencia/reservas', [GerenciaReservasController::class, 'index'])
        ->name('reservas.index');
});
