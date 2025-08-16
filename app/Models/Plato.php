<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plato extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'precio', 'categoria', 'imagen_path'
    ];
}

