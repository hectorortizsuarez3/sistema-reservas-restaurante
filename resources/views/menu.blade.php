@extends('layout')

@section('content')
<h1>Menu</h1>
@if (session('ok'))
    <div style="color: green; margin-bottom: 1rem;">{{ session('ok') }}</div>
@endif

@isset($platos)
    @forelse ($platos as $categoria => $lista)
        <h2 style="margin-top:1.5rem;">{{ ucfirst($categoria) }}</h2>
        <ul style="list-style:none; padding-left:0;">
            @foreach ($lista as $plato)
                <li style="margin-bottom:1rem; display:flex; gap:1rem; align-items:flex-start;">
                    @if ($plato->imagen_path)
                        <img
                            src="{{ asset('storage/'.$plato->imagen_path) }}"
                            alt="Foto {{ $plato->nombre }}"
                            width="120" height="120"
                            style="object-fit:cover; border-radius:8px;"
                        >
                    @endif
                    <div>
                        <strong>{{ $plato->nombre }}</strong>
                        — {{ number_format($plato->precio, 2) }} €
                        @if($plato->descripcion)
                            <div style="color:#555;">{{ $plato->descripcion }}</div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @empty
        <p>No hay platos todavía.</p>
    @endforelse
@else
    <p>No hay datos de menú.</p>
@endisset

@endsection