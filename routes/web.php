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

//Pestaña de inicio
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

//Rutas del menu
Route::get('/menu', [PlatoController::class, 'index'])->name('menu');
Route::resource('platos', PlatoController::class)->only(['index', 'create', 'store']);




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
use App\Http\Controllers\GerenciaReservasController;

Route::prefix('gerencia')->name('gerencia.')->group(function () {
    Route::get('/reservas', [GerenciaReservasController::class, 'index'])
        ->name('reservas.index');
});
