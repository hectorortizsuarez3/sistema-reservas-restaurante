<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

Route::get('/menu', function() {
    return view('menu');
})->name('menu');

Route::get('/reservas', function() {
    return view('reservas');
})->name('reservas');

Route::get('/contacto', function(){
    return view('contacto');
})->name('contacto');
