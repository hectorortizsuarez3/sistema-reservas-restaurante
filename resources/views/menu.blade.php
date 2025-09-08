@extends('layout')

@section('content')
<h1>Menu</h1>
@if (session('ok'))
    {{ session('ok') }}
@endif

@isset($platos)
    @forelse ($platos as $categoria => $lista)
        <h2>{{ ucfirst($categoria) }}</h2>
        <ul>
            @foreach ($lista as $plato)
                <li>
                    @if ($plato->imagen_path)
                        <img
                            src="{{ asset('storage/'.$plato->imagen_path) }}"
                            alt="Foto {{ $plato->nombre }}"
                            width="120" height="120"
                        >
                    @endif
                    <div>
                        <strong>{{ $plato->nombre }}</strong>
                        — {{ number_format($plato->precio, 2) }} €
                        @if($plato->descripcion)
                            {{ $plato->descripcion }}
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