@extends('layout')

@section('content')
<h1>Gestionar platos</h1>

@if(session('ok'))
  <div style="color:green; margin:.5rem 0">{{ session('ok') }}</div>
@endif

<div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap; margin:.5rem 0 1rem;">
  <a href="{{ route('platos.create') }}" style="padding:.4rem .6rem; border:1px solid #ccc; border-radius:6px;">+ Añadir plato</a>

  <form method="GET" action="{{ route('platos.manage') }}">
    <label>Categoría:
      <select name="cat" onchange="this.form.submit()">
        @php $catSel = request('cat'); @endphp
        <option value="">Todas</option>
        <option value="entrantes"   @selected($catSel==='entrantes')>Entrantes</option>
        <option value="principales" @selected($catSel==='principales')>Platos principales</option>
        <option value="postres"     @selected($catSel==='postres')>Postres</option>
        <option value="bebidas"     @selected($catSel==='bebidas')>Bebidas</option>
      </select>
    </label>
    @if($catSel)
      <a href="{{ route('platos.manage') }}" style="margin-left:.5rem;">Limpiar</a>
    @endif
  </form>
</div>

<table border="1" cellpadding="8" cellspacing="0" style="width:100%; max-width:900px;">
  <thead>
    <tr>
      <th style="text-align:left;">Nombre</th>
      <th style="text-align:left;">Categoría</th>
      <th style="text-align:right;">Precio</th>
      <th style="text-align:center; width:160px;">Acciones</th>
    </tr>
  </thead>
  <tbody>
  @forelse($platos as $plato)
    <tr>
      <td>{{ $plato->nombre }}</td>
      <td>{{ ucfirst($plato->categoria) }}</td>
      <td style="text-align:right;">{{ number_format($plato->precio, 2) }} €</td>
      <td style="text-align:center; white-space:nowrap;">
        <a href="{{ route('platos.edit', $plato) }}">Editar</a>
        &nbsp;|&nbsp;
        
        <form action="{{ route('platos.destroy', $plato) }}" method="POST" style="display:inline"
            onsubmit="return confirm('¿Seguro que quieres eliminar el plato {{ $plato->nombre }}?');">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>

      </td>
    </tr>
  @empty
    <tr><td colspan="4">No hay platos.</td></tr>
  @endforelse
  </tbody>
</table>

<p style="margin-top:1rem;">
  <a href="{{ route('menu') }}">← Ver menú público</a>
</p>
@endsection
