@extends('layout')

@section('content')
<h1>Nuevo plato</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('platos.store') }}" method="POST" enctype="multipart/form-data" style="max-width:480px;">
    @csrf

    <label style="display:block; margin-bottom:.5rem;">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre') }}" required maxlength="100" style="width:100%; padding:.4rem;">
    <br><br>

    <label style="display:block; margin-bottom:.5rem;">Descripción</label>
    <textarea name="descripcion" rows="3" maxlength="1000" style="width:100%; padding:.4rem;">{{ old('descripcion') }}</textarea>
    <br><br>

    <label style="display:block; margin-bottom:.5rem;">Precio (€)</label>
    <input type="number" name="precio" step="0.01" min="0" value="{{ old('precio') }}" required style="width:100%; padding:.4rem;">
    <br><br>

    <label style="display:block; margin-bottom:.5rem;">Categoría</label>
    <select name="categoria" required style="width:100%; padding:.4rem;">
        <option value="">-- Elige --</option>
        <option value="entrantes"   @selected(old('categoria')==='entrantes')>Entrantes</option>
        <option value="principales" @selected(old('categoria')==='principales')>Platos principales</option>
        <option value="postres"     @selected(old('categoria')==='postres')>Postres</option>
        <option value="bebidas"     @selected(old('categoria')==='bebidas')>Bebidas</option>
    </select>
    <br><br>

    <label style="display:block; margin-bottom:.5rem;">Imagen (opcional)</label>
    <input type="file" name="imagen" accept="image/*">
    <br><br>

    <button type="submit">Guardar</button>
</form>

<p style="margin-top:1rem;">
    <a href="{{ route('menu') }}">← Volver al menú</a>
</p>
@endsection
