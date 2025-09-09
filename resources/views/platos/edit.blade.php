@extends('layout')

@section('content')
<h1>Editar plato</h1>

@if ($errors->any())
  <div style="color:red;">
    <ul>
      @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('platos.update', $plato) }}" method="POST" enctype="multipart/form-data" style="max-width:480px;">
  @csrf
  @method('PUT')

  <label style="display:block; margin-bottom:.5rem;">Nombre</label>
  <input type="text" name="nombre" value="{{ old('nombre', $plato->nombre) }}" required maxlength="100" style="width:100%; padding:.4rem;">
  <br><br>

  <label style="display:block; margin-bottom:.5rem;">Descripción</label>
  <textarea name="descripcion" rows="3" maxlength="1000" style="width:100%; padding:.4rem;">{{ old('descripcion', $plato->descripcion) }}</textarea>
  <br><br>

  <label style="display:block; margin-bottom:.5rem;">Precio (€)</label>
  <input type="number" name="precio" step="0.01" min="0" value="{{ old('precio', $plato->precio) }}" required style="width:100%; padding:.4rem;">
  <br><br>

  <label style="display:block; margin-bottom:.5rem;">Categoría</label>
  @php $cat = old('categoria', $plato->categoria); @endphp
  <select name="categoria" required style="width:100%; padding:.4rem;">
    <option value="">-- Elige --</option>
    <option value="entrantes"   @selected($cat==='entrantes')>Entrantes</option>
    <option value="principales" @selected($cat==='principales')>Platos principales</option>
    <option value="postres"     @selected($cat==='postres')>Postres</option>
    <option value="bebidas"     @selected($cat==='bebidas')>Bebidas</option>
  </select>
  <br><br>

  <label style="display:block; margin-bottom:.5rem;">Imagen (opcional)</label>
  @if($plato->imagen_path)
    <p>Actual: <em>{{ $plato->imagen_path }}</em></p>
  @endif
  <input type="file" name="imagen" accept="image/*">
  <br><br>

  <button type="submit">Guardar cambios</button>
</form>

<p style="margin-top:1rem;">
  <a href="{{ route('platos.index') }}">← Volver</a>
</p>
@endsection
