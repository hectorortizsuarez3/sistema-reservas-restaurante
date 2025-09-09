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

        return redirect()->route('platos.manage')->with('ok', 'Plato creado correctamente.');
    }

    public function edit(Plato $plato)
{
    return view('platos.edit', compact('plato'));
}

public function update(Request $request, Plato $plato)
{
    $validated = $request->validate([
        'nombre'      => 'required|string|max:100',
        'descripcion' => 'nullable|string|max:1000',
        'precio'      => 'required|numeric|min:0',
        'categoria'   => 'required|string|max:50',
        'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $plato->update([
        'nombre'      => $validated['nombre'],
        'descripcion' => $validated['descripcion'] ?? null,
        'precio'      => $validated['precio'],
        'categoria'   => $validated['categoria'],
    ]);

    if ($request->hasFile('imagen')) {
        if ($plato->imagen_path) {
            \Storage::disk('public')->delete($plato->imagen_path);
        }
        $path = $request->file('imagen')->store('platos', 'public');
        $plato->update(['imagen_path' => $path]);
    }

    return redirect()->route('platos.manage')->with('ok', 'Plato actualizado.');
}

public function destroy(Plato $plato)
{
    if ($plato->imagen_path) {
        \Storage::disk('public')->delete($plato->imagen_path);
    }
    $plato->delete();

    return redirect()->route('platos.manage')->with('ok', 'Plato eliminado.');
}
    // app/Http/Controllers/PlatoController.php

public function manage(Request $request)
{
    $query = Plato::query()->orderBy('categoria')->orderBy('nombre');

    // filtro opcional por categoría (?cat=entrantes, etc.)
    if ($request->filled('cat')) {
        $query->where('categoria', $request->string('cat'));
    }

    $platos = $query->get();

    return view('platos.manage', compact('platos'));
}


}

