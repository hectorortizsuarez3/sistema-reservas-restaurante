<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlatoController extends Controller
{
    /**
     * Página pública del menú: lista platos agrupados por categoría.
     */
    public function index()
    {
        $platos = Plato::orderBy('categoria')
            ->orderBy('nombre')
            ->get()
            ->groupBy('categoria');

     // Definimos el orden deseadoen que se listan las categorías
    $ordenCategorias = ['entrantes', 'principales', 'postres'];

    // Reordenamos según ese array
    $platosOrdenados = collect($ordenCategorias)
        ->mapWithKeys(fn($cat) => [$cat => $platos[$cat]]);

    return view('menu', ['platos' => $platosOrdenados]);
    }



    /**
     * Formulario para crear un plato (uso interno).
     */
    public function create()
    {
        return view('platos.create');
    }

    /**
     * Guardar nuevo plato con imagen opcional.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:1000',
            'precio'      => 'required|numeric|min:0',
            'categoria'   => 'required|string|max:50',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $plato = Plato::create([
            'nombre'      => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'precio'      => $validated['precio'],
            'categoria'   => $validated['categoria'],
        ]);

        if ($request->hasFile('imagen')) {
            // Guardar en storage/app/public/platos
            $path = $request->file('imagen')->store('platos', 'public');
            $plato->update(['imagen_path' => $path]);
        }

        return redirect()->route('platos.index')->with('ok', 'Plato creado correctamente.');
    }

    // (De momento no necesitamos show/edit/update/destroy para esta fase.)
}

